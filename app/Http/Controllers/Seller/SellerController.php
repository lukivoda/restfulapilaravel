<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // getting all the users that have products method(Seller model is extending User)
        $sellers = Seller::has('products')->get();

        return response()->json(['data' => $sellers],200);
    }

  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // finding the user that has products method(Seller model is extending User) or fail(throw an exception)
       $seller =  Seller::has('products')->findOrFail($id);

       return response()->json(['data' => $seller],200);
    }

   
}
