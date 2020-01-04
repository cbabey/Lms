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

class studentRegistrationController extends Controller
{
    //
    public static function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
    public static function readCSVFile(Request $req){
        dd($req->newFile);
        $customerArr = studentRegistrationController::csvToArray($req);
        return response()->json(['allDep'=>$req->newFile],200);
    }
    
    public static function getAllBatchs(){
        $year=DB::select("SELECT year FROM `batch`");
        return response()->json(['years'=>$year],200);
    }
    public static function getThearrayofGivenCsv($excel){
        $headers[0]=$excel -> getActiveSheet() -> getCell('A1') -> getValue();
        $headers[2]=$excel -> getActiveSheet() -> getCell('B1') -> getValue();

        $i=2;
        while ($excel -> getActiveSheet() -> getCell('A'.$i) -> getValue() != "")
        {
          $Subject[0][$i-1] = $excel -> getActiveSheet() -> getCell('A'.$i) -> getValue();
          $Subject[1][$i-1] = $excel -> getActiveSheet() -> getCell('B'.$i) -> getValue();
           $i++;
        }
        $arrayVal=array(
            "Headers"=>$headers,
            "body"=>$Subject
        );
        return $arrayVal;
    }

    public static function uploadResultCSV(Request $req){
        $path=Storage::disk('public')->put('impot.csv',$req->file);
        // 
        $excel = PHPExcel_IOFactory::load('uploads/'.$path);
      
        $excel -> setActiveSheetIndex(0);
        File::delete('uploads/'.$path);
        $arrayVal= studentRegistrationController::getThearrayofGivenCsv($excel);
         return response()->json(['fuckMe'=>$arrayVal] ,200);
     }

     public static function  getNewBatcName(){
        $users=DB::select("SELECT year FROM `batch` ORDER BY year DESC LIMIT 1");
        if (sizeof($users)==0) {
            return response()->json(['year'=>'2016'] ,200);
        }else{
           // dd($users[0]->year);
            $yr=(int)$users[0]->year;
            
            $yr+=1;
           
           return response()->json(['year'=> $yr] ,200);
        }
     }

     public static function UpdateNewStudents(Request $req){
         //Reading CSV
        $path=Storage::disk('public')->put('impot.csv',$req->file);
        // 
        $excel = PHPExcel_IOFactory::load('uploads/'.$path);
      
        $excel -> setActiveSheetIndex(0);
        File::delete('uploads/'.$path);
        $arrayVal= studentRegistrationController::getThearrayofGivenCsv($excel);
        //Updaing batch
        $users=DB::select("SELECT year FROM `batch` ORDER BY year DESC LIMIT 1");
        if (sizeof($users)==0) {
           $yr=2016;
        }else{
            
           // dd($users[0]->year);
            $yr=(int)$users[0]->year;
            
            $yr+=1;
           
        }

        DB::table('batch')->insert(
            ['numberOfStud'=>'120','year'=>$yr]
        );

        
        

      //  dd('Done');
      //Updaing semester
      semsterController::createSemsterstoNewBatch($yr);


        for ($i=1; $i <=sizeof($arrayVal['body'][0]) ; $i++) { 
            DB::table('student')->insert(
                ['indexNo'=>(string)$arrayVal['body'][0][$i],'name'=>(string)$arrayVal['body'][1][$i] ,'dep_code'=>'CM','year'=>$yr]
            );
        }
        app('App\Http\Controllers\UserController')->setAllUsers($yr);
        return response()->json(['message'=> 'Done'] ,200);
     
        
     }
     
}
