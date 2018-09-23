<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Transformers\TransactionTransformer;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-produts')->only(['store']);
        $this->middleware('can:purchase,buyer')->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rule = [
           'quantaty' => 'required|integer|min:1',
       ];
        $this->validate($request, $rule);
        if ($buyer->id == $product->seller->id) {
            return $this->errorResponse('The seller of product cant by buyer', 409);
        }
        if (!$buyer->isVerified()) {
            return $this->errorResponse('Buyer must be verified', 409);
        }
        if (!$product->seller->isVerified()) {
            return $this->errorResponse('Seller must be verified', 409);
        }
        if (!$product->isAvailable()) {
            return $this->errorResponse('Product mast by available', 409);
        }
        if ($product->quantaty < $request->quantaty) {
            return $this->errorResponse('Product does not have enough units for transaction', 409);
        }

        return DB::transaction(function () use ($request,$buyer,$product) {
            $product->quantaty -= $request->quantaty;
            $product->save();
            $transaction = Transaction::create([
                'quantaty' => $request->quantaty,
                'product_id' => $product->id,
                'buyer_id' => $buyer->id,
            ]);

            return $this->showOne($transaction);
        });
    }
}
