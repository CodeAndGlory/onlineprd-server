<?php

use App\Models\Department;
use App\Models\FormFieldLookup;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'abbreviation' => 'ACC',
                'name' => 'Accounting',
                'chair' => 'Randy Elder',
                'org_number' => '11812',
                'department_building' => 'Bryan',
                'department_office_number' => '383',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'BRYAN')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ADS',
                'name' => 'African American and African Diaspora Studies',
                'chair' => 'Cerise Glenn Manigault',
                'org_number' => '12225',
                'department_building' => 'Curry',
                'department_office_number' => '349',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ARE',
                'name' => 'Art Education',
                'chair' => 'Chris Cassidy',
                'org_number' => '12203',
                'department_building' => 'Gatewood Bldg',
                'department_office_number' => '138',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ARH',
                'name' => 'Art History',
                'chair' => 'Chris Cassidy',
                'org_number' => '12203',
                'department_building' => 'Gatewood Bldg',
                'department_office_number' => '138',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ART',
                'name' => 'Studio Art',
                'chair' => 'Chris Cassidy',
                'org_number' => '12203',
                'department_building' => 'Gatewood Bldg',
                'department_office_number' => '138',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ATY',
                'name' => 'Anthropology',
                'chair' => 'Robert Anemone',
                'org_number' => '12202',
                'department_building' => 'Graham',
                'department_office_number' => '426',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'BIO',
                'name' => 'Biology',
                'chair' => 'Matina Kalcounis-Rueppell',
                'org_number' => '12204',
                'department_building' => 'Eberhart',
                'department_office_number' => '312',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'BLS',
                'name' => 'Humanities',
                'chair' => 'Wade Maki',
                'org_number' => '12233',
                'department_building' => '119 McIver St',
                'department_office_number' => ''
            ],
            [
                'abbreviation' => 'CCI',
                'name' => 'Classical Civilization',
                'chair' => 'Maura Heyn',
                'org_number' => '12206',
                'department_building' => 'MHRA',
                'department_office_number' => '1104',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'CED',
                'name' => 'Counseling and Educational Development',
                'chair' => 'Craig Cashwell',
                'org_number' => '12003',
                'department_building' => 'Curry',
                'department_office_number' => '228',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'SOE')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'CHE',
                'name' => 'Chemistry and Biochemistry',
                'chair' => 'Mitchell Croatt',
                'org_number' => '12205',
                'department_building' => 'Sullivan Science',
                'department_office_number' => '435',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'CRS',
                'name' => 'Consumer, Apparel, and Retail Studies',
                'chair' => 'Nancy Hodges',
                'org_number' => '',
                'department_building' => 'Stone',
                'department_office_number' => '210',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'BRYAN')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'CSC',
                'name' => 'Computer Science',
                'chair' => 'Steve Tate',
                'org_number' => '12228',
                'department_building' => 'Petty',
                'department_office_number' => '167',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'CSD',
                'name' => 'Communication Sciences and Disorders',
                'chair' => 'Kristine Lundgren',
                'org_number' => '13001',
                'department_building' => 'Ferguson',
                'department_office_number' => '300',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'CST',
                'name' => 'Communication Studies',
                'chair' => 'Christopher Poulos',
                'org_number' => '12221',
                'department_building' => 'Ferguson',
                'department_office_number' => '102',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'CTR',
                'name' => 'Community and Therapeutic Recreation',
                'chair' => 'Stuart Schleien',
                'org_number' => '13005',
                'department_building' => 'Ferguson',
                'department_office_number' => '200B',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'HHS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'DAC',
                'name' => 'Digital ACT Studio',
                'chair' => 'Dayna Touron',
                'org_number' => '12201',
                'department_building' => 'University Libraries',
                'department_office_number' => '105'
            ],
            [
                'abbreviation' => 'DCE',
                'name' => 'Dance',
                'chair' => 'Janet Lilly',
                'org_number' => '13004',
                'department_building' => 'Coleman',
                'department_office_number' => '323',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CVPA')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'DOL',
                'name' => 'Division of Online Learning',
                'chair' => 'Karen Bull',
                'org_number' => '10302',
                'department_building' => 'Becher-Weaver',
                'department_office_number' => '117',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'ONL')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ECO',
                'name' => 'Economics',
                'chair' => 'Jeremy Bray',
                'org_number' => '',
                'department_building' => 'Bryan',
                'department_office_number' => '462',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'BRYAN')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ELC',
                'name' => 'Educational Leadership and Cultural Foundations',
                'chair' => 'Craig Peck',
                'org_number' => '12011',
                'department_building' => 'School of Education Building',
                'department_office_number' => '366',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'SOE')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ENG',
                'name' => 'English',
                'chair' => 'Scott Romine',
                'org_number' => '12207',
                'department_building' => 'MHRA',
                'department_office_number' => '3143',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ERM',
                'name' => 'Educational Research Methodology',
                'chair' => 'John Willse',
                'org_number' => '12012',
                'department_building' => 'School of Education Building',
                'department_office_number' => '254',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'SOE')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'GEN',
                'name' => 'Genetic Counseling',
                'chair' => 'Lauren Doyle',
                'org_number' => '',
                'department_building' => '996 Spring Garden St.',
                'department_office_number' => '',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'HHS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'GES',
                'name' => 'Geography, Environment, and Sustainability',
                'chair' => 'Corey Johnson',
                'org_number' => '12235',
                'department_building' => 'Graham',
                'department_office_number' => '237',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'GRO',
                'name' => 'Gerontology',
                'chair' => 'Melissa Floyd - Pickard',
                'org_number' => '12401',
                'department_building' => 'Stone',
                'department_office_number' => '262'
            ],
            [
                'abbreviation' => 'HDF',
                'name' => 'Human Development and Family Studies',
                'chair' => 'Catherine Scott-Little',
                'org_number' => '12403',
                'department_building' => 'Stone',
                'department_office_number' => '248'
            ],
            [
                'abbreviation' => 'HEA',
                'name' => 'Public Heath',
                'chair' => 'Tracy Nichols',
                'org_number' => '13006',
                'department_building' => 'Coleman',
                'department_office_number' => '437',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'HHS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'HIS',
                'name' => 'History',
                'chair' => 'Greg O\'Brien',
                'org_number' => '12210',
                'department_building' => 'MHRA',
                'department_office_number' => '2129',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'IAR',
                'name' => 'Interior Architecture',
                'chair' => 'Anna Marshall - Baker',
                'org_number' => '',
                'department_building' => 'Gatewood Studio Arts Bldg',
                'department_office_number' => '102',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'IGS',
                'name' => 'International and Global Studies',
                'chair' => 'Kathleen Macfie',
                'org_number' => '',
                'department_building' => '',
                'department_office_number' => '',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'IPS',
                'name' => 'Integrated Professional Studies',
                'chair' => 'Courtney Harrington',
                'org_number' => '10301',
                'department_building' => 'Becher - Weaver',
                'department_office_number' => '122',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'ONL')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ISM',
                'name' => 'Information Systems and Operations Management',
                'chair' => 'Gurpreet Dhillon',
                'org_number' => '',
                'department_building' => 'Bryan',
                'department_office_number' => '479',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'BRYAN')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'KIN',
                'name' => 'Kinesiology',
                'chair' => 'Scott E.Ross',
                'org_number' => '13003',
                'department_building' => 'Coleman',
                'department_office_number' => '250',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'HHS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'LIS',
                'name' => 'Library and Information Studies',
                'chair' => 'Lisa O\'Connor',
                'org_number' => '12005',
                'department_building' => 'School of Education Building',
                'department_office_number' => '446',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'SOE')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'LLC',
                'name' => 'Languages, Literatures, and Cultures',
                'chair' => 'Roberto Campo',
                'org_number' => '12217',
                'department_building' => 'MHRA',
                'department_office_number' => '2321',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'MAS',
                'name' => 'Masters in Applied Arts and Sciences',
                'chair' => '',
                'org_number' => '10301',
                'department_building' => 'Becher - Weacher',
                'department_office_number' => '117',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'ONL')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'MAT',
                'name' => 'Mathematics',
                'chair' => 'Ratnasingham Shivaji',
                'org_number' => '12227',
                'department_building' => 'Petty',
                'department_office_number' => '116',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'MGT',
                'name' => 'Management',
                'chair' => 'Moses Acquaah',
                'org_number' => '',
                'department_building' => 'Bryan',
                'department_office_number' => '366',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'BRYAN')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'MST',
                'name' => 'Media Studies',
                'chair' => 'Kimberlianne Podlas',
                'org_number' => '12226',
                'department_building' => 'Brown',
                'department_office_number' => '210',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'MUE',
                'name' => 'Music Education',
                'chair' => 'Dennis AsKew',
                'org_number' => '12611',
                'department_building' => 'School of Music',
                'department_office_number' => '328',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CVPA')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'MUP',
                'name' => 'Music Performance',
                'chair' => 'Dennis AsKew',
                'org_number' => '12611',
                'department_building' => 'School of Music',
                'department_office_number' => '328',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CVPA')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'MUS',
                'name' => 'Music',
                'chair' => 'Dennis AsKew',
                'org_number' => '12611',
                'department_building' => 'Music',
                'department_office_number' => '329',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CVPA')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'NTR',
                'name' => 'Nutrition',
                'chair' => 'Ron Morrison',
                'org_number' => '12405',
                'department_building' => 'Stone',
                'department_office_number' => '318',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'HHS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'NUR',
                'name' => 'Nursing',
                'chair' => 'Pamela Rowsey',
                'org_number' => '12802',
                'department_building' => 'Moore Nursing Building',
                'department_office_number' => '112',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'NUR')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'PCS',
                'name' => 'Peace and Conflict Studies',
                'chair' => 'Melissa Floyd - Pickard',
                'org_number' => '11404',
                'department_building' => '1510 Walker Ave.',
                'department_office_number' => '421A'
            ],
            [
                'abbreviation' => 'PHI',
                'name' => 'Philosophy',
                'chair' => 'Gary Rosenkrantz',
                'org_number' => '12212',
                'department_building' => 'Curry',
                'department_office_number' => '239',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'PHY',
                'name' => 'Physics',
                'chair' => 'Edward Hellen',
                'org_number' => '',
                'department_building' => 'Petty',
                'department_office_number' => '321',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'PSC',
                'name' => 'Political Science',
                'chair' => 'Gregory McAvoy',
                'org_number' => '12214',
                'department_building' => 'Curry',
                'department_office_number' => '324',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'PSY',
                'name' => 'Psychology',
                'chair' => 'Stuart Marcovitch',
                'org_number' => '12215',
                'department_building' => 'Eberhart',
                'department_office_number' => '296',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'REL',
                'name' => 'Religious Studies',
                'chair' => 'Greg Grieve',
                'org_number' => '12216',
                'department_building' => 'Foust',
                'department_office_number' => '109',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'SC',
                'name' => 'Speaking Center',
                'chair' => 'Kim Cuny',
                'org_number' => '10302',
                'department_building' => 'mhra',
                'department_office_number' => '3211'
            ],
            [
                'abbreviation' => 'SES',
                'name' => 'Specialized Education Services',
                'chair' => 'Stephanie Kurtts',
                'org_number' => '12017',
                'department_building' => 'School of Education Building',
                'department_office_number' => '444',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'SOE')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'SOC',
                'name' => 'Sociology',
                'chair' => 'David Kauzlarich',
                'org_number' => '12218',
                'department_building' => 'Graham',
                'department_office_number' => '337',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'ST',
                'name' => 'Student Success Center',
                'chair' => 'Dr.Green',
                'org_number' => '10302',
                'department_building' => 'Forney',
                'department_office_number' => '114 - A'
            ],
            [
                'abbreviation' => 'STA',
                'name' => 'Statistics',
                'chair' => 'Ratnasingham Shivaji',
                'org_number' => '12227',
                'department_building' => 'Petty',
                'department_office_number' => '116',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'SWK',
                'name' => 'Social Work',
                'chair' => 'Melissa Floyd - Pickard',
                'org_number' => '12401',
                'department_building' => 'Stone',
                'department_office_number' => '268'
            ],
            [
                'abbreviation' => 'TED',
                'name' => 'Teacher Education',
                'chair' => 'Kerri Richardson',
                'org_number' => '12006',
                'department_building' => 'School of Education Building',
                'department_office_number' => '488',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'SOE')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'THR',
                'name' => 'Theatre',
                'chair' => 'John R.Poole',
                'org_number' => '12222',
                'department_building' => 'Taylor',
                'department_office_number' => '200',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CVPA')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'VPA',
                'name' => 'Visual and Performing Arts',
                'chair' => 'Lawrence Jenkens',
                'org_number' => '12601',
                'department_building' => 'Music',
                'department_office_number' => '220',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CVPA')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
            [
                'abbreviation' => 'WC',
                'name' => 'Writing Center',
                'chair' => 'Jennifer Whitaker',
                'org_number' => '10302',
                'department_building' => 'MHRA',
                'department_office_number' => '3119'
            ],
            [
                'abbreviation' => 'WGS',
                'name' => 'Women\'s and Gender Studies',
                'chair' => 'Mark Rifkin',
                'org_number' => '12224',
                'department_building' => 'Curry',
                'department_office_number' => '336',
                'college_id' => FormFieldLookup::where('field', 'college')
                    ->where('abbreviation', 'CAS')
                    ->get()
                    ->all()[0]
                    ->id,
            ],
        ];

        foreach ($departments as $department) {
            $abbreviation = array_splice($department, 0, 1);
            Department::firstOrCreate(
                $abbreviation,
                $department
            );
        }
    }
}
