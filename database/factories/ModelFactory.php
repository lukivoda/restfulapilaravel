<?php

use App\User;
use App\Seller;
use App\Product;
use App\Category;
use App\Transaction;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        // picking random element from the 2 elements in the array
        'verified' => $verified = $faker->randomElement([User::UNVERIFIED_USER,USER::VERIFIED_USER]),
        //if the user is verified the value is null,if not we generate verification token from the method in User model
        'verification_token' => $verified ==  USER::VERIFIED_USER ? null :USER::generateVerificationCode(),
        // picking random element from the 2 elements in the array(admin or regular user)
        'admin' => $verified = $faker->randomElement([User::ADMIN_USER,USER::REGULAR_USER]),
    ];
});




$factory->define(Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
   
    ];
});



$factory->define(Product::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' =>$faker->numberBetween(1,10),
        'status'  =>$faker->randomElement([Product::AVAILABLE_PRODUCT,Product::UNAVAILABLE_PRODUCT]),
        'image' => $faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
        'seller_id' =>User::all()->random()->id,

    ];
});



$factory->define(Transaction::class, function (Faker\Generator $faker) {

       //getting random object from the users table(we are filtering the users based on the relation with Product model(products method)(Seller model class is extended from User model class) ) 
      $seller = Seller::has('products')->get()->random();
      //getting random object from the users table(except the ones with id=$seller->id)
      $buyer = User::all()->except($seller->id)->random();

    return [
        'quantity' =>$faker->numberBetween(1,3),
         'buyer_id' => $buyer->id,
         //getting random id from the users(only from the users that have products(relation with products))
         'product_id' => $seller->products->random()->id,
    ];
});

