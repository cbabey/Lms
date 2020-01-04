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
class addCourceController extends Controller
{   
    public $passCourceDetial='';
    //
    public static function getAllDataFromDepartment(){
        $data=department::all();
        return response()->json(['allDep'=>$data],200);
       
    }

    public static function addNewBuc($val){
        $sem_detils=DB::select();
      
    }
    public static function getALLSelectedFiledSemesters($code){

        $users=DB::select("SELECT * FROM `sem_details` WHERE dep_code='$code' ");
        return response()->json(['allDep'=>$users],200);
    }
    public static function getAllCources($code1,$code2){
        //$data=course::all();
        $data=DB::select("SELECT sem_details.sem_number,sem_details.dep_code,semcordinate.courceCode FROM `sem_details` INNER JOIN semcordinate ON sem_details.sdid=semcordinate.sdid WHERE (sem_details.dep_code='$code1' OR sem_details.dep_code='CM') AND sem_details.sem_number < '$code2'");
        return response()->json(['allCo'=>$data],200);
    }
    public static function getAllSelMinors($code)
    {
        $data=DB::select("SELECT * FROM `minor` WHERE dep_code='$code' ");
        return response()->json(['allCo'=>$data],200);
    }

    public static function setMinorCorrectly($elecGroup){
    //   \Debugbar::info($elecGroup);
        $newele=[];
        for ($i=0; $i <sizeof($elecGroup) ; $i++) { 
            $boolCOn=true;
            $tempMinor='';
           for ($j=0; $j <sizeof($newele) ; $j++) { 
               if ($newele[$j]->courceCode==$elecGroup[$i]->courceCode) {
                   $boolCOn=false;
               }
  
           }
           if ($boolCOn) {
               # code...
               $isAvi=true;
               for ($k=0; $k <sizeof($elecGroup) ; $k++) { 
                 //  
                    if (($elecGroup[$i]->courceCode==$elecGroup[$k]->courceCode) && ($elecGroup[$k]->name != $elecGroup[$i]->name)) {
                        $tempMinor=$tempMinor." / ".($elecGroup[$k]->name);
                       //dd($elecGroup);
                      // Debugbar::info($tempMinor);
                        $isAvi=false;
                    }
               }
               if ($isAvi) {
                  # code...
                  array_push($newele,$elecGroup[$i]);
              }else {
                  $elecGroup[$i]->name=($elecGroup[$i]->name).$tempMinor;
                  array_push($newele,$elecGroup[$i]);
              }
               
           }
  
  
        }

        return $newele;
    }
    public static function getCourceDetils($code){
        
       


        $users=DB::select("SELECT semcordinate.courceCode,semcordinate.type,semcordinate.buctNumber,semcordinate.crLimit ,course.title, course.gpaContribution ,course.credits,course.preVisit ,includesminor.mid,minor.name FROM semcordinate INNER JOIN course ON course.courceCode=semcordinate.courceCode LEFT JOIN includesminor ON course.courceCode=includesminor.courceCode LEFT JOIN minor ON includesminor.mid=minor.mid where semcordinate.sdid='$code';");
        info('This is some useful information.');
       
        $elec=[];
        $optio=[];
        $elecGroup=[];
        $elecGroupOP=[];
        $comp=[];
        foreach ($users as $key => $value) {
            if($value->type=='E'){
                array_push($elec,$value);
                
              }else if($value->type=='O'){
                array_push($optio,$value);
              }else{
                array_push($comp,$value);
              }
        }
        if (sizeof($elec)>0) {
            $tempArray=$elec[0];
            $ttAr=[];
            $te=[];



            foreach ($elec as $key => $value1) {
                # code...
               //dd($value1);
                $buckNo=$value1->buctNumber;
                $isAvaible = true;
                foreach ($te as $key => $vale) {
                    # code...
                    
                        //if (condition) {
                            # code...
                            if ($vale[0]->buctNumber==$buckNo) {
                                $isAvaible=false;
                                break;
                            }
                      //  }
                
                }
                if ($isAvaible) {
                    # code...
                    $temAr=[];
                    foreach ($elec as $key => $value2) {
                        if ($value2->buctNumber==$buckNo) {
                            # code...
                            array_push($temAr,$value2);
                        }
                    }
                    array_push($te,addCourceController::setMinorCorrectly($temAr));

                }
            }
           // dd('hello');
            $elecGroup=$te;


/*
            foreach ($elec as $key => $value) {
                if($tempArray->buctNumber==$value->buctNumber){
                    array_push($ttAr,$value);
                }else{
                    $tempArray=$value;
                    array_push($elecGroup,addCourceController::setMinorCorrectly($ttAr));
                    $ttAr=[];
                    array_push($ttAr,$value);
                }
            }
          // dd(addCourceController::setMinorCorrectly($ttAr));
         
            array_push($elecGroup,addCourceController::setMinorCorrectly($ttAr));
  */          
        }
        if (sizeof($optio)>0) {
            $tempArray1=$optio[0];
            $ttAr1=[];
            foreach ($optio as $key => $value) {
                if($tempArray1->buctNumber==$value->buctNumber){
                    array_push($ttAr1,$value);
                }else{
                    $tempArray1=$value;
                    array_push($elecGroupOP,addCourceController::setMinorCorrectly($ttAr1));
                    $ttAr1=[];
                    array_push($ttAr1,$value);
                }
            }
            array_push($elecGroupOP,addCourceController::setMinorCorrectly($ttAr1));
        }
       // \Debugbar::info($elecGroup);
       $newcomp=addCourceController::setMinorCorrectly($comp);
         /*
        for ($i=0; $i <sizeof($comp) ; $i++) { 
            $boolCOn=true;
            $tempMinor='';
          for ($j=0; $j <sizeof($newcomp) ; $j++) { 
             
               if ($newcomp[$j]->courseCode == $comp[$i]->courseCode) {
                   $boolCOn=false;
               }

           }*/
/*

           foreach ($newcomp as $key => $value) {
            if ($value->courceCode == $comp[$i]->courceCode) {
                $boolCOn=false;
            }
           }
           
           if ($boolCOn) {
               # code...
               $isAvi=true;
               for ($k=0; $k <sizeof($comp) ; $k++) { 
                 //  dd($comp[$k]->courceCode);
                    if ($comp[$i]->courceCode==$comp[$k]->courceCode && $comp[$k]->name!=$comp[$i]->name) {
                        dd($comp[$k]);
                        $tempMinor=$tempMinor."/".($comp[$k]->name);
                        $isAvi=false;
                    }
               }
               if ($isAvi) {
                   # code...
                   array_push($newcomp,$comp[$i]);
                  // array_push($newcomp,$comp[$i]);
               }else {
                $comp[$i]->name=($comp[$i]->name).$tempMinor;
                array_push($newcomp,$comp[$i]);
               }
           }

         //  dd($newcomp);
        }


            for ($j=1; $j <sizeof($comp) ; $j++) { 
                if ( $comp[$i]->courceCode==$comp[$j]->courceCode) {
                    $comp[$i]->name=($comp[$i]->name)."/".($comp[$j]->name);
                   unset($comp[$j]);
                   $comp = array_flip($comp);
                }
            }


       


        for ($i=0; $i <sizeof($elecGroup) ; $i++) { 
           
            for ($j=1; $j <sizeof($elecGroup) ; $j++) { 
               if ( $elecGroup[$i]->courceCode==$elecGroup[$j]->courceCode) {
                    $elecGroup[$i]->name=($elecGroup[$i]->name)."/".($elecGroup[$j]->name);
                    unset($elecGroup[$j]);
                }
            }
        }
       */




        $passCourceDetial=$users;
       return response()->json(['com'=>$newcomp,'ele'=>$elecGroup,'opo'=>$elecGroupOP],200);
    }

    public static function tempOfabcove($code){
         


        $users=DB::select("SELECT semcordinate.courceCode,semcordinate.type,semcordinate.buctNumber,semcordinate.crLimit ,course.title, course.gpaContribution ,course.credits,course.preVisit ,includesminor.mid,minor.name FROM semcordinate INNER JOIN course ON course.courceCode=semcordinate.courceCode LEFT JOIN includesminor ON course.courceCode=includesminor.courceCode LEFT JOIN minor ON includesminor.mid=minor.mid where semcordinate.sdid='$code';");
        info('This is some useful information.');
       
        $elec=[];
        $optio=[];
        $elecGroup=[];
        $elecGroupOP=[];
        $comp=[];
        foreach ($users as $key => $value) {
            if($value->type=='E'){
                array_push($elec,$value);
                
              }else if($value->type=='O'){
                array_push($optio,$value);
              }else{
                array_push($comp,$value);
              }
        }
        if (sizeof($elec)>0) {
            $tempArray=$elec[0];
            $ttAr=[];
            $te=[];



            foreach ($elec as $key => $value1) {
                # code...
               //dd($value1);
                $buckNo=$value1->buctNumber;
                $isAvaible = true;
                foreach ($te as $key => $vale) {
                    # code...
                    
                        //if (condition) {
                            # code...
                            if ($vale[0]->buctNumber==$buckNo) {
                                $isAvaible=false;
                                break;
                            }
                      //  }
                
                }
                if ($isAvaible) {
                    # code...
                    $temAr=[];
                    foreach ($elec as $key => $value2) {
                        if ($value2->buctNumber==$buckNo) {
                            # code...
                            array_push($temAr,$value2);
                        }
                    }
                    array_push($te,addCourceController::setMinorCorrectly($temAr));

                }
            }
           // dd('hello');
            $elecGroup=$te;


/*
            foreach ($elec as $key => $value) {
                if($tempArray->buctNumber==$value->buctNumber){
                    array_push($ttAr,$value);
                }else{
                    $tempArray=$value;
                    array_push($elecGroup,addCourceController::setMinorCorrectly($ttAr));
                    $ttAr=[];
                    array_push($ttAr,$value);
                }
            }
          // dd(addCourceController::setMinorCorrectly($ttAr));
         
            array_push($elecGroup,addCourceController::setMinorCorrectly($ttAr));
  */          
        }
        if (sizeof($optio)>0) {
            $tempArray1=$optio[0];
            $ttAr1=[];
            foreach ($optio as $key => $value) {
                if($tempArray1->buctNumber==$value->buctNumber){
                    array_push($ttAr1,$value);
                }else{
                    $tempArray1=$value;
                    array_push($elecGroupOP,addCourceController::setMinorCorrectly($ttAr1));
                    $ttAr1=[];
                    array_push($ttAr1,$value);
                }
            }
            array_push($elecGroupOP,addCourceController::setMinorCorrectly($ttAr1));
        }
       // \Debugbar::info($elecGroup);
       $newcomp=addCourceController::setMinorCorrectly($comp);
         /*
        for ($i=0; $i <sizeof($comp) ; $i++) { 
            $boolCOn=true;
            $tempMinor='';
          for ($j=0; $j <sizeof($newcomp) ; $j++) { 
             
               if ($newcomp[$j]->courseCode == $comp[$i]->courseCode) {
                   $boolCOn=false;
               }

           }*/
/*

           foreach ($newcomp as $key => $value) {
            if ($value->courceCode == $comp[$i]->courceCode) {
                $boolCOn=false;
            }
           }
           
           if ($boolCOn) {
               # code...
               $isAvi=true;
               for ($k=0; $k <sizeof($comp) ; $k++) { 
                 //  dd($comp[$k]->courceCode);
                    if ($comp[$i]->courceCode==$comp[$k]->courceCode && $comp[$k]->name!=$comp[$i]->name) {
                        dd($comp[$k]);
                        $tempMinor=$tempMinor."/".($comp[$k]->name);
                        $isAvi=false;
                    }
               }
               if ($isAvi) {
                   # code...
                   array_push($newcomp,$comp[$i]);
                  // array_push($newcomp,$comp[$i]);
               }else {
                $comp[$i]->name=($comp[$i]->name).$tempMinor;
                array_push($newcomp,$comp[$i]);
               }
           }

         //  dd($newcomp);
        }


            for ($j=1; $j <sizeof($comp) ; $j++) { 
                if ( $comp[$i]->courceCode==$comp[$j]->courceCode) {
                    $comp[$i]->name=($comp[$i]->name)."/".($comp[$j]->name);
                   unset($comp[$j]);
                   $comp = array_flip($comp);
                }
            }


       


        for ($i=0; $i <sizeof($elecGroup) ; $i++) { 
           
            for ($j=1; $j <sizeof($elecGroup) ; $j++) { 
               if ( $elecGroup[$i]->courceCode==$elecGroup[$j]->courceCode) {
                    $elecGroup[$i]->name=($elecGroup[$i]->name)."/".($elecGroup[$j]->name);
                    unset($elecGroup[$j]);
                }
            }
        }
       */




        $passCourceDetial=$users;
        $output=array(
            "com"=>$newcomp,
            "ele"=>$elecGroup,
            'opo'=>$elecGroupOP

        );

       return $output;
    }

    public static function updateCource(Request $re){
       // dd($re);
        /*
        $sem_detil = new sem_details;
        $sem_detil->sdid=1;
        $sem_detil->sem_number=1;
        $sem_detil->dep_code='CM';
        sem_detailController::update($sem_detil);


        $temp=new semCordinate;
        $temp->sdid=8;
        $temp->courceCode='IS4171';
        $temp->type=NULL;
        $temp->buctNumber=NULL;
        $temp->crLimit=NULL;
        semCordinateController::update($temp);

        $co = new course;
        $co->courceCode='CE1201';
        $co->title='Properties of Materials';
        $co->gpaContribution=1;
        $co->credits=2;
        $co->preVisit=NULL;
        $co->depCode='CE';

        courseController::update($co);

        $in = new includesminor;
        $in->mid =1;
        $in->courceCode="CO3251";

        $in1 = new includesminor;
        $in1->mid =1;
        $in1->courceCode="CO3251";

        includesminorController::update($in,$in1);


        $m = new minor;
        $m->mid=1;
        $m->name='Data management';
        $m->totalCredits=22;
        $m->details="THis is";
        $m->dep_code='CO';

        minorController::update($m);

        return response()->json($re->sem,200);

       
         courceData:{
                courceCode:'',
                title:'',
                Compulsory:1,
                credit:'',
                gpaContribution:1,
                preVisit:[],
                minors:[],
                sem:'',
                bucktNo:'',
                depCode:'',
                type:'',
            }
        */ 

        /*
        $co = new course;
        $co->courceCode='CE1201';
        $co->title='Properties of Materials';
        $co->gpaContribution=1;
        $co->credits=2;
        $co->preVisit=NULL;
        $co->depCode='CE';

        courseController::update($co);
         */
        $co = new course;
        $co->courceCode=$re->courceCode;
        $co->title=$re->title;
        $co->gpaContribution=$re->gpaContribution;
        $co->credits=$re->credit;
        $temp="";
        foreach ($re->preVisit as $key => $value) {
            $temp=$temp."/".$value;
        }
        if($temp==""){
            $co->preVisit=NULL;
        }else{
            $co->preVisit=$temp;
        }
        
        $co->depCode=$re->depCode;

        courseController::update($co);

    }

    public static function insertNewCourse(Request $re){
        /*
        courceData:{
                courceCode:'',
                title:'',
                Compulsory:1,
                credit:'',
                gpaContribution:1,
                preVisit:[],
                minors:[],
                sem:'',
                bucktNo:'',
                depCode:'',
                type:'',
            }
        */
//Add new Course to course table
      //  dd($re->courceCode);
        $co = new course;
        $co->courceCode=$re->courceCode;
        $co->title=$re->title;
        $co->gpaContribution=$re->gpaContribution;
        $co->credits=$re->credit;
        $temp="";
        foreach ($re->preVisit as $key => $value) {
            $temp=$temp."/".$value;
        }
        if($temp==""){
            $co->preVisit=NULL;
        }else{
            $co->preVisit=$temp;
        }
        
        $co->depCode=$re->depCode;
        courseController::insert($co);


       //add new semCoridates to semCordinate table 
       //Retreving relevent id for given dep and sem
    $sdid=sem_detailController::getSdid($re->sem,$re->depCode);
    $temp=new semCordinate;
    $temp->sdid=$sdid;
    $temp->courceCode=$re->courceCode;
    $temp->type=$re->type;
    $temp->buctNumber=$re->bucktNo;
    if ($re->crLimit!=null) {
        # code...
        semCordinateController::ChangeAllGivencrLimit($re->type,$sdid,$re->bucktNo,$re->crLimit);
    }
    $temp->crLimit=$re->crLimit;
    semCordinateController::insert($temp);

    foreach ($re->minors as $key => $value) {
       $mid= minorController::getSdid($value,$re->depCode);
       $in = new includesminor;
       $in->mid =$mid;
       $in->courceCode=$re->courceCode;
       includesminorController::insert($in);

    }

        

    }


    public static function deleteCourse(Request $re){

    $sdid=sem_detailController::getSdid($re->sem,$re->depCode);
    semCordinateController::delete($sdid,$re->courceCode);

    foreach ($re->minors as $key => $value) {
       $mid= minorController::getSdid($value,$re->depCode);
       includesminorController::delete($mid,$re->courceCode);

    }

    courseController::delete($re->courceCode);
    }


}
