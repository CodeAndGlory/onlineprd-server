<?php

namespace Tests\Feature\API\v1;

use App\Models\Permission;
use App\Models\Role;

class RoleControllerTest extends ControllerTestCase
{
    protected string $class = Role::class;
    protected string $endpoint = 'roles';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Role();
    }

    public function testSavePermissions()
    {
        $instance = $this->test_instances[0];
        $permissions = factory(Permission::class, 3)->create();

        $permission_ids = '';
        foreach ($permissions as $permission) {
            $permission_ids .= "$permission->id, ";
        }
        $permission_ids = rtrim($permission_ids, ' ,');

        $attributes = array_merge($instance->toArray(), ['permissions' => $permission_ids]);

        $result = $this->call(
            'POST',
            $this->base_path.$this->endpoint,
            $attributes
        );

        $role_id = $result->json('role.id');

        foreach ($permissions as $permission) {
            $this->assertDatabaseHas('role_has_permissions', [
                'role_id' => $role_id,
                'permission_id' => $permission->id
            ]);
        }
    }

    public function testUpdatePermissions()
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $role_id = $instance->id;
        $permissions = factory(Permission::class, 3)->create();

        $permission_ids = '';
        foreach ($permissions as $permission) {
            $permission_ids .= "$permission->id, ";
        }
        $permission_ids = rtrim($permission_ids, ' ,');

        $attributes = ['permissions' => $permission_ids];

        $result = $this->call(
            'PUT',
            $this->base_path.$this->endpoint.'/'.$role_id,
            $attributes
        );

        foreach ($permissions as $permission) {
            $this->assertDatabaseHas('role_has_permissions', [
                'role_id' => $role_id,
                'permission_id' => $permission->id
            ]);
        }
    }

    public function testDestroyRelations()
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $role_id = $instance->id;
        $permissions = factory(Permission::class, 3)->create();

        $instance->syncPermissions($permissions);
        $instance->save();

        $result = $this->call(
            'DELETE',
            $this->base_path.$this->endpoint.'/'.$role_id
        );

        foreach ($permissions as $permission) {
            $this->assertDatabaseMissing('role_has_permissions', [
                'permission_id' => $permission->id,
                'role_id' => $role_id
            ]);
        }
    }
}
