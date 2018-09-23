<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'isVerified' => (int) $user->verified,
            'isAdmin' => ($user->admin == 'true'),
            'creation_date' => (string) $user->created_at,
            'last_change' => (string) $user->updated_at,
            'deleted_date' => isset($user->deleted_at) ? (string) $user->deleted_at : null,
            'links' => [
                [
                    'ref' => 'self',
                    'href' => route('users.show', $user->id),
                ],
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'isAdmin' => 'admin',
            'creation_date' => 'created_at',
            'last_change' => 'updated_at',
            'deleted_date' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'verified' => 'isVerified',
            'admin' => 'isAdmin',
            'created_at' => 'creation_date',
            'updated_at' => 'last_change',
            'deleted_at' => 'deleted_date',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
