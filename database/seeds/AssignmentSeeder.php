<?php

use App\Models\Assignment;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
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
                'hours_worked' => 12,
                'stipend' => 4000.00
            ],
            [
                'hours_worked' => 13,
                'stipend' => 4500.00
            ],
            [
                'hours_worked' => 14,
                'stipend' => 5000.00
            ]
        ];

        foreach ($assignments as $assignment) {
            Assignment::firstOrCreate(
                $assignment
            );
        }

        factory(Assignment::class, 30)->create();
    }
}
