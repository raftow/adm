<?php
$direct_dir_name = $file_dir_name = dirname(__FILE__);
include("$file_dir_name/../adm_start.php");

$token  = $_REQUEST['token'];
$project_name   = 'external-adm-apis';
// to ignore time difference between servers until +-2 hours (as this API is server to server and time can differ some minutes or seconds)
$gmtime = gmdate('U');

$dynamic_token1 = md5($project_name.gmdate('Y-m-d H', $gmtime));
$dynamic_token2 = md5($project_name.gmdate('Y-m-d H', $gmtime+3600));
$dynamic_token3 = md5($project_name.gmdate('Y-m-d H', $gmtime-3600));
$dynamic_token4 = md5($project_name.gmdate('Y-m-d H', $gmtime+2*3600));
$dynamic_token5 = md5($project_name.gmdate('Y-m-d H', $gmtime-2*3600));

$debugg = $_REQUEST['debugg'];

// validate tokens
/*
if(($token != $dynamic_token1) && ($token != $dynamic_token2) && ($token != $dynamic_token3) && ($token != $dynamic_token4) && ($token != $dynamic_token5))
{
    $message = 'Wrong token.';
    if($debugg=="adm2025in") $message .= "SB0123$dynamic_token1"."3210BS";
    $data_for_json = ['status'=>'error', 'message'=>$message];
    header('Content-Type: application/json');
    echo json_encode($data_for_json);
    die;
}
*/
$method = $_REQUEST['method'];


$allowed_methods = [];
$allowed_methods["step_data"] = ["class"=>'ApplicationPlan',
                                 "method"=>'getStepData',
                                 "input"=>  [
                                                "plan_id"      => ['type'=>'INT', 'required'=>true], 
                                                "applicant_id" => ['type'=>'INT', 'required'=>true], 
                                                "step_num" => ['type'=>'INT', 'required'=>true], 
                                            ]
                                ];

try
{
    $error = false;
    $data_for_json = [];
    if($method && $allowed_methods[$method]) 
    {
        $apiClass = $allowed_methods[$method]["class"];
        $apiMethod = $allowed_methods[$method]["method"];
        $input_arr = [];
        foreach($allowed_methods[$method]["input"] as $attribute => $attributeRow)
        {
            $input_arr[$attribute] = $_REQUEST[$attribute];
            if($attributeRow["required"] and (!$input_arr[$attribute]))
            {
                $data_for_json = ['status'=>'error', 'message'=>$attribute.' is required attribute]'];
                $error = true;
                break;
            } 
        }

        if(!$error)
        {
            // die("_REQUEST=".var_export($_REQUEST,true));
            // die("input_arr=".var_export($input_arr,true));
            list($status, $message, $dataApi) = $apiClass::$apiMethod($input_arr, $debugg);
            $data_for_json['status']=$status;
            $data_for_json["message"]=$message;
            $data_for_json["data"]=$dataApi;
        }
        
        
    }
    else
    {
        $data_for_json['status']='error';
        $data_for_json["message"] = 'not allowed method : '.$method;
    }


    header('Content-Type: application/json');
}
catch(Exception $e)
{
    $data_for_json['status']='error';
    $data_for_json['error'] = $e->getMessage();
    $data_for_json['trace'] = $e->getTraceAsString();
}

echo json_encode($data_for_json);


?>