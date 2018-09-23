<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Transaction;
use App\User;
use App\Category;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();
        $userQuantaty = 1000;
        $categoryQuantaty = 30;
        $productQuantaty = 1000;
        $taransationQuantaty = 1000;
        factory(User::class, $userQuantaty)->create();
        factory(Category::class, $categoryQuantaty)->create();
        factory(Product::class, $productQuantaty)->create()->each(function ($product) {
            $category = Category::all()->random(mt_rand(1, 5))->pluck('id');
            $product->categories()->attach($category);
        });
        factory(Transaction::class, $taransationQuantaty)->create();
    }
}
