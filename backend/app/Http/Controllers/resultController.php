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

class resultController extends Controller
{
    public static function uploadResult(Request $req){
        $path=Storage::disk('public')->put('impot.csv',$req->file);
        // 
        $excel = PHPExcel_IOFactory::load('uploads/'.$path);
      
        $excel -> setActiveSheetIndex(0);
        File::delete('uploads/'.$path);
        $arrayVal= studentRegistrationController::getThearrayofGivenCsv($excel);
        //dd($arrayVal['body'][1][1])  ;

        $ssid = DB::select("SELECT sid FROM `semester` INNER JOIN  sem_details ON semester.sdid=sem_details.sdid WHERE sem_details.sem_number=$req->sem AND semester.year=$req->batch AND sem_details.dep_code='$req->dep'");
        
        
        for ($i=1; $i <=sizeof($arrayVal['body'][0]) ; $i++) { 
            DB::table('enroll')->insert(
                ['indexNo'=>(string)$arrayVal['body'][0][$i], 'couceCode'=>$req->code,'result'=>(string)$arrayVal['body'][1][$i] ,'sid'=>$ssid[0]->sid]
            );
        }
        //dd('sldfkhslkd');
        return response()->json(['message'=> 'Done'] ,200);

    } 
    //resultController@getAllRepeatedSubjects
    public static function getAllRepeatedSubjects($index){
        

        $index=str_replace("_","/",$index);
        $users =DB::select("SELECT enroll.result, enroll.indexNo,enroll.couceCode,course.title,sem_details.sem_number FROM `enroll` INNER JOIN course ON enroll.couceCode=course.courceCode INNER JOIN semester ON enroll.sid=semester.sid INNER JOIN sem_details ON semester.sdid=sem_details.sdid WHERE enroll.indexNo='$index' AND (enroll.result='R' OR enroll.result='F')");

        return response()->json(['value'=> $users] ,200);
    }
    //SELECT * FROM `semester` INNER JOIN  sem_details ON semester.sdid=sem_details.sdid WHERE sem_details.sem_number=3 AND semester.year=2016 AND sem_details.dep_code='CO'

    public static function getCourceDetails($code,$year){
        $content= addCourceController::tempOfabcove($code);
        //$year=2016;
        foreach ($content['com'] as $key => $value) {
            # code...
           // dd($value);
            $avb=DB::select("SELECT enroll.sid FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND semester.year=$year");
            if (sizeof($avb)>0) {
                # code...
                $value->title=$value->title."/"."1";
            }else{
                $value->title=$value->title."/"."0";
            }
        }

        foreach ($content['ele'] as $key => $value1) {
            # code...
           // dd($value);
            foreach ($value1 as $key => $value) {
                $avb=DB::select("SELECT enroll.sid FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND semester.year=$year");
                    if (sizeof($avb)>0) {
                        # code...
                        $value->title=$value->title."/"."1";
                    }else{
                        $value->title=$value->title."/"."0";
                    }
            }
        }

        
        foreach ($content['opo'] as $key => $value1) {
            # code...
           // dd($value);
            foreach ($value1 as $key => $value) {
                $avb=DB::select("SELECT enroll.sid FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND semester.year=$year");
                    if (sizeof($avb)>0) {
                        # code...
                        $value->title=$value->title."/"."1";
                    }else{
                        $value->title=$value->title."/"."0";
                    }
            }
        }
        
        
        #array_push($content['com'][0],"status");
       // dd($content['opo']);
        
        return response()->json(['com'=>$content['com'],'ele'=>$content['ele'],'opo'=>$content['opo']],200);

    }


    
    public static function getCourceDetailsWithREsults($code,$year,$index){
        $Point=0;$countCredit=0;
        $content= addCourceController::tempOfabcove($code);
       //dd($index);
        $index=str_replace("_","/",$index);
       // dd($index);
        //$year=2016;
       
        foreach ($content['com'] as $key => $value) {
            # code...
            //dd($value);
            $avb=DB::select("SELECT enroll.result FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND enroll.indexNo='$index'");
            //dd($avb);
            if (sizeof($avb)>0) {
                # code...
                if ($value->gpaContribution==1) {
                    # code...
                   // dd(resultController::resultTOGPA((string)$avb[0]->result));
                    $Point+=(resultController::resultTOGPA((string)$avb[0]->result)*(int)$value->credits);
                   // dd($Point);
                    
                    $countCredit+=$value->credits;
                }
                
                $value->title=$value->title."/".(string)$avb[0]->result;
            }else{
                $value->title=$value->title."/"."-";
            }
        }
       // dd($content['com']);
       // dd($content['com']);

        foreach ($content['ele'] as $key => $value1) {
            # code...
           // dd($value);
            foreach ($value1 as $key => $value) {
                $avb=DB::select("SELECT enroll.result FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND enroll.indexNo='$index'");
                    if (sizeof($avb)>0) {
                        # code...
                        if ($value->gpaContribution==1) {
                            # code...
                            $Point+=(resultController::resultTOGPA((string)$avb[0]->result)*$value->credits);
                            $countCredit+=$value->credits;
                        }
                        
                        $value->title=$value->title."/".(string)$avb[0]->result;
                    }else{
                        $value->title=$value->title."/"."-";
                    }
            }
        }

        
        foreach ($content['opo'] as $key => $value1) {
            # code...
           // dd($value);
            foreach ($value1 as $key => $value) {
                $avb=DB::select("SELECT enroll.result FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND enroll.indexNo='$index'");
                    if (sizeof($avb)>0) {
                        # code...
                        if ($value->gpaContribution==1) {
                            # code...
                            $Point+=(resultController::resultTOGPA((string)$avb[0]->result)*$value->credits);
                            $countCredit+=$value->credits;
                        }
                        $value->title=$value->title."/".(string)$avb[0]->result;
                    }else{
                        $value->title=$value->title."/"."-";
                    }
            }
        }
        
        
        #array_push($content['com'][0],"status");
       // dd($content['opo']);
       //dd($Point);
       if ($countCredit>0) {
           # code...
           $gpa=$Point/$countCredit;
       }else{
           $gpa="-";
       }
        
        return response()->json(['com'=>$content['com'],'ele'=>$content['ele'],'opo'=>$content['opo'],'gpa'=>$gpa],200);

    }

    public static function resultTOGPA($res){
        
        $Point=0;
      //  $res="B";
        switch ($res) {
            case 'A+':
                # code...
                $Point=4.0;
                break;
            case 'A':
                # code...
                $Point=4.0;
                break;
            case 'A-':
                # code...
                
                $Point=3.7;
                break;
            case 'B+':
                # code...
                $Point=3.3;
                break;
            case 'B':
                # code...
                
                $Point=3.0;
               // dd($Point);
                break;
            case 'B-':
                # code...
                $Point=2.7;
                break;
            case 'C+':
                # code...
                $Point=2.3;
                break;
            case 'C':
                # code...
                $Point=2.0;
                break;
            
            default:
                # code...
              
                break;
        
        }
       // dd($Point);
        return $Point;
    }

    public static function getResultbySem($code,$year,$index){
        
        $content= addCourceController::tempOfabcove($code);
        $Point=0;

        dd($index);
        $index=str_replace("_","/",$index);
       // dd($index);
        //$year=2016;
       
        foreach ($content['com'] as $key => $value) {
            # code...
           // dd($value);
            $avb=DB::select("SELECT enroll.result FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND enroll.indexNo='$index'");
           // dd($avb);
            if (sizeof($avb)>0) {
                # code...
                
                $value->title=$value->title."/".(string)$avb[0]->result;
            }else{
                $value->title=$value->title."/"."-";
            }
        }
       // dd($content['com']);

        foreach ($content['ele'] as $key => $value1) {
            # code...
           // dd($value);
            foreach ($value1 as $key => $value) {
                $avb=DB::select("SELECT enroll.result FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND enroll.indexNo='$index'");
                    if (sizeof($avb)>0) {
                        # code...
                        $value->title=$value->title."/".(string)$avb[0]->result;
                    }else{
                        $value->title=$value->title."/"."-";
                    }
            }
        }

        
        foreach ($content['opo'] as $key => $value1) {
            # code...
           // dd($value);
            foreach ($value1 as $key => $value) {
                $avb=DB::select("SELECT enroll.result FROM `enroll` INNER JOIN semester ON enroll.sid=semester.sid WHERE enroll.couceCode='$value->courceCode' AND enroll.indexNo='$index'");
                    if (sizeof($avb)>0) {
                        # code...
                        $value->title=$value->title."/".(string)$avb[0]->result;
                    }else{
                        $value->title=$value->title."/"."-";
                    }
            }
        }
        
        
        #array_push($content['com'][0],"status");
       // dd($content['opo']);

       $a1=array(
        'com'=>$content['com'],'ele'=>$content['ele'],'opo'=>$content['opo']
       );

       return $a1;
        
        //return response()->json(['com'=>$content['com'],'ele'=>$content['ele'],'opo'=>$content['opo']],200);
    }

    public static function getSubjectResult(Request $req){
        $users =DB::select("SELECT enroll.indexNo,enroll.result FROM`enroll` INNER JOIN semester ON enroll.sid=semester.sid INNER JOIN sem_details ON semester.sdid=sem_details.sdid WHERE enroll.couceCode='$req->code' AND semester.year=$req->batch AND sem_details.dep_code='$req->dep' AND sem_details.sem_number=$req->sem");
        //dd($users[0]->indexNo);
        return response()->json(['reults'=>$users],200);
    }

    public static function updateResult(Request $req){
        DB::table('enroll')
        ->where('couceCode',$req->code)
        ->where('indexNo',$req->index)
        ->update(['result'=>$req->res]);
        return response()->json(['messagee'=>'done'],200);
    }

    //resultController@getAllGPAforSubject
    public static function getAllGPAforSubject($index){
        $index=str_replace("_","/",$index);
        //dd($index);
       $values= DB::select("SELECT enroll.result,course.gpaContribution,course.credits FROM `enroll` INNER JOIN course ON enroll.couceCode=course.courceCode WHERE enroll.indexNo='$index' ");
        $points=0;
        $credits=0;
        //dd($values);
       foreach ($values as $key => $value) {
           # code...
           if ($value->gpaContribution==1) {
            # code...
           // dd($value);
            $points+=(resultController::resultTOGPA((string)$value->result)*$value->credits);
            $credits+=$value->credits;
        }
       }

       $gpa=$points/$credits;

       return response()->json(['gpa'=>$gpa],200);
    }

}
