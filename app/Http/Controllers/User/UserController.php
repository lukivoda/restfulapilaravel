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
      
      // everything  that we get from the user request(client)
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
        $user  = User::findOrFail($id);

        $rules  = [
            //email input must be email and unique(except for the email that belongs to the current user)
           'email' => "email|unique:users,email,".$user->id,
           'password' => "min:6|confirmed",
           // admin field must be one of this  2 values(true or false)
           'admin' => "in:".User::ADMIN_USER.",".User::REGULAR_USER
        ];

         // if we have name key in request collection
        if($request->has('name')){
           $user->name = $request->name;
        }

         // if we have an email key in request collection and the email that we are getting from client is not equal with the user's email
        if($request->has('email') && $request->email != $user->email){
           $user->email = $request->email;
           // user is not longer verified
           $user->verified = User::UNVERIFIED_USER;
           //generate new verification token
           $user->verification_token = User::generateVerificationCode();
           //updateing the email in the users table
           $user->email =$request->email;
        }



        if($request->has('password')){
            //encrypting the new user password
            $user->password = bcrypt($request->password);
        }


        if($request->has('admin')){
            //if user is not verified
           if(!$user->verified){
            // 409 is conflict
            return response()->json(["error" => " Only verified users can modify the admin field","code" =>"409"],409);
           } 

           $user->admin = $request->admin; 
           
       }



       if(!$user->isDirty()) {
        //422 is unprocessed : the server understand the content of the request but can not process the request
         return response()->json(["error" => "You need to specify a different value to update","code" =>"422"],422);
       }

       $user->save();

       // status 200 0K
        return response()->json(['data' =>$user],200);
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

         // status 200 0K
        return response()->json(['data' =>$user],200);

    }
}
