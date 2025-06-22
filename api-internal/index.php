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

$relative_path = "../";

$allowed_methods = [];
$allowed_methods["step_data"] = ["class"=>'ApplicationPlan',
                                 "method"=>'getStepData',
                                 "submit-method"=>'BOTH',
                                 "input"=>  [
                                                "plan_id"      => ['type'=>'INT', 'required'=>true], 
                                                "applicant_id" => ['type'=>'INT', 'required'=>true], 
                                                "step_num" => ['type'=>'INT', 'required'=>true], 
                                            ]
                                ];

$allowed_methods["current_step"] = ["class"=>'Application',
                                "method"=>'currentStepData',
                                "submit-method"=>'BOTH',
                                "input"=>  [
                                                "applicant_id" => ['type'=>'INT', 'required'=>true], 
                                                "plan_id"      => ['type'=>'INT', 'required'=>true], 
                                           ]
                               ];  
                               
                               
$allowed_methods["next_step"] = ["class"=>'Application',
                               "method"=>'nextApplicationStep',
                               "submit-method"=>'BOTH',
                               "input"=>  [
                                               "applicant_id" => ['type'=>'INT', 'required'=>true], 
                                               "plan_id"      => ['type'=>'INT', 'required'=>true], 
                                          ]
                              ];                                  


$allowed_methods["accept_offer"] = ["class"=>'Application',
                              "method"=>'acceptOffer',
                              "submit-method"=>'BOTH',
                              "input"=>  [
                                              "applicant_id" => ['type'=>'INT', 'required'=>true], 
                                              "plan_id"      => ['type'=>'INT', 'required'=>true], 
                                         ]
                             ];                                  

$allowed_methods["accept_offer_wp"] = ["class"=>'Application',
                             "method"=>'acceptOfferWithUpgradeRequest',
                             "submit-method"=>'BOTH',
                             "input"=>  [
                                             "applicant_id" => ['type'=>'INT', 'required'=>true], 
                                             "plan_id"      => ['type'=>'INT', 'required'=>true], 
                                        ]
                            ];                                  
$allowed_methods["reject_offer"] = ["class"=>'Application',
                             "method"=>'rejectOffer',
                             "submit-method"=>'BOTH',
                             "input"=>  [
                                             "applicant_id" => ['type'=>'INT', 'required'=>true], 
                                             "plan_id"      => ['type'=>'INT', 'required'=>true], 
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
        $submitMethod = $allowed_methods[$method]["submit-method"];
        if($submitMethod=="GET")
        {
            $submittedInputs = $_GET;
        }
        elseif($submitMethod=="POST")
        {
            $submittedInputs = $_POST;
        }
        else
        {
            $submittedInputs = $_REQUEST;
        }

        if(!$submittedInputs["lang"]) $submittedInputs["lang"] = "ar";
        foreach($allowed_methods[$method]["input"] as $attribute => $attributeRow)
        {
            if($attributeRow["required"] and (!$submittedInputs[$attribute]))
            {
                $data_for_json = ['status'=>'error', 'message'=>$attribute.' is required attribute]'];
                $error = true;
                break;
            } 
        }

        if(!$error)
        {
            list($status, $message, $dataApi) = $apiClass::$apiMethod($submittedInputs, $debugg);
            $data_for_json['status']=$status;
            $data_for_json["message"]=$message;
            $data_for_json["data"]=$dataApi;
            $data_for_json["debugg"]=$debugg;
            
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
    throw $e;
    $data_for_json['status']='error';
    $data_for_json['error'] = $e->getMessage();
    $data_for_json['trace'] = $e->getTraceAsString();
}

echo json_encode($data_for_json);


?>