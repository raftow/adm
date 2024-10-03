<?php

$file_dir_name = dirname(__FILE__);
require_once("$file_dir_name/../../lib/afw/afw_autoloader.php");
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
$lang = "en";


        
AfwSession::startSession();

require_once("$file_dir_name/../../external/db.php");
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

if($currmod) AfwAutoLoader::addMainModule($currmod);
if($modp and ($modp != $currmod)) AfwAutoLoader::addModule($modp);

$qualification_id = $_GET['qualification_id'];

$a_json = AfwDatabase::db_recup_value("select gpa_from from c0adm.qualification where id = '".$qualification_id."'");

$json = json_encode($a_json);
print $json;
?>