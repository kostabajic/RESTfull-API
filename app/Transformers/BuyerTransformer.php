<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Buyer;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int) $buyer->id,
            'name' => (string) $buyer->name,
            'email' => (string) $buyer->email,
            'isVerified' => (int) $buyer->verified,
            'creation_date' => (string) $buyer->created_at,
            'last_change' => (string) $buyer->updated_at,
            'deleted_date' => isset($buyer->deleted_at) ? (string) $buyer->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $buyer->id),
                ],
                [
                    'rel' => 'buyers.products',
                    'href' => route('buyers.products.index', $buyer->id),
                ],
                [
                    'rel' => 'transactions',
                    'href' => route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel' => 'buyers.sellers',
                    'href' => route('buyers.sellers.index', $buyer->id),
                ],
                [
                    'rel' => 'buyers.categories',
                    'href' => route('buyers.categories.index', $buyer->id),
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

            'creation_date' => 'created_at',
            'last_change' => 'updated_at',
            'deleted_date' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function trensformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'verified' => 'isVerified',
            'created_at' => 'creation_date',
            'updated_at' => 'last_change',
            'deleted_at' => 'deleted_date',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
