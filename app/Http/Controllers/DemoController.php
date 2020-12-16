<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DemoController extends Controller{
    
    public function demo_crud(Request $req){
    	extract($_REQUEST);
    	$insert_array=array(
    		'name'=> $user_name,
    		'email' => $user_email,
    		'description' => $user_message,
    		'created_at' => date('Y-m-d H:i:s')
    	);

    	if(DB::table('demo')->insert($insert_array)){
    		$result=array('success_status'=>'Data insert successfully');
    	} else{
    		$result=array('error_status'=>'Failed to insert data into server');
    	}

    	echo json_encode($result);
    	die();
    }
}
