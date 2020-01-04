<?php

namespace App\Http\Controllers;
use App\department;
use App\sem_details;
use App\course;
use Debugbar;
use App\includesminor;
use App\minor;
use Log;
//use \Debugbar;
use App\semCordinate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Barryvdh\Debugbar\Facade as Debugbar;
use PHPExcel; 
use PHPExcel_IOFactory;
use Storage;
use File;

class semsterController extends Controller
{
    //
    public static function createSemsterstoNewBatch($batch){
        // =2016;
        $sem=DB::select('select sdid from sem_details');
        //dd($sem[0]->sdid);
        foreach ($sem as $key => $value) {
            DB::table('semester')->insert(
                ['status'=>1,'year'=>$batch ,'sdid'=>$value->sdid]
            );
        }

     

    }
}
