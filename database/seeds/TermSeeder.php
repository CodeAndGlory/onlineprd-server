<?php

use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $terms = [
            [
                'name' => 'Summer 2021',
                'start_date' => '2021-05-01',
                'end_date' => '2021-07-31'
            ],
            [
                'name' => 'Summer 2022',
                'start_date' => '2022-05-01',
                'end_date' => '2022-07-31'
            ],
            [
                'name' => 'Summer 2023',
                'start_date' => '2023-05-01',
                'end_date' => '2023-07-31'
            ]
        ];

        foreach ($terms as $term) {
            Term::firstOrCreate(
                $term
            );
        }

//        factory(Term::class, 4)->create();
    }
}
