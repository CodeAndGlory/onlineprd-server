<?php

use App\Models\NonCourseAssignment;
use Illuminate\Database\Seeder;

class NonCourseAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignments = [
            [
                'hours_worked' => 15,
                'start_date' => date('Y-m-d', strtotime("2020-05-01")),
                'end_date' => date('Y-m-d', strtotime("2020-07-31")),
                'stipend' => 4000.00
            ],
            [
                'hours_worked' => 16,
                'start_date' => date('Y-m-d', strtotime("2020-05-01")),
                'end_date' => date('Y-m-d', strtotime("2020-07-31")),
                'stipend' => 4000.00
            ],
            [
                'hours_worked' => 17,
                'start_date' => date('Y-m-d', strtotime("2020-05-01")),
                'end_date' => date('Y-m-d', strtotime("2020-07-31")),
                'stipend' => 4000.00
            ]
        ];

        foreach ($assignments as $assignment) {
            NonCourseAssignment::firstOrCreate(
                $assignment
            );
        }

        factory(NonCourseAssignment::class, 20)->create();
    }
}
