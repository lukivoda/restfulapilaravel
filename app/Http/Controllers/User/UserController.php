<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
       
        return response()->json(['data'=>$users],200);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $rules = [
       
       'name' =>'required',
       'email' =>'required|email|unique:users',
       'password' =>'required|min:6|confirmed'
           
       ];

       $this->validate($request,$rules);

       $data = $request->all();

       $data['password'] =  bcrypt($request->password);
       $data['verified'] =  User::UNVERIFIED_USER;
       $data['verification_token'] = User::generateVerificationCode();
       $data['admin'] = User::REGULAR_USER;

       $user = User::create($data);
       // status 201 data created
       return response()->json(['data' => $user],201);
   
       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // we need findOrFail method to get en exception if we don't have the user we want(we are going to handle the exception later so that we can have proper json response in that case)
              $user = User::findOrFail($id);
                     // status 200 0K
              return response()->json(['data' =>$user],200);

    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
