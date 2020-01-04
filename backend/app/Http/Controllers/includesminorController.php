<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\includesminor;

class includesminorController extends Controller
{
    //
    public static function update(includesminor $in,includesminor $in1){
        DB::table('includesminor')
        ->where('mid',$in->mid) ->where('courceCode',$in->courceCode)
        ->update(['mid'=>$in1->mid ,'courceCode'=>$in1->courceCode]);
    }
    
     public static function insert(includesminor $in1){

        DB::table('includesminor')->insert(
            ['mid'=>$in1->mid ,'courceCode'=>$in1->courceCode]
        );
    }

    public static function delete($mid,$courseCode){

        DB::table('includesminor')->where('mid',$mid)->where('courceCode',$courseCode)->delete();
    }
}
//SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails (`slpengdb`.`includesminor`, CONSTRAINT `includesminor_ibfk_2` FOREIGN KEY (`courceCode`) REFERENCES `course` (`courceCode`)) (SQL: delete from `course` where `courceCode` = CO6767)"