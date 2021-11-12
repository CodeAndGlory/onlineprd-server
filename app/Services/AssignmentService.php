<?php

namespace App\Services;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class AssignmentService
 * @package App\Services
 */
class AssignmentService extends APIService
{
    /**
     * @var array
     */
    protected array $term_id;

    /**
     * AssignmentService constructor.
     *
     * @param  Request  $request
     * @param  Assignment  $assignment
     *
     * @throws Exception
     */
    public function __construct(Request $request, Assignment $assignment)
    {
        $this->setModel($assignment);
        parent::__construct($request);
    }

    /**
     * @param  Request  $request
     */
    public function setRequestValues(Request $request): void
    {
        $this->request_values = $request->except(['term_id']);
        $this->term_id        = $request->only('term_id');
    }

    /**
     * @return array
     */
    public function getAssignmentsByUserTerm()
    {

        $assignment_users = DB::table('users')
                              ->join('assignments', 'assignments.user_id', '=', 'users.id')
                              ->join('offerings', 'offerings.id', '=', 'assignments.offering_id')
                              ->join('courses', function ($join) {
                                  $join->on('courses.id', '=', 'offerings.course_id')
                                       ->where('courses.term_id', '=', $this->term_id['term_id']);
                              })
                              ->leftJoin('departments', 'departments.id', '=', 'courses.department_id')
                              ->get();

        $count1 = $assignment_users->count();

        $non_course_assignment_users = DB::table('users')
                                         ->join('non_course_assignments', function ($join) {
                                             $join->on('non_course_assignments.user_id', '=', 'users.id')
                                                  ->where('non_course_assignments.term_id', '=',
                                                      $this->term_id['term_id']);
                                         })
//                                         ->join('departments', 'departments.id', '=', 'non_course_assignments.department_id')
                                         ->get();

        $count2 = $non_course_assignment_users->count();

        if ($count1 + $count2 > 0) {

            $all_users = $assignment_users->concat($non_course_assignment_users);

            foreach ($all_users as $user_record) {
                $spartan_ids[] = $user_record->spartan_id;
            }
            $unique_users = array();
            foreach ($all_users as $user_record) {
                $unique_users[$user_record->spartan_id] = array(
                    'email'                  => $user_record->email,
                    'email_verified_at'      => $user_record->email_verified_at,
                    'remember_token'         => $user_record->remember_token,
                    'created_at'             => $user_record->created_at,
                    'updated_at'             => $user_record->updated_at,
                    'password'               => $user_record->password,
                    'provider_name'          => $user_record->provider_name,
                    'provider_id'            => $user_record->provider_id,
                    'avatar'                 => $user_record->avatar,
                    'prefix_id'              => $user_record->prefix_id,
                    'first_name'             => $user_record->first_name,
                    'last_name'              => $user_record->last_name,
                    'spartan_id'             => $user_record->spartan_id,
                    'deleted_at'             => $user_record->deleted_at,
                    'eclass_id'              => $user_record->eclass_id,
                    'verified'               => $user_record->verified,
                    'user_id'                => $user_record->user_id,
                    'assignments'            => [],
                    'non_course_assignments' => []
                );
                if (property_exists($user_record, 'offering_id')) {
                    $unique_users[$user_record->spartan_id]['assignments'][] = $user_record;
                } else {
                    $unique_users[$user_record->spartan_id]['non_course_assignments'][] = $user_record;
                }
            }

            $users = collect(array_values($unique_users));

            return array(
                'error'  => $this->error,
                'status' => $this->status,
                'users'  => $users,
                'count'  => $users->count()
            );
        }

        return null;
    }
}
