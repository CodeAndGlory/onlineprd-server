<?php

use App\Models\Offering;
use Illuminate\Database\Seeder;

class OfferingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offerings = [
            [
                'crn' => 11111,
                'section' => 1
            ],
            [
                'crn' => 22222,
                'section' => 2
            ],
            [
                'crn' => 33333,
                'section' => 3
            ]
        ];

        foreach ($offerings as $offering) {
            Offering::firstOrCreate(
                $offering
            );
        }

        factory(Offering::class, 30)->create();
    }
}
