<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // getting all the users that have transactions method(Buyer model is extending Users)
       $buyers = Buyer::has('transactions')->get();

       return response()->json(['data' => $buyers],200);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // finding the user that has transactions method(Buyer model is extending Users) or fail(throw an exception)
        $buyer = Buyer::has('transactions')->findOrFail($id);
       
        return response()->json(['data'=>$buyer],200);

    }

   
}
