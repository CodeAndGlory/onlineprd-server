<?php

namespace Tests\Feature\API\v1;

use App\Models\Permission;
use App\Models\Role;

class PermissionControllerTest extends ControllerTestCase
{
    protected string $class = Permission::class;
    protected string $endpoint = 'permissions';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Permission();
    }

    public function testSaveRoles()
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

        $permission_id = $result->json('permission.id');

        foreach ($roles as $role) {
            $this->assertDatabaseHas('role_has_permissions', [
                'permission_id' => $permission_id,
                'role_id' => $role->id
            ]);
        }
    }

    public function testUpdateRoles()
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $permission_id = $instance->id;
        $roles = factory(Role::class, 3)->create();

        $role_ids = '';
        foreach ($roles as $role) {
            $role_ids .= "$role->id, ";
        }
        $role_ids = rtrim($role_ids, ' ,');

        $attributes = ['roles' => $role_ids];

        $result = $this->call(
            'PUT',
            $this->base_path.$this->endpoint.'/'.$permission_id,
            $attributes
        );

        foreach ($roles as $role) {
            $this->assertDatabaseHas('role_has_permissions', [
                'permission_id' => $permission_id,
                'role_id' => $role->id
            ]);
        }
    }

    public function testDestroyRelations()
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $permission_id = $instance->id;
        $roles = factory(Role::class, 3)->create();

        foreach ($roles as $role) {
            $role->givePermissionTo($instance);
        }

        $result = $this->call(
            'DELETE',
            $this->base_path.$this->endpoint.'/'.$permission_id
        );

        foreach ($roles as $role) {
            $this->assertDatabaseMissing('role_has_permissions', [
                'role_id' => $role->id,
                'permission_id' => $permission_id
            ]);
        }
    }
}
