<?php

namespace App\Services;

use App\Mail\AppointmentLetter;
use App\Models\Assignment;
use App\Models\Model;
use App\Models\Letter;
use App\Models\Term;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\TestResponse;

/**
 * Class SentLetterService
 * @package App\Services
 */
class LetterService extends APIService
{
    /**
     * @var array
     */
    protected array $assignment_ids = [];
    /**
     * @var array
     */
    protected array $non_course_assignment_ids = [];
    /**
     * @var array
     */
    protected array $from_user_id;
    /**
     * @var array
     */
    protected array $pivot_data;
    /**
     * @var array
     */
    protected array $assignment_id;

    /**
     * SentLetterService constructor.
     *
     * @param  Request  $request
     * @param  Letter  $letter
     *
     * @throws Exception
     */
    public function __construct(Request $request, Letter $letter)
    {
        $this->setModel($letter);
        parent::__construct($request);
    }

    /**
     * @param  Request  $request
     */
    public function setRequestValues(Request $request): void
    {
        $this->request_values            = $request->except([
            'assignment_ids',
            'non_course_assignment_ids',
            'from_user_id',
            'assignment_id'
        ]);
        $this->assignment_ids            = $request->only('assignment_ids');
        $this->non_course_assignment_ids = $request->only('non_course_assignment_ids');
        $this->from_user_id              = $request->only('from_user_id');
        $this->assignment_id             = $request->only('assignment_id');
    }

    /**
     * @return Collection | null
     */
    public function getLettersByAssignment(): ?Collection
    {
        $query = $this->model;

        if ([] !== $this->assignment_id) {
            $query = Assignment::where('id', $this->assignment_id['assignment_id'])->get()->first()->letters();
        }

        $this->count = $query->count();

        if (false === $this->error) {

            return $query->get();
        }

        return null;
    }

    /**
     * @param  Request  $request
     *
     * @return array|null
     */
    public function sendAppointmentLetter(Request $request)
    {
        // TEMPORARY FOR DEVELOPMENT
        $coder_ids = [1, 2, 3];
        // TEMPORARY FOR DEVELOPMENT

        // get name of the term
        $term_model = new Term;
        $query      = $term_model
            ->where('id', $this->request_values['term_id'])
            ->get();
        $term_name  = $query[0]['name'];

        // get name & address of recipient
        $user_model = new User;
        $query      = $user_model
            ->where('id', $this->request_values['user_id'])
            ->get();

        $to_name    = $query[0]['first_name'].' '.$query[0]['last_name'];
        $to_address = $query[0]['email'];

        // get address of sender
        $query = $user_model
            ->where('id', $this->from_user_id)
            ->get();

        $from_address = $query[0]['email'];

        // TEMPORARY FOR DEVELOPMENT
        // if the recipient is not a coder, send the email to the sender
        if ( ! in_array($this->request_values['user_id'], $coder_ids)) {
            $to_address = $from_address;
        }
        // TEMPORARY FOR DEVELOPMENT

        $letter_data = [
            'term_name'   => 'Term 2020',
            'to_name'     => 'Sender Name',
            'subject'     => $term_name.' Contract Letter for '.$to_name,
            'letter_body' => $this->request_values['body'],
        ];

        Mail::to($to_address)->send(new AppointmentLetter($letter_data));

        $this->storeLetter($request);

        return [
            'error'           => false,
            'success_message' => 'Email sent Successfully to '.$to_name
        ];
    }

    /**
     * @param  Request  $request
     *
     * @return Model|null
     */
    public function storeLetter(Request $request): ?Model
    {
        $letter = parent::store($request);

        if (null !== $letter) {

            if ([] !== $this->assignment_ids) {
                // the line below is necessary when using only() to get assignment_ids
                // from the original request (line 60). get() and input() both cause errors
                // if the incoming assignment_ids array is empty
                $ids = $this->assignment_ids['assignment_ids'];
                foreach ($ids as $assignment_id) {
                    // update pivot table assignments_letters
                    $letter->assignments()->attach($assignment_id);
                    // update assignments table with notified status
                    DB::table('assignments')
                      ->where('id', $assignment_id)
                      ->update(['notified' => date('Y-m-d H:i:s')]);
                }
            }
            if ([] !== $this->non_course_assignment_ids) {
                // the line below is necessary when using only() to get non_course_assignment_ids
                // from the original request (line 61). get() and input() both cause errors
                // if the incoming non_course_assignment_ids array is empty
                $ids = $this->non_course_assignment_ids['non_course_assignment_ids'];
                foreach ($ids as $non_course_assignment_id) {
                    // update pivot table non_course_assignments_letters
                    $letter->nonCourseAssignments()->attach($non_course_assignment_id);
                    // update non_course_assignments table with notified status
                    DB::table('non_course_assignments')
                      ->where('id', $non_course_assignment_id)
                      ->update(['notified' => date('Y-m-d H:i:s')]);
                }
            }

            return $letter;

        }

        return null;
    }

    /**
     * @param  Request  $request
     * @param  Model  $model
     *
     * @return Model|null
     */
    public function update(Request $request, Model $model): ?Model
    {
        $letter = parent::update($request, $model);

        if (null !== $letter) {
            if ([] !== $this->assignment_ids) {
                foreach ($this->assignment_ids as $assignment_id) {
                    $letter->assignments()->sync($assignment_id);
                }
            }
            if ([] !== $this->non_course_assignment_ids) {
                foreach ($this->non_course_assignment_ids as $non_course_assignment_id) {
                    $letter->nonCourseAssignments()->sync($non_course_assignment_id);
                }
            }

            return $letter;
        }

        return null;
    }
}
