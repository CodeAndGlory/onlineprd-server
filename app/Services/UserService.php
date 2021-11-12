<?php

namespace App\Services;

use App\Models\Model;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RuntimeException;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends APIService
{
    /**
     * UserService constructor.
     * @param  Request  $request
     * @param  User  $user
     * @throws Exception
     */
    public function __construct(Request $request, User $user)
    {
        $this->setModel($user);
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
            $departments = $this->getRelationIDsFromRequest('departments');
            $roles = $this->getRelationIDsFromRequest('roles');
            $user = parent::store($request);

            if (null !== $user) {
                if ([] !== $departments) {
                    $user->departments()->sync($departments, false);
                }
                if ([] !== $roles) {
                    $user->syncRoles($roles);
                }
            }

            return $user;
        }

        return null;
    }

    /**
     * @param  Request  $request
     * @param  Model|null  $model
     * @throws Exception
     */
    public function validate(Request $request, Model $model = null): void
    {
        if (null !== $model) {
            $validator = Validator::make(
                $request->all(),
                [
                    'first_name' => 'max:120',
                    'last_name' => 'max:120',
                    'email' => [
                        'email',
                        Rule::unique('users')->ignore($model),
                    ],
                    'spartan_id' => [
                        'integer',
                        'between:880000000,889999999',
                        Rule::unique('users')->ignore($model),
                    ],
                ]);
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'first_name' => 'max:120',
                    'last_name' => 'max:120',
                    'email' => 'email|unique:users',
                    'spartan_id' => [
                        'integer',
                        'between:880000000,889999999',
                        'unique:users',
                    ],
                ]);
        }

        $errors = $validator->errors();
        $messages = $errors->getMessages();
        if (count($messages) > 0) {
            foreach ($messages as $type => $message) {
                throw new RuntimeException($message[0], 422);
            }
        }
    }

    /**
     * @param  Request  $request
     * @param  Model  $model
     * @return Model|null
     */
    public function update(Request $request, Model $model): ?Model
    {
        $user = parent::update($request, $model);
        if (null !== $user) {
            $departments = $this->getRelationIDsFromRequest('departments');
            $roles = $this->getRelationIDsFromRequest('roles');

            if ([] !== $departments) {
                $user->departments()->sync($departments);
            }
            if ([] !== $roles) {
                $user->syncRoles($roles);
            }

            return $user;
        }

        return null;
    }

    /**
     * @param  Model  $model
     */
    public function delete(Model $model): void
    {
        $model->departments()->detach();
        $model->roles()->detach();
        parent::delete($model);
    }

    /**
     * @return array
     */
    public
    function getUserInfo(): array
    {
        $result = [
            'error' => false,
        ];

        $user = auth()->user();
        if (null !== $user) {
            $result['user'] = $user
                ->with('departments')
                ->where('id', $user->id)
                ->get()[0];

            if ($user->hasRole('Super Admin')) {
                $result['rules'] = [
                    [
                        'actions' => [
                            'create',
                            'read',
                            'update',
                            'delete'
                        ],
                        'subject' => [
                            'all',
                        ],
                    ]
                ];
            } else {
                $permissions_collection = $user->getAllPermissions();
                $permissions = [];

                foreach ($permissions_collection->all() as $permission) {
                    try {
                        $permissions[] = $this->formatPermission($permission->name);
                    } catch (Exception $e) {
                        $result['error'] .= "$e\n";
                    }
                }

                $result['rules'] = $this->getRules($permissions);
            }
        }

        return $result;
    }

    public function getCountOfUnverified(): array
    {
        $result = [
            'error' => false,
        ];

        $query = $this->model
            ->where('verified', 0)
            ->get();

        $result['count'] = $query->count();

        return $result;
    }

    /**
     * @param  string  $permission
     * @return false|string[]
     * @throws Exception
     */
    public function formatPermission(string $permission)
    {
        $prefixes = [
            'create',
            'update',
            'read',
            'delete',
        ];

        $permission_split = explode(' ', $permission, 2);

        if (!in_array($permission_split[0], $prefixes, true)) {
            throw new RuntimeException("Invalid action: $permission_split[0]");
        }

        return $permission_split;
    }

    /**
     * @param  array  $permissions
     * @return array
     */
    public function getRules(array $permissions): array
    {
        $subjects = [];
        $rules = [];
        foreach ($permissions as $permission) {
            $subjects[$permission[1]][] = $permission[0];
        }

        foreach ($subjects as $subject => $actions) {
            $rules[] = [
                'actions' => $actions,
                'subject' => [$subject],
            ];
        }

        return $rules;
    }
}
