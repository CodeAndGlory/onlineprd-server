<?php

namespace App\Services;

use App\Models\Model;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

/**
 * Class RoleService
 * @package App\Services
 */
class RoleService extends APIService
{
    /**
     * RoleService constructor.
     * @param  Request  $request
     * @param  Role  $role
     * @throws Exception
     */
    public function __construct(Request $request, Role $role)
    {
        $this->setModel($role);
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
            $role = parent::store($request);
            $permissions = $this->getRelationIDsFromRequest('permissions');

            if ([] !== $permissions && null !== $role) {
                $role->syncPermissions($permissions);
            }

            return $role;
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
            $role = parent::update($request, $model);
            $permissions = $this->getRelationIDsFromRequest('permissions');

            if ([] !== $permissions && null !== $role) {
                $role->syncPermissions($permissions);
            }

            return $role;
        }

        return null;
    }
}
