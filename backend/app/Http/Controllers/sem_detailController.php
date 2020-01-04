<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\sem_details;

class sem_detailController extends Controller
{
    //
    public static function update(sem_details $sem){
        DB::table('sem_details')
        ->where('sdid',$sem->sdid)
        ->update(['sem_number'=>$sem->sem_number ,'dep_code'=>$sem->dep_code]);
    }

    public static function getSdid($sem_numer,$dep){
       $data= DB::select("SELECT * FROM `sem_details` WHERE sem_number=$sem_numer && dep_code='$dep'");
      // dd($data);
       return $data[0]->sdid;
    }

}
