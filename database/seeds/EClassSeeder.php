<?php

use App\Models\Eclass;
use Illuminate\Database\Seeder;

class EClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eclasses = [
            [
                'abbreviation' => 'AF',
                'description' => 'Adjunct (faculty)',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'E1',
                'description' => 'SAAO I 12 month, leave earning',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'ER',
                'description' => 'EHRA Phased Retirees',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'FA',
                'description' => 'Temporary Academic Year Faculty',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'FC',
                'description' => 'Faculty 9 month, non-leave earning',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'FE',
                'description' => 'Faculty 10 month, non-leave earning',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'FF',
                'description' => 'Faculty 11 month, leave earning',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'FG',
                'description' => 'Faculty 12 month, leave earning',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'FO',
                'description' => 'Other Temporary Faculty',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'FP',
                'description' => 'Faculty Permanent Part Time',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'FS',
                'description' => 'Temporary Semester Faculty',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'L1',
                'description' => 'Librarians 12 month, leave earning',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'RF',
                'description' => 'Retired (faculty) working',
                'full_time' => false,
                'category' => 'ehra_faculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'AJ',
                'description' => 'Adjunct (EHRA)',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'E2',
                'description' => 'SAAO II 12 month, leave earning',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'EA',
                'description' => 'EHRA 10 month, leave earning',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'EB',
                'description' => 'EHRA 11 month, leave earning',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'EC',
                'description' => 'EHRA Permanent Part Time',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'ED',
                'description' => 'EHRA 9 month non-leave earning',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'EN',
                'description' => 'EHRA 9 month leave earning',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'EP',
                'description' => 'EHRA 12 month, leave earning',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'ET',
                'description' => 'Temporary EHRA (non-faculty)',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'RE',
                'description' => 'Retired (EHRA) working',
                'full_time' => false,
                'category' => 'ehra_nonfaculty',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'RW',
                'description' => 'Retired (SHRA) Working (hourly)',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'SA',
                'description' => 'SHRA 10 month, leave earning',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'SB',
                'description' => 'SHRA 11 month, leave earning',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'SC',
                'description' => 'SHRA 9 month, leave earning',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'SD',
                'description' => 'Seasonal Part-Time',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'SE',
                'description' => 'SHRA Exempt',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'SF',
                'description' => 'SHRA Temporary Flat-Pay',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'SN',
                'description' => 'SHRA Non-Exempt',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'SP',
                'description' => 'SHRA Permanent Part-Time',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'ST',
                'description' => 'SHRA Temporary Hourly',
                'full_time' => false,
                'category' => 'shra',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'GF',
                'description' => 'Graduate flat-pay',
                'full_time' => false,
                'category' => 'student',
                'active' => true,
                'student' => 'graduate'
            ],
            [
                'abbreviation' => 'GH',
                'description' => 'Graduate hourly',
                'full_time' => false,
                'category' => 'student',
                'active' => true,
                'student' => 'graduate'
            ],
            [
                'abbreviation' => 'PH',
                'description' => 'Pre-Hire Student/Graduate Assistant',
                'full_time' => false,
                'category' => 'student',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'UF',
                'description' => 'Undergraduate Flat-pay',
                'full_time' => false,
                'category' => 'student',
                'active' => true,
                'student' => 'undergraduate'
            ],
            [
                'abbreviation' => 'UH',
                'description' => 'Undergraduate/Graduate Hourly',
                'full_time' => false,
                'category' => 'student',
                'active' => true,
                'student' => 'non-student'
            ],
            [
                'abbreviation' => 'WG',
                'description' => 'Graduate Work Study Students',
                'full_time' => false,
                'category' => 'student',
                'active' => true,
                'student' => 'graduate'
            ],
            [
                'abbreviation' => 'WS',
                'description' => 'Work Study Students',
                'full_time' => false,
                'category' => 'student',
                'active' => true,
                'student' => 'non-student'
            ]
        ];

        foreach ($eclasses as $eclass) {
            Eclass::firstOrCreate(
                $eclass
            );
        }
    }
}
