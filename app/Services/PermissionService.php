<?php

namespace App\Services;

use App\Models\Model;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

/**
 * Class PermissionService
 * @package App\Services
 */
class PermissionService extends APIService
{
    /**
     * PermissionService constructor.
     * @param  Request  $request
     * @param  Permission  $permission
     * @throws Exception
     */
    public function __construct(Request $request, Permission $permission)
    {
        $this->setModel($permission);
        parent::__construct($request);
    }

    /**
     * @param  Request  $request
     * @return Model|null
     */
    public function store(Request $request): ?Model
    {
        try {
            $this->validate($request);
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }

        if (false === $this->error) {
            $permission = parent::store($request);
            $roles = $this->getRelationIDsFromRequest('roles');

            if ([] !== $roles) {
                foreach ($roles as $role) {
                    $roleObject = Role::where('id', $role)->get()->first();
                    if ($roleObject) {
                        $roleObject->givePermissionTo($permission);
                    }
                }
            }

            return $permission;
        }

        return null;

    }

    /**
     * @param  Request  $request
     * @param  Model  $model
     * @return Model|null
     */
    public function update(Request $request, Model $model): ?Model
    {
        try {
            $this->validate($request);
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }

        if (false === $this->error) {
            $permission = parent::update($request, $model);
            $roles = $this->getRelationIDsFromRequest('roles');

            if ([] !== $roles) {
                foreach ($roles as $role) {
                    $roleObject = Role::where('id', $role)->get()->first();
                    if ($roleObject) {
                        $roleObject->givePermissionTo($permission);
                    }
                }
            }

            return $permission;
        }

        return null;
    }
}
