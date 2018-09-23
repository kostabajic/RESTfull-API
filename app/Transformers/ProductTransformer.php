<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Product;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier' => (int) $product->id,
            'stock' => (int) $product->quantaty,
            'seller' => (int) $product->seller_id,
            'title' => (string) $product->name,
            'details' => (string) $product->description,
            'situation' => (string) $product->status,
            'picture' => url("image/{$product->image}"),
            'creation_date' => (string) $product->created_at,
            'last_change' => (string) $product->updated_at,
            'deleted_date' => isset($product->deleted_at) ? (string) $product->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $product->id),
                ],
                [
                    'rel' => 'categories',
                    'href' => route('products.categories.index', $product->id),
                ],
                [
                    'rel' => 'transactions',
                    'href' => route('products.transactions.index', $product->id),
                ],
                [
                    'rel' => 'seller',
                    'href' => route('sellers.show', $product->seller_id),
                ],
                [
                    'rel' => 'products.buyers',
                    'href' => route('products.buyers.index', $product->id),
                ],
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'seller' => 'seller_id',
            'title' => 'name',
            'details' => 'description',
            'stock' => 'quantaty',
            'situation' => 'status',
            'picture' => 'image',
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
            'seller_id' => 'seller',
            'name' => 'title',
            'description' => 'details',
            'quantaty' => 'stock',
            'status' => 'situation',
            'image' => 'picture',
            'created_at' => 'creation_date',
            'updated_at' => 'last_change',
            'deleted_at' => 'deleted_date',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
