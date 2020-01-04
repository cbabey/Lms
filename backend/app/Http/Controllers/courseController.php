<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\course;
class courseController extends Controller
{
    public static function update(course $cou){
        DB::table('course')
        ->where('courceCode',$cou->courceCode)
        ->update(['title'=>$cou->title ,'gpaContribution'=>$cou->gpaContribution,'credits'=>$cou->credits,'preVisit'=>$cou->preVisit,'depCode'=>$cou->depCode]);
    }
    public static function insert(course $cou){

        DB::table('course')->insert(
            ['courceCode'=>$cou->courceCode,'title'=>$cou->title ,'gpaContribution'=>$cou->gpaContribution,'credits'=>$cou->credits,'preVisit'=>$cou->preVisit,'depCode'=>$cou->depCode]
        );
    }
    public static function delete( $cou){

        DB::table('course')->where('courceCode',$cou)->delete();
    }
}
