<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\User;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Transformers\ProductTransformer;
use Illuminate\Auth\Access\AuthorizationException;

class SellerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.ProductTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-products')->except('index');
        $this->middleware('can:view,seller')->only(['index']);
        $this->middleware('can:sale,seller')->only(['store']);
        $this->middleware('can:edit-product,seller')->only(['update']);
        $this->middleware('can:delete-product,seller')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        if (request()->user()->tokenCan('manage-products') || request()->user()->tokenCan('read-general')) {
            $products = $seller->products;

            return $this->showAll($products);
        }
        throw new AuthorizationException('Invalid scope(s)');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $seller)
    {
        $roule = [
            'name' => 'required',
            'description' => 'required',
            'quantaty' => 'required|integer|min:1',
            'image' => 'required|image',
          ];
        $data = $request->all();
        $this->validate($request, $roule);
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $product = Product::create($data);

        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Seller              $seller
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $roule = [
            'status' => 'in :'.Product::AVAILABLE_PRODUCT.','.PRODUCT::UNAVAILABLE_PRODUCT,
            'quantaty' => 'integer|min:1',
            'image' => 'image',
          ];
        $data = $request->all();
        $this->validate($request, $roule);
        $this->checkSeller($product, $seller);
        $product->fill($request->intersect([
            'name',
            'description',
            'quantaty',
        ]));

        if ($request->has('status')) {
            $product->status = $request->status;
            if ($product->isAvailable() && $product->categories()->count() == 0) {
                return $this->errorResponse('This product mast have at least one category', 409);
            }
        }
        if ($request->has('image')) {
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }
        if ($product->isClean()) {
            return $this->errorResponse('You have to specifie value for product', 422);
        }
        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Seller $seller
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($product, $seller);

        Storage::delete($product->image);

        $product->delete();

        return $this->showOne($product);
    }

    protected function checkSeller(Product $product, Seller $seller)
    {
        if ($seller->id != $product->seller->id) {
            throw new HttpException(422, 'The specified seller is not owner of product');
        }
    }
}
