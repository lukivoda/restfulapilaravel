<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // getting all the users that have transactions method(Buyer model is extending User)
       $buyers = Buyer::has('transactions')->get();

       return $this->showAll($buyers);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // finding the user that has transactions method(Buyer model is extending User) or fail(throw an exception)
        $buyer = Buyer::has('transactions')->findOrFail($id);
       
        return $this->showOne($buyer);

    }

   
}
