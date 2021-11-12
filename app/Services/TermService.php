<?php

namespace App\Services;

use App\Models\Term;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class TermService
 * @package App\Services
 */
class TermService extends APIService
{
    protected string $actionable_items_count;

    /**
     * TermService constructor.
     * @param  Request  $request
     * @param  Term  $term
     * @throws Exception
     */
    public function __construct(Request $request, Term $term)
    {
        $this->actionable_items_count = $request->input('actionable_items_count', "false");
        $request->request->remove('actionable_items_count');

        $this->setModel($term);
        parent::__construct($request);
    }

    public function index(): ?Collection
    {
        $terms = parent::index();

        // return the total count of actionable items for offerings, assignments, and non-assignments
        if ($this->actionable_items_count === "true") {
            foreach ($terms as $term) {

                $offeringsCount = DB::table('parts_of_term')
                    ->join('offerings', 'parts_of_term.id', '=', 'offerings.part_of_term_id')
                    ->join('courses', 'offerings.course_id', '=', 'courses.id')
                    ->where('parts_of_term.term_id', $term->id)
                    ->whereNotNull('offerings.confirmed')
                    ->whereNull('offerings.verified')
                    ->whereNull('offerings.deleted_at')
                    ->whereNull('courses.deleted_at')
                    ->count();

                $assignmentsCount = DB::table('parts_of_term')
                    ->join('offerings', 'parts_of_term.id', '=', 'offerings.part_of_term_id')
                    ->join('assignments', 'assignments.offering_id', '=', 'offerings.id')
                    ->join('courses', 'offerings.course_id', '=', 'courses.id')
                    ->where('parts_of_term.term_id', $term->id)
                    ->whereNotNull('assignments.confirmed')
                    ->whereNull('offerings.deleted_at')
                    ->whereNull('assignments.verified')
                    ->whereNull('assignments.deleted_at')
                    ->whereNull('courses.deleted_at')
                    ->count();

                $nonAssignmentsCount = DB::table('non_course_assignments')
                    ->where('term_id', $term->id)
                    ->whereNotNull('confirmed')
                    ->whereNull('verified')
                    ->whereNull('deleted_at')
                    ->count();

                $term->actionable_items = $offeringsCount + $assignmentsCount + $nonAssignmentsCount;
            }
        }

        return $terms;
    }
}
