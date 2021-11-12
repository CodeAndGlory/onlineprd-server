<?php

namespace Tests\Feature\API\v1;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Department;
use App\Models\Offering;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PermissionSeeder;
use RolesSeeder;

class UserControllerTest extends ControllerTestCase
{
    protected string $class = User::class;
    protected string $endpoint = 'users';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new User();
    }

    /**
     * @return void
     */
    public function testUserInfo(): void
    {
        $this->seed(PermissionSeeder::class);
        $this->seed(RolesSeeder::class);

        $instance = $this->test_instances[0];
        $instance->assignRole('Scheduler');
        $instance->save();
        Auth::login($instance);

        $response = $this->call('GET', 'api/v1/userinfo');

//        $response->assertStatus(200);
        $response->assertJson([
            'error' => false
        ]);
        $response->assertJsonPath('user.id', $instance->id);
    }

    /**
     * @return void
     */
    public function testCountOfUnverified(): void
    {
        $this->test_instances[0]->verified = true;
        $this->test_instances[1]->verified = false;
        $this->test_instances[2]->verified = false;
        $this->test_instances[0]->save();

        $response = $this->call('GET', 'api/v1/countofunverified');

        $response->assertJson([
            'error' => false,
            'count' => 0,
        ]);

        $this->test_instances[1]->save();
        $this->test_instances[2]->save();

        $response = $this->call('GET', 'api/v1/countofunverified');

        $response->assertJson([
            'error' => false,
            'count' => 2,
        ]);
    }

    public function testIndexChildren(): void
    {
        $assignments = [];
        $offerings = [];
        $courses = [];
        $departments = [];

        foreach ($this->test_instances as $instance) {
            $instance->save();

            $assignments[] = factory(Assignment::class)->create();
            $offerings[] = factory(Offering::class)->create();
            $courses[] = factory(Course::class)->create();
            $departments[] = factory(Department::class)->create();

            $instance->assignments()->save(end($assignments));
            end($assignments)->offering()->associate(end($offerings))->save();
            end($offerings)->course()->associate(end($courses))->save();
            end($courses)->department()->associate(end($departments))->save();
        }

        $params = ['with' => 'all'];
        $response = $this->call('GET', $this->base_path.$this->endpoint, $params);

        $response->assertJsonPath('users.0.assignments.0.offering.course.department.id', $departments[0]->id);
    }

    public function testSearchRelations(): void
    {
        foreach ($this->test_instances as $test_instance) {
            $test_instance->save();
        }
        $instance = $this->test_instances[0];

        $department_name = 'Test Department';
        $department = new Department(['name' => $department_name]);
        $instance->departments()->save($department);

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'search-on' => 'departments.name',
                'search' => $department_name,
                'with' => 'departments'
            ]
        );

        $response->assertJsonPath('users.0.departments.0.name', $department_name);
    }

    public function testSearchMultiple(): void
    {
        foreach ($this->test_instances as $test_instance) {
            $test_instance->save();
        }
        $instance = $this->test_instances[0];

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'search-on' => 'first_name, last_name',
                'search' => $instance->first_name,
            ]
        );

        $response->assertJsonPath('users.0.first_name', $instance->first_name);
    }

    public function testSaveDepartments(): void
    {
        $instance = $this->test_instances[0];
        $departments = factory(Department::class, 3)->create();

        $dept_ids = '';
        foreach ($departments as $department) {
            $dept_ids .= "$department->id, ";
        }
        $dept_ids = rtrim($dept_ids, ' ,');

        $attributes = array_merge($instance->toArray(), ['departments' => $dept_ids]);

        $result = $this->call(
            'POST',
            $this->base_path.$this->endpoint,
            $attributes
        );

        $user_id = $result->json('user.id');

        foreach ($departments as $department) {
            $this->assertDatabaseHas('department_user', [
                'user_id' => $user_id,
                'department_id' => $department->id
            ]);
        }
    }

    public function testSaveRoles(): void
    {
        $instance = $this->test_instances[0];
        $roles = factory(Role::class, 3)->create();

        $role_ids = '';
        foreach ($roles as $role) {
            $role_ids .= "$role->id, ";
        }
        $role_ids = rtrim($role_ids, ' ,');

        $attributes = array_merge($instance->toArray(), ['roles' => $role_ids]);

        $result = $this->call(
            'POST',
            $this->base_path.$this->endpoint,
            $attributes
        );

        $user_id = $result->json('user.id');

        foreach ($roles as $role) {
            $this->assertDatabaseHas('model_has_roles', [
                'model_id' => $user_id,
                'role_id' => $role->id,
                'model_type' => User::class
            ]);
        }
    }

    public function testUpdateDepartments(): void
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $user_id = $instance->id;
        $departments = factory(Department::class, 3)->create();

        $dept_ids = '';
        foreach ($departments as $department) {
            $dept_ids .= "$department->id, ";
        }
        $dept_ids = rtrim($dept_ids, ' ,');

        $attributes = ['departments' => $dept_ids];

        $this->call(
            'PUT',
            $this->base_path.$this->endpoint.'/'.$user_id,
            $attributes
        );

        foreach ($departments as $department) {
            $this->assertDatabaseHas('department_user', [
                'user_id' => $user_id,
                'department_id' => $department->id
            ]);
        }
    }

    public function testUpdateRoles(): void
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $user_id = $instance->id;
        $roles = factory(Role::class, 3)->create();

        $role_ids = '';
        foreach ($roles as $role) {
            $role_ids .= "$role->id, ";
        }
        $role_ids = rtrim($role_ids, ' ,');

        $attributes = ['roles' => $role_ids];

        $this->call(
            'PUT',
            $this->base_path.$this->endpoint.'/'.$user_id,
            $attributes
        );

        foreach ($roles as $role) {
            $this->assertDatabaseHas('model_has_roles', [
                'model_id' => $user_id,
                'role_id' => $role->id,
                'model_type' => $this->class
            ]);
        }
    }

    public function testDestroyRelations(): void
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $user_id = $instance->id;
        $departments = factory(Department::class, 3)->create();
        $roles = factory(Role::class, 3)->create();

        $instance->departments()->sync($departments);
        $instance->syncRoles($roles);

        $this->call(
            'DELETE',
            $this->base_path.$this->endpoint.'/'.$user_id
        );

        foreach ($departments as $department) {
            $this->assertDatabaseMissing('department_user', [
                'user_id' => $user_id,
                'department_id' => $department->id,
            ]);
        }

        foreach ($roles as $role) {
            $this->assertDatabaseMissing('model_has_roles', [
                'model_id' => $user_id,
                'role_id' => $role->id,
                'model_type' => $this->class,
            ]);
        }
    }

    public function testEmailValidation(): void
    {
        $response = $this->call(
            'POST',
            $this->base_path.$this->endpoint,
            $this->test_instances[0]->toArray()
        );

        $id = $response->json("$this->record.id");

        $response->assertJsonPath('error', false);
        $response->assertStatus(200);

        $instance = $this->test_instances[1];
        $instance->email = $this->test_instances[0]->email;

        $response = $this->call(
            'POST',
            $this->base_path.$this->endpoint,
            $instance->toArray()
        );

        $response->assertJson([
            'error' => [
                '422' => [
                    'The email has already been taken.',
                ],
            ],
        ]);
        $this->assertDatabaseMissing('users', [
            'first_name' => $instance->first_name,
            'last_name' => $instance->last_name,
        ]);
        $response->assertStatus(422);

        $instance->email = $this->test_instances[2]->email;

        $response = $this->call(
            'PUT',
            $this->base_path.$this->endpoint.'/'.$id,
            $instance->toArray()
        );

        $response->assertJsonPath(
            "$this->record.email",
            $this->test_instances[2]->email
        );
        $response->assertStatus(200);

        $this->test_instances[0]->email = 'example@example.com';
        $this->test_instances[0]->save();

        $response = $this->call(
            'PUT',
            $this->base_path.$this->endpoint.'/'.$id,
            [
                'first_name' => 'testname',
                'email' => 'example@example.com'
            ]
        );

        $response->assertJson([
            'error' => [
                '422' => [
                    'The email has already been taken.',
                ],
            ],
        ]);
        $this->assertDatabaseMissing($this->table, [
            'id' => $id,
            'first_name' => 'testname',
        ]);
        $response->assertStatus(422);
    }

    public function testRevisionHistoryAPI(): void
    {
        $user = $this->test_instances[0];
        $user->save();
        Auth::login($user);
        $user->first_name = 'Test';
        $user->save();

        $assignment = new Assignment();
        $assignment->stipend = 4500;
        $assignment->user()->associate($user);
        $assignment->save();

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint.'/'.$user->id,
            [
                'with' => 'revision_history',
            ]
        );

        $response->assertJsonPath('user.revision_history.0.new_value', 'Test');

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'with' => 'revision_history,assignments.revision_history',
            ]
        );

        $response->assertJsonPath('users.0.revision_history.0.new_value', 'Test');
    }
}
