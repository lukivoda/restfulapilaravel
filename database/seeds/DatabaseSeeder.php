<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//disabling the foreign keys so that we can truncate the tables
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
      
      //truncating tables before every sedding
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        // accessing the DB facade to truncate the pivot table(we don't have model for the pivot tables)
        DB::table('category_product')->truncate();


        $usersQuantity = 1000;
        $categoriesQuantity = 30;
        $productsQuantity = 1000;
        $transactionsQuantity = 1000;

        factory(User::class,$usersQuantity)->create();
        factory(Category::class,$categoriesQuantity)->create();
        factory(Product::class,$productsQuantity)->create()->each(function($product){
        	// we are getting collection of id's(random()function gets 1 to 5 records from the categories table and than we put all the id's from the records in an array with pluck method)
           $categories = Category::all()->random(mt_rand(1,5))->pluck('id');
           //ataching the categories array with id's to products table
           $product->categories()->attach($categories);

        });
        factory(Transaction::class,$transactionsQuantity)->create();

    }
}
