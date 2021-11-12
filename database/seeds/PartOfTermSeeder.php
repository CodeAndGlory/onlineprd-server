<?php

use App\Models\PartOfTerm;
use Illuminate\Database\Seeder;

class PartOfTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parts_of_term = [
            [
                'name' => 'All Summer',
                'term_id' => '1',
                'start_date' => '2021-05-01',
                'end_date' => '2021-07-31'
            ],
            [
                'name' => 'First Summer Session',
                'term_id' => '1',
                'start_date' => '2021-05-01',
                'end_date' => '2021-06-15'
            ],
            [
                'name' => 'Second Summer Session',
                'term_id' => '1',
                'start_date' => '2021-06-16',
                'end_date' => '2021-07-31'
            ],
            [
                'name' => 'All Summer',
                'term_id' => '2',
                'start_date' => '2022-05-01',
                'end_date' => '2022-07-31'
            ],
            [
                'name' => 'First Summer Session',
                'term_id' => '2',
                'start_date' => '2022-05-01',
                'end_date' => '2022-06-15'
            ],
            [
                'name' => 'Second Summer Session',
                'term_id' => '2',
                'start_date' => '2022-06-16',
                'end_date' => '2022-07-31'
            ],
            [
                'name' => 'All Summer',
                'term_id' => '3',
                'start_date' => '2023-05-01',
                'end_date' => '2023-07-31'
            ],
            [
                'name' => 'First Summer Session',
                'term_id' => '3',
                'start_date' => '2023-05-01',
                'end_date' => '2023-06-15'
            ],
            [
                'name' => 'Second Summer Session',
                'term_id' => '3',
                'start_date' => '2023-06-16',
                'end_date' => '2023-07-31'
            ]
        ];

        foreach ($parts_of_term as $part_of_term) {
            PartOfTerm::firstOrCreate(
                $part_of_term
            );
        }

//        factory(PartOfTerm::class, 9)->create();
    }
}
