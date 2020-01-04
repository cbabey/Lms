<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\minor;
class minorController extends Controller
{
       public static function update(minor $m){
        DB::table('minor')
        ->where('mid',$m->mid)
        ->update(['name'=>$m->name ,'totalCredits'=>$m->totalCredits , 'details'=>$m->details,'dep_code'=>$m->dep_code]);
    }
    public static function getSdid($MinorName,$dep_code){
        $data= DB::select("SELECT * FROM `minor` WHERE name='$MinorName' && dep_code='$dep_code'");
        return $data[0]->mid;
     }
}
