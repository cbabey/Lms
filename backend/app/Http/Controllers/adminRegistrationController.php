<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;

class adminRegistrationController extends Controller
{
    //
    
    public static function getAdminDetails(){
       $data= DB::select("SELECT department.Name,department.dep_code,users.name,users.email,users.password FROM `department` LEFT JOIN users ON department.dep_code=users.dep_code where department.dep_code!='CM' ");
        return response()->json(['users'=>$data],200);
    }
}
