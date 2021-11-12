<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(AdminUsersSeeder::class);
        $this->call(FormFieldLookupSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(EClassSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(DepartmentUserRoleSeeder::class);
        $this->call(OfferingSeeder::class);
        $this->call(AssignmentSeeder::class);
        $this->call(NonCourseAssignmentSeeder::class);
        $this->call(TermSeeder::class);
        $this->call(PartOfTermSeeder::class);
        $this->call(EmailTemplateSeeder::class);
        $this->call(LetterSeeder::class);
        $this->call(RelationshipSeeder::class);
    }
}
