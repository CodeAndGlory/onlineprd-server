<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Model;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DepartmentService
 * @package App\Services
 */
class DepartmentService extends APIService
{
    protected $actionable_items_by_term_id;

    /**
     * DepartmentService constructor.
     * @param  Request  $request
     * @param  Department  $department
     * @throws Exception
     */
    public function __construct(Request $request, Department $department)
    {
        $this->actionable_items_by_term_id = $request->input('actionable_items_by_term_id', null);
        $request->request->remove('actionable_items_by_term_id');

        $this->setModel($department);
        parent::__construct($request);
    }

    /**
     * @param  Request  $request
     * @return Model|null
     */
    public function store(Request $request): ?Model
    {
        try {
            $this->validate($request);
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }

        if (false === $this->error) {
            $users = $this->getRelationIDsFromRequest('users');
            $department = parent::store($request);

            if ([] !== $users && null !== $department) {
                $department->users()->sync($users, false);
            }

            return $department;
        }

        return null;
    }

    /**
     * @param  Request  $request
     * @param  Model  $model
     * @return Model|null
     */
    public function update(Request $request, Model $model): ?Model
    {
        try {
            $this->validate($request);
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }

        if (false === $this->error) {
            $department = parent::update($request, $model);
            $users = $this->getRelationIDsFromRequest('users');

            if ([] !== $users && null !== $department) {
                $department->users()->sync($users);
            }

            return $department;
        }

        return null;
    }

    /**
     * @param  Model  $model
     */
    public function delete(Model $model): void
    {
        $model->users()->detach();
        parent::delete($model);
    }

    /**
     * @return Collection|null
     */
    public function index(): ?Collection
    {
        $departments = parent::index();

        // return the total count of actionable items for offerings, assignments, and non-assignments
        if ($this->actionable_items_by_term_id !== null &&  is_numeric($this->actionable_items_by_term_id) ) {

            $term_id = $this->actionable_items_by_term_id;

            foreach ($departments as $department) {

                $offeringsCount = DB::table('courses')
                    ->join('offerings', 'offerings.course_id', '=', 'courses.id')
                    ->join('parts_of_term', 'parts_of_term.id', '=', 'offerings.part_of_term_id')
                    ->where('courses.department_id', $department->id)
                    ->whereNull('courses.deleted_at')
                    ->where('parts_of_term.term_id', $term_id)
                    ->whereNotNull('offerings.confirmed')
                    ->whereNull('offerings.verified')
                    ->whereNull('offerings.deleted_at')
                    ->count();

                $assignmentsCount = DB::table('courses')
                    ->join('offerings', 'offerings.course_id', '=', 'courses.id')
                    ->join('parts_of_term', 'parts_of_term.id', '=', 'offerings.part_of_term_id')
                    ->join('assignments', 'assignments.offering_id', '=', 'offerings.id')
                    ->where('courses.department_id', $department->id)
                    ->whereNull('courses.deleted_at')
                    ->where('parts_of_term.term_id', $term_id)
                    ->whereNotNull('assignments.confirmed')
                    ->whereNull('assignments.verified')
                    ->whereNull('assignments.deleted_at')
                    ->whereNull('offerings.deleted_at')
                    ->count();

                $nonAssignmentsCount = DB::table('non_course_assignments')
                    ->where('term_id', $term_id)
                    ->where('department_id', $department->id)
                    ->whereNotNull('confirmed')
                    ->whereNull('verified')
                    ->whereNull('deleted_at')
                    ->count();

                $department->actionable_items = $offeringsCount + $assignmentsCount + $nonAssignmentsCount;
            }
        }

        return $departments;
    }
}
