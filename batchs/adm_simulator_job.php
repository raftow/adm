#!/bin/bash
<?php
$project_code = "adm_simulator_job";
$project = "AUTO-SCHEDULED ADMISSION SIMULATOR JOB";

$date_time_run = $argv[1];

$batchs_dir_name = dirname(__FILE__); 

$lib_root_path = "$batchs_dir_name/../../lib";


require_once("$lib_root_path/afw/afw_autoloader.php");
AfwAutoLoader::addMainModule("adm");


// require_once("$lib_root_path/afw/common_date.php");
// include_once("$lib_root_path/afw/afw_shower.php");
// require_once("$lib_root_path/hzm/alert/hzm_alerts.php");
//require_once("$lib_root_path/hzm/api/hzm_api_consume.php");
// require_once("$lib_root_path/mail/hzm.mailer.php");
require_once("$lib_root_path/batch/batch_functions.php");

ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
$lang = "ar";

include("adm_config.php");
include("$lib_root_path/batch/batch_init.php");




$run_timestamp = date("Y-m-d H:i:s");  

$print_sql = true;
$print_info = true;
$print_debugg = true;
$print_warning = true;
$print_error = true;
$print_important = true;

// require_once("$lib_root_path/../atm/scjob.php");
// $jb = new Scjob();
// $jb->load(1);
// $log_file_name = "/var/www/log_batch/survey/nartaqi/survey_nartaqi_job_$date_time_run";
// $jb_run = $jb->newRun($log_file_name);

                              
$recap_data = array();

/*
$objSim = ApplicationSimulation::loadScheduled();

list($err, $inf, $war, $tech, $result_arr) = $objSim->runSimulation($lang);

$total = $result_arr["total"];
$success = $result_arr["success"];
$aboots = $result_arr["abootstrap"];
$dboots = $result_arr["dbootstrap"];
$errors = $result_arr["errors"];
$warnings = $result_arr["warnings"];


$row_0 = array('jobname'=>$project_code,
               'total'=>$total, 'success'=>$success, 
               'aboots'=>$aboots, 'dboots'=>$dboots, 
               'errors'=>$errors, 'warnings'=>$warnings, 
        
        );

$recap_data[] = $row_0;
*/

$objSS = SortingSession::loadScheduled();

list($err, $inf, $war, $tech, $result_arr) = $objSS->runTheSchedule($lang);

$total = $result_arr["total"];
$success = $result_arr["success"];
$aboots = "n/a";
$dboots = "n/a";
if($err) $errors = count(explode("<br>\n", $err)); else $errors = 0;
if($war) $warnings = count(explode("<br>\n", $war)); else $warnings = 0;


$row_1 = array('jobname'=>$project_code,
               'total'=>$total, 'success'=>$success, 
               'aboots'=>$aboots, 'dboots'=>$dboots, 
               'errors'=>$errors, 'warnings'=>$warnings, 
        
        );

$recap_data[] = $row_1;

// $jb_run->setNewItemValue($row_0["jobname"],"errors",$nb_errors);
// $jb_run->setNewItemValue($row_0["jobname"],"surveyed",$nb_surveyed);
// $jb_run->setNewItemValue($row_0["jobname"],"migrated",$nbrows_migrated);

/*
foreach($logs as $log)
{
       print_debugg($log);
}

foreach($errors as $err)
{
       print_error($err);
}
*/

$recap_header = array('jobname'=>40, 'total'=>10, 'success'=>10, 
               'aboots'=>10, 'dboots'=>10, 
               'errors'=>10, 'warnings'=>10, 
        
        );


/*
$recap_colors = array(
                rule1 => array(
                                 'code' => "min_val_of_col",
                                 col=>"migrated",
                                 colors=>array(1=>black),
                                 bg_colors=>array(1=>yellow)
                              ),
                              
                rule2 => array(
                                 'code' => "min_val_of_col",
                                 col=>"surveyed",
                                 colors=>array(1=>black),
                                 bg_colors=>array(1=>lightgreen)
                              ),               
                              
                rule3 => array(
                                 'code' => "min_val_of_col",
                                 col=>"errors",
                                 colors=>array(1=>white),
                                 bg_colors=>array(1=>red)
                              ),
                              
               );*/

AfwBatch::print_data($recap_header,$recap_data, $recap_colors);

if($err) AfwBatch::print_error($err);
if($war) AfwBatch::print_warning($war);
if($inf) AfwBatch::print_info($inf);
if($tech) AfwBatch::print_debugg($tech);
AfwBatch::print_the_log();
//die("nbrows_migrated = ".$nbrows_migrated);

// send mail to managers
if($email_simulation)
{
        $to_email_arr = array();
        $to_email_arr[] = $email_admin;
}
else
{
        $to_email_arr = $email_supervisors;
} 

$subject = $project;

$body = array();
$body[] = headerMail("ltr");
$body[] = "<h3>$subject</h3>";
$body[] = "Date of run : $forced_job_timestamp";
$body[] = AfwBatch::html_data($recap_header,$recap_data, $recap_colors);
$body[] = footerMail();

$res = hzmMail($project_code,"$project_code-php$run_timestamp-sys$date_time_run",$to_email_arr,$subject,$body, $send_from, $format="html", $language="ar");

/*
$jb_run->endOfRun(count($errors)+$nb_errors, 0, $nb_surveyed+$nbrows_migrated);

$jb_run_header = array(id=>10, run_date=>20, run_time=>20, errors_nb=>15, warning_nb=>15, notification_nb=>15);

$jb_run_data = array();
$jb_run_data[0] = array();
$jb_run_data[0]["id"] = $jb_run->getId();
$jb_run_data[0]["run_date"] = $jb_run->getVal("run_end_date");
$jb_run_data[0]["run_time"] = $jb_run->getVal("run_end_time");
$jb_run_data[0]["errors_nb"] = $jb_run->getVal("errors_nb");
$jb_run_data[0]["warning_nb"] = $jb_run->getVal("warning_nb");
$jb_run_data[0]["notification_nb"] = $jb_run->getVal("notification_nb");

print_data($jb_run_header,$jb_run_data, null);
*/


?>      