<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transaction;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int) $transaction->id,
            'quantaty' => (int) $transaction->quantaty,
            'buyer' => (int) $transaction->buyer_id,
            'product' => (int) $transaction->product_id,
            'creation_date' => (string) $transaction->created_at,
            'last_change' => (string) $transaction->updated_at,
            'deleted_date' => isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show', $transaction->id),
                ],
                [
                    'rel' => 'transactions.categories',
                    'href' => route('transactions.categories.index', $transaction->id),
                ],
                [
                    'rel' => 'product',
                    'href' => route('products.show', $transaction->product_id),
                ],
                [
                    'rel' => 'transaction.seller',
                    'href' => route('transactions.sellers.index', $transaction->id),
                ],
                [
                    'rel' => 'buyer',
                    'href' => route('buyers.show', $transaction->buyer_id),
                ],
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'quantaty' => 'quantaty',
            'buyer' => 'buyer_id',
            'product' => 'product_id',

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
            'quantaty' => 'quantaty',
            'buyer_id' => 'buyer',
            'product_id' => 'product',
            'created_at' => 'creation_date',
            'updated_at' => 'last_change',
            'deleted_at' => 'deleted_date',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
