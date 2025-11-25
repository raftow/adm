<?php

$file_dir_name = dirname(__FILE__);
require_once("$file_dir_name/../../lib/afw/afw_autoloader.php");
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
$lang = "en";


        
AfwSession::startSession();

require_once("$file_dir_name/../../config/global_config.php");
// old include of afw.php
$only_members = true;
$debug_name = "autocomplete";
require("$file_dir_name/../lib/afw/afw_check_member.php");

if(!$objme) $objme = AfwSession::getUserConnected();
$lang = AfwSession::getSessionVar("lang");
if(!$lang) $lang = "ar";
 
// 

// prevent direct access
/*
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
  $user_error = 'Access denied - not an AJAX request...';
  trigger_error($user_error, E_USER_ERROR);
}*/
 
// get what user typed in autocomplete input
$cl = trim($_GET['cl']);
$currmod = trim($_GET['currmod']);
$clwhere = trim($_GET['clwhere']);
if($clwhere) die("use of clwhere in autocomplete is removed");

$clp = trim($_GET['clp']);
$idp = trim($_GET['idp']);
$modp = trim($_GET['modp']);
$attp = trim($_GET['attp']);
$debugg = trim($_GET['debugg']);

$method = trim($_GET['method']);
$gender = trim($_GET['gender']);
$program = trim($_GET['program']);


if($currmod) AfwAutoLoader::addMainModule($currmod);
if($modp and ($modp != $currmod)) AfwAutoLoader::addModule($modp);

$application_plan_id = $_GET['application_plan_id'];

$server_db_prefix = AfwSession::currentDBPrefix();

if($method==10)
{
  $q = "select nc.id candid_id,IF(na.nominating_authority_source_enum=1, 'داخلي', IF(na.nominating_authority_source_enum=2, 'خارجي', 'غير محدد')) source,
  ac.program_name_ar,na.nominating_authority_name_ar,sf.name_ar
  from ".$server_db_prefix."adm.application a 
  inner join ".$server_db_prefix."adm.applicant ap on a.applicant_id=ap.id 
  inner join ".$server_db_prefix."adm.nominating_candidates nc on ap.id=nc.applicant_id
  inner join ".$server_db_prefix."adm.nomination_letter nl on nc.nomination_letter_id = nl.id
  inner join ".$server_db_prefix."adm.nominating_authority na on nl.nominating_authority_id=na.id
  inner join ".$server_db_prefix."adm.study_funding_status sf on nc.study_funding_status_id = sf.id
  inner join ".$server_db_prefix."adm.academic_program ac on nc.academic_program_id = ac.id
  where a.application_plan_id = '".$application_plan_id."' ";


  $a_json = AfwDatabase::db_recup_rows($q);
  foreach($a_json as $row){
    $arr_source[$row["source"]] ++;
    $arr_auth[$row["nominating_authority_name_ar"]] ++;
    $arr_program[$row["program_name_ar"]] ++;
    $arr_study_status[$row["name_ar"]] ++;

  }
$res[1] = array("title"=>"عدد المرشحين حسب المصدر","labels" => array_keys($arr_source),"values" => array_values($arr_source));
$res[2] = array("title"=>"عدد المرشحين حسب الجهات","labels" => array_keys($arr_auth),"values" => array_values($arr_auth));
$res[3] = array("title"=>"عدد المرشحين حسب البرامج","labels" => array_keys($arr_program),"values" => array_values($arr_program));
$res[4] = array("title"=>"عدد المرشحين حسب حالة التمويل","labels" => array_keys($arr_study_status),"values" => array_values($arr_study_status));


$json = json_encode($res);
print $json;
}


?>