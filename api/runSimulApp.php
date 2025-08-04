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
if(!$currmod) $currmod = 'adm';
$clwhere = trim($_GET['clwhere']);
if($clwhere) die("use of clwhere in autocomplete is removed");

$clp = trim($_GET['clp']);
$idp = trim($_GET['idp']);
$modp = trim($_GET['modp']);
$attp = trim($_GET['attp']);
$lang = trim($_GET['lang']);
if(!$lang) $lang = "ar";

$debugg = trim($_GET['debugg']);
try
{
    if($currmod) AfwAutoLoader::addMainModule($currmod);
    if($modp and ($modp != $currmod)) AfwAutoLoader::addModule($modp);

    $simulation_id = $_GET['simid'];

    $server_db_prefix = AfwSession::currentDBPrefix();
    if($simulation_id==2) die("This feature is only for simulation not for real application");
    $objSimulation = ApplicationSimulation::loadById($simulation_id);
    if(!$objSimulation->isRunning())
    {
      $objSimulation->runSimulation($lang);
      $a_json = ['status'=>'success'];
    }
    else
    {
      $a_json = ['status'=>'failed', 'message'=>'is already running'];
    }
    
    
}
catch(Exception $e)
{
    $a_json = ['status'=>'failed', 'message'=>$e->getMessage()."/".$e->getTraceAsString()];
}
$json = json_encode($a_json);
print $json;
?>