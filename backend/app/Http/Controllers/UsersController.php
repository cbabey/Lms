<?php

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class UsersController extends Controller 
{
    public function import() 
    {
        
        $array = Excel::toArray(new UsersImport, 'users.xlsx');
        echo $array;
        
      //  return redirect('/')->with('success', 'All good!');
    }
}