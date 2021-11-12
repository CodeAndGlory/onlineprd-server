<?php

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Department;
use App\Models\Eclass;
use App\Models\FormFieldLookup;
use App\Models\NonCourseAssignment;
use App\Models\Offering;
use App\Models\PartOfTerm;
use App\Models\Letter;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Seeder;

//use App\Models\DepartmentUserRole;
//use App\Models\Role;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignments = Assignment::all();
        $nonCourseAssignments = NonCourseAssignment::all();
        $campuses = FormFieldLookup::where('field', 'campus');
        $courses = Course::all();
        $departments = Department::all();
        $eclasses = Eclass::all();
        $offerings = Offering::all();
        $partsOfTerm = PartOfTerm::all();
        $positions = FormFieldLookup::where('field', 'position');
        $prefixes = FormFieldLookup::where('field', 'prefix');
        $subjects = FormFieldLookup::where('field', 'subject');
        $letters = Letter::all();
//        $departmentUserRoles  = DepartmentUserRole::all();
//        $roles                = Role::all();
        $terms = Term::all();
        $users = User::all();

        foreach ($assignments as $assignment) {
            $assignment->offering()->associate(
                $offerings
                    ->random(1)
                    ->first()
            )->save();
            $assignment->user()->associate(
                $users
                    ->random(1)
                    ->first()
            )->save();
            $assignment->position()->associate(
                $positions
                    ->get()
                    ->random()
            )->save();
            $assignment->eclass()->associate(
                $eclasses
                    ->random(1)
                    ->first()
            )->save();
        }

        foreach ($nonCourseAssignments as $nonCourseAssignment) {
            if (null === $nonCourseAssignment->user_id) {
                $nonCourseAssignment->user()->associate(
                    $users
                        ->random(1)
                        ->first()
                )->save();
            }
            $nonCourseAssignment->position()->associate(
                $positions
                    ->get()
                    ->random()
            )->save();
            $nonCourseAssignment->campus()->associate(
                $campuses
                    ->get()
                    ->random()
            )->save();
            $nonCourseAssignment->eclass()->associate(
                $eclasses
                    ->random(1)
                    ->first()
            )->save();
            if (null === $nonCourseAssignment->department_id) {
                $nonCourseAssignment->department()->associate(
                    $departments
                        ->random(1)
                        ->first()
                )->save();
            }
            if (null === $nonCourseAssignment->term_id) {
                $nonCourseAssignment->term()->associate(
                    $terms
                        ->random(1)
                        ->first()
                )->save();
            }
        }

        NonCourseAssignment::where('hours_worked', '15')->get()->first()->user()->associate(User::where('email',
            'jrmckay@uncg.edu')->get()->first())->save();
        NonCourseAssignment::where('hours_worked', '16')->get()->first()->user()->associate(User::where('email',
            'cmmetivi@uncg.edu')->get()->first())->save();
        NonCourseAssignment::where('hours_worked', '17')->get()->first()->user()->associate(User::where('email',
            'h_suda@uncg.edu')->get()->first())->save();

        NonCourseAssignment::where('hours_worked',
            '15')->get()->first()->department()->associate(Department::where('name',
            'English')->get()->first())->save();
        NonCourseAssignment::where('hours_worked',
            '16')->get()->first()->department()->associate(Department::where('name',
            'Philosophy')->get()->first())->save();
        NonCourseAssignment::where('hours_worked',
            '17')->get()->first()->department()->associate(Department::where('name',
            'History')->get()->first())->save();

        NonCourseAssignment::where('hours_worked', '15')->get()->first()->term()->associate(Term::where('name',
            'Summer 2021')->get()->first())->save();
        NonCourseAssignment::where('hours_worked', '16')->get()->first()->term()->associate(Term::where('name',
            'Summer 2021')->get()->first())->save();
        NonCourseAssignment::where('hours_worked', '17')->get()->first()->term()->associate(Term::where('name',
            'Summer 2021')->get()->first())->save();

        foreach ($courses as $course) {
            if (null === $course->department_id) {
                $course->department()->associate(
                    $departments
                        ->random(1)
                        ->first()
                )->save();
            }
            if (null === $course->term_id) {
                $course->term()->associate(
                    $terms
                        ->random(1)
                        ->first()
                )->save();
            }
            if (null === $course->subject_id) {
                $course->subject()->associate(
                    $subjects
                        ->get()
                        ->random()
                )->save();
            }
        }

        foreach ($departments as $department) {
            $department->contactUser()->associate(
                $users
                    ->random(1)
                    ->first()
            )->save();
        }
//
//        foreach ($departmentUserRoles as $departmentRole) {
//            $departmentRole->user()->associate(
//                $users
//                    ->random(1)
//                    ->first()
//            )->save();
//            $departmentRole->department()->associate(
//                $departments
//                    ->random(1)
//                    ->first()
//            )->save();
//            $departmentRole->role()->associate(
//                $roles
//                    ->random(1)
//                    ->first()
//            )->save();
//        }

        Offering::where('crn', '11111')->get()->first()->partOfTerm()->associate(PartOfTerm::where('term_id',
            3)->get()->first())->save();
        Offering::where('crn', '22222')->get()->first()->partOfTerm()->associate(PartOfTerm::where('term_id',
            3)->get()->first())->save();
        Offering::where('crn', '33333')->get()->first()->partOfTerm()->associate(PartOfTerm::where('term_id',
            3)->get()->first())->save();

        foreach ($offerings as $offering) {
            $offering->course()->associate(
                $courses
                    ->random(1)
                    ->first()
            )->save();
            $offering->partOfTerm()->associate(
                $partsOfTerm
                    ->random(1)
                    ->first()
            )->save();
            $offering->campus()->associate(
                $campuses
                    ->get()
                    ->random()
            )->save();
        }

        foreach ($courses as $course) {
            $course->term()->associate(
                $terms
                    ->random(1)
                    ->first()
            )->save();
        }

        foreach ($letters as $letter) {
            $letter->user()->associate(
                $users
                    ->random(1)
                    ->first()
            )->save();
            $letter->term()->associate(
                $terms
                    ->random(1)
                    ->first()
            )->save();
            // of the 10 sentLetters generated by SentLetterSeeder,
            // make 5 for course assignments and 5 for non-course assignments
            if ($letter->id <= 5) {
                $letter->assignments()->save(
                    $assignments
                        ->random(1)
                        ->first()
                );
            } else {
                $letter->nonCourseAssignments()->save(
                    $nonCourseAssignments
                        ->random(1)
                        ->first()
                );
            }
        }

        User::where('email', 'jrmckay@uncg.edu')->get()->first()->departments()->save(Department::where('name',
            'English')->get()->first());
        User::where('email', 'cmmetivi@uncg.edu')->get()->first()->departments()->save(Department::where('name',
            'Philosophy')->get()->first());
        User::where('email', 'h_suda@uncg.edu')->get()->first()->departments()->save(Department::where('name',
            'History')->get()->first());

        foreach ($users as $user) {
            $user->departments()->save(
                $departments
                    ->random(1)
                    ->first()
            );
            $user->prefix()->associate(
                $prefixes
                    ->get()
                    ->random()
            )->save();
            $user->eclass()->associate(
                $eclasses
                    ->random()
            )->save();
        }

        Course::where('number', '101')->get()->first()->department()->associate(Department::where('name',
            'English')->get()->first())->save();
        Course::where('number', '102')->get()->first()->department()->associate(Department::where('name',
            'Philosophy')->get()->first())->save();
        Course::where('number', '103')->get()->first()->department()->associate(Department::where('name',
            'History')->get()->first())->save();

        Offering::where('crn', '11111')->get()->first()->course()->associate(Course::where('number',
            '101')->get()->first())->save();
        Offering::where('crn', '22222')->get()->first()->course()->associate(Course::where('number',
            '102')->get()->first())->save();
        Offering::where('crn', '33333')->get()->first()->course()->associate(Course::where('number',
            '103')->get()->first())->save();

        Assignment::where('hours_worked', '12')->get()->first()->offering()->associate(Offering::where('crn',
            '11111')->get()->first())->save();
        Assignment::where('hours_worked', '13')->get()->first()->offering()->associate(Offering::where('crn',
            '22222')->get()->first())->save();
        Assignment::where('hours_worked', '14')->get()->first()->offering()->associate(Offering::where('crn',
            '33333')->get()->first())->save();
        Assignment::where('hours_worked', '12')->get()->first()->user()->associate(User::where('email',
            'jrmckay@uncg.edu')->get()->first())->save();
        Assignment::where('hours_worked', '13')->get()->first()->user()->associate(User::where('email',
            'cmmetivi@uncg.edu')->get()->first())->save();
        Assignment::where('hours_worked', '14')->get()->first()->user()->associate(User::where('email',
            'h_suda@uncg.edu')->get()->first())->save();
    }
}
