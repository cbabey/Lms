<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;


class UserController extends Controller
{
    public function userLogin(Request $request){
      $validator = Validator::make($request->all(), [
      'email'=>'required|email',
      'password'=>'required'
      ]);

      if($validator->fails()){
          return response()->json(['error'=>$validator->errors()],401);
      }
      if(Auth::attempt(['email'=>request('email'), 'password'=>request('password')])){
          $user=Auth::user();
          $success['token']=$user->createToken('MyApp')->accessToken;
          $usName=DB::select("SELECT name,dep_code FROM `users` WHERE email='$request->email'");
          return response()->json(['success'=>$success,'userName'=>$usName[0]->name,'type'=>$usName[0]->dep_code],200);

      }
      else{
        return response()->json(['error'=>'Unauthorised'],401);
      }
    }

    public function setAllUsers($year){
        $usName=DB::select("SELECT * FROM `student` WHERE year='$year'");
        foreach ($usName as $key => $value) {
            # code...
            // p1 =  response()->json(['error'=>'Unauthorised'],401);
            $input =  array('name'=> $value->name,'email'=>$value->indexNo,'password'=>$value->indexNo.'110','c_password'=>$value->indexNo.'110');
            // print_r($input);
            $input['password']=bcrypt( $input['password']);
       
            $user=User::create($input);
        }
        // $a1=array(
        //     'com'=>$content['com'],'ele'=>$content['ele'],'opo'=>$content['opo']
        //    );
    
        // $p1=['error'=>'Unauthorised'];a
       
        // $this->studentRegister($p1);
        
        
    }

    public function studentLogin(Request $request){
        
        if(Auth::attempt(['email'=>request('email'), 'password'=>request('password')])){
            $user=Auth::user();
            $success['token']=$user->createToken('MyApp')->accessToken;
        //  $usName=DB::select("SELECT name,dep_code FROM `users` WHERE email='$request->email'");
         $usName=DB::select("SELECT * FROM `student` WHERE indexNo='$request->email'");
            return response()->json(['success'=>$success,'userName'=>$usName[0]->name,'Department'=>$usName[0]->dep_code,'Year'=>$usName[0]->year,'index'=>$usName[0]->indexNo,'type'=>"SU"],200);
        }
        else{
          return response()->json(['error'=>'Unauthorised'],401);
        }
      }

    public function UpdatingUser (Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password',
            
            ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()],401);
            }

         //nuserController::UserLoginInsert($request);

         $input=$request->all();
         $input['password']=bcrypt( $input['password']);

         DB::table('users')
            ->where('email',  $input['oldEmail'])
            ->update(['name' =>  $input['name'],"email"=> $input['email'],"password"=> $input['password']]);

         
         return response()->json(['success'=>'Done'],200);
    }

    public function userRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password',
            
            ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()],401);
            }

         //nuserController::UserLoginInsert($request);

         $input=$request->all();
         $input['password']=bcrypt( $input['password']);
         $user=User::create($input);
         $success['token'] = $user->createToken('MyApp')->accessToken;
         $success['name'] = $user->name;
         return response()->json(['success'=>$success,'userName'=>$request->name],200);
    }

    
    public function studentRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'c_password'=>'required|same:password',
            
            ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()],401);
            }

         //nuserController::UserLoginInsert($request);

         $input=$request->all();
         $input['password']=bcrypt( $input['password']);
         $user=User::create($input);
         $success['token'] = $user->createToken('MyApp')->accessToken;
         $success['name'] = $user->name;
         return response()->json(['success'=>$success,'userName'=>$request->name],200);
    }



    public function userDetails(){
        $users= User::get();
        return response()->json(['success'=>$users],200);   
    }


    public function logout(){
       auth()->user()->tokens->each(function($token,$key){

        $token->delete();
       }); 
       return response()->json('logged out successfully',200);   
    }
    public function classDetails(){
        $users = DB::select ('select * from  class');
      
    
        return response()->json(['users'=>$users],200);
    }
}
