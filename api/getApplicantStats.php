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

if($method==1)//عدد المتقدمين حسب الجنس 
{
  $q = "select count(*) NB_APPLICANT,IF(gender_enum=1, 'طلاب', IF(gender_enum=2, 'طالبات', 'غير محدد')) category from ".$server_db_prefix."adm.application a inner join ".$server_db_prefix."adm.applicant ap on a.applicant_id=ap.id where a.application_plan_id = '".$application_plan_id."' group by category order by gender_enum";
}elseif($method==2){ // عدد المتقدمين حسب البرنامج و الجنس
  $q = "select count(*) NB_APPLICANT, ac.program_name_ar category from ".$server_db_prefix."adm.applicant a 
        inner join ".$server_db_prefix."adm.application ap on a.id=ap.applicant_id 
        inner join ".$server_db_prefix."adm.application_desire ad on ad.application_plan_id=ap.application_plan_id 
        and ad.application_simulation_id=ap.application_simulation_id
        and ad.application_model_id=ap.application_model_id 
        and ad.applicant_id=ap.applicant_id
        inner join ".$server_db_prefix."adm.application_plan_branch ab on ad.application_plan_branch_id = ab.id
        inner join ".$server_db_prefix."adm.academic_program ac on ab.program_id = ac.id
        where  a.gender_enum=$gender and ap.application_plan_id='".$application_plan_id."' group by category;";

}elseif($method==3){ // عدد المقبولين حسب البرنامج و الجنس
  $q = "select count(*) NB_APPLICANT, ac.program_name_ar category from ".$server_db_prefix."adm.applicant a 
        inner join ".$server_db_prefix."adm.application ap on a.id=ap.applicant_id 
        inner join ".$server_db_prefix."adm.application_desire ad on ad.application_plan_id=ap.application_plan_id 
        and ad.application_simulation_id=ap.application_simulation_id
        and ad.application_model_id=ap.application_model_id 
        and ad.applicant_id=ap.applicant_id
        inner join ".$server_db_prefix."adm.application_plan_branch ab on ad.application_plan_branch_id = ab.id
        inner join ".$server_db_prefix."adm.academic_program ac on ab.program_id = ac.id
        where ad.desire_status_enum=2 and a.gender_enum=$gender and ap.application_plan_id='".$application_plan_id."' group by category;";

}elseif($method==4){ // عدد المتقدمين حسب شهادة التخرج و الفترة الدراسية
  $q = "select count(*) NB_APPLICANT, ac.program_name_ar category from ".$server_db_prefix."adm.applicant a 
        inner join ".$server_db_prefix."adm.application ap on a.id=ap.applicant_id 
        inner join ".$server_db_prefix."adm.application_desire ad on ad.application_plan_id=ap.application_plan_id 
        and ad.application_simulation_id=ap.application_simulation_id
        and ad.application_model_id=ap.application_model_id 
        and ad.applicant_id=ap.applicant_id
        inner join ".$server_db_prefix."adm.application_plan_branch ab on ad.application_plan_branch_id = ab.id
        inner join ".$server_db_prefix."adm.academic_program ac on ab.program_id = ac.id
        where ad.desire_status_enum=2 and  ap.application_plan_id='".$application_plan_id."' group by category;";

}elseif($method==5){ // توزيع محموع عدد المتقدمين على أيام فترة التقديم
  $q = "select count(*) NB_APPLICANT, substring(ap.created_at,1,10) category from ".$server_db_prefix."adm.applicant a 
        inner join ".$server_db_prefix."adm.application ap on a.id=ap.applicant_id 
        
        where ap.application_plan_id='".$application_plan_id."' group by category;";

}

$a_json = AfwDatabase::db_recup_rows($q);

$res["labels"] = array_column($a_json, 'category');
$res["values"] = array_column($a_json, 'NB_APPLICANT');

$json = json_encode($res);
print $json;

?>