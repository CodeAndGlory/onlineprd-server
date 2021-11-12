<?php

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            [
                'number' => 101,
                'credit_hours' => 3
            ],
            [
                'number' => 102,
                'credit_hours' => 3
            ],
            [
                'number' => 103,
                'credit_hours' => 3
            ]
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                $course
            );
        }

        factory(Course::class, 15)->create();
    }
}
