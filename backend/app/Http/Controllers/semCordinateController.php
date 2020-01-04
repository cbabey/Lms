<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\semCordinate;
use Illuminate\Support\Facades\DB;

class semCordinateController extends Controller
{
    //
    public static function update(semCordinate $sem){
        DB::table('semcordinate')
        ->where('sdid',$sem->sdid)->where('courceCode',$sem->courceCode)
        ->update(['type'=>$sem->type ,'buctNumber'=>$sem->buctNumber,'crLimit'=>$sem->crLimit]);
    }
    public static function insert(semCordinate $sem){

        DB::table('semcordinate')->insert(
            ['sdid'=>$sem->sdid,'courceCode'=>$sem->courceCode,'type'=>$sem->type ,'buctNumber'=>$sem->buctNumber,'crLimit'=>$sem->crLimit]
        );
    }
    public static function ChangeAllGivencrLimit($type,$sdid,$buct,$newCr){
        $data= DB::select("SELECT * FROM `semcordinate` WHERE sdid=$sdid && type='$type' && buctNumber=$buct");
        foreach ($data as $key => $value) {
            $value->crLimit=$newCr;
           // semCordinateController::update($value);
            DB::table('semcordinate')
        ->where('sdid',$value->sdid)->where('courceCode',$value->courceCode)
        ->update(['type'=>$value->type ,'buctNumber'=>$value->buctNumber,'crLimit'=>$value->crLimit]);
        }
     }

     public static function Delete($sdid,$courseCode){

        DB::table('semcordinate')->where('sdid',$sdid)->where('courceCode',$courseCode)->delete();

    }


}
