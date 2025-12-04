<?php

$file_dir_name = dirname(__FILE__);
require_once("$file_dir_name/../lib/afw/afw_autoloader.php");
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
$lang = "en";

$datatable_on=1;
$limite = 0;
$genere_xls = 0;

        
AfwSession::startSession();

require_once("$file_dir_name/../config/global_config.php");
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
 



if($currmod) AfwAutoLoader::addMainModule($currmod);
if($modp and ($modp != $currmod)) AfwAutoLoader::addModule($modp);

$application_plan_id = $_GET['application_plan_id'] ? $_GET['application_plan_id'] : 11;

$server_db_prefix = AfwSession::currentDBPrefix();


$q = "select count(*) NB_APPLICANT, ac.program_name_ar category,st.step_name_ar from ".$server_db_prefix."adm.applicant a 
        inner join ".$server_db_prefix."adm.application ap on a.id=ap.applicant_id 
        inner join ".$server_db_prefix."adm.application_desire ad on ad.application_plan_id=ap.application_plan_id 
        and ad.application_simulation_id=ap.application_simulation_id
        and ad.application_model_id=ap.application_model_id 
        and ad.applicant_id=ap.applicant_id
        inner join ".$server_db_prefix."adm.application_plan_branch ab on ad.application_plan_branch_id = ab.id
        inner join ".$server_db_prefix."adm.academic_program ac on ab.program_id = ac.id
        inner join ".$server_db_prefix."adm.application_step st 
        on ap.application_step_id=st.id 
        where  /*st.show_in_FrondEnd='Y' and*/ ap.application_plan_id='".$application_plan_id."' group by category,st.step_name_ar; ";


  $a_json = AfwDatabase::db_recup_rows($q);
//die(var_dump($a_json));
if(!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
if(!$lang) $lang = "ar";
// $out_scr .= Page::showPage("adm", "main-page", $lang);

$application_plan_id = 11;

$out_scr .= "<ul class=\"nav nav-tabs p-2\">
      <li class=\"nav-item\">
        <a class=\"nav-link\" style=\"border: none !important;\" href=\"/adm/index2.php?Main_Page=reports.php\">تقارير المتقدمين</a>
      </li>
      <li class=\"nav-item\">
        <a class=\"nav-link \" style=\"border: none !important;\" href=\"/adm/index2.php?Main_Page=reports_candidate.php\">تقارير المرشحين</a>
      </li>
      <li class=\"nav-item\">
        <a class=\"nav-link active\" style=\"border: none !important;\" href=\"/adm/index2.php?Main_Page=reports_applicant.php\">حالة التقديمات</a>
      </li>
    </ul>";

$out_scr .= "<div id='page-content-wrapper' class=\"container-fluid h-100\">";//<div id='page-content-wrapper' class='qsearch_page'>

// customer number increasing (cni)

$out_scr .= "<br><br><br><h2 class='m-2'>حالة التقديمات حسب الخطوات والبرامج</h2><br>";

$out_scr .= "</div>";
// Generations


// pivot data: category rows x step_name_ar columns, values = NB_APPLICANT
 $steps = array();
 $categories = array();
 $matrix = array();
 foreach($a_json as $row){
     $step = $row['step_name_ar'];
     $cat  = $row['category'];
     $nb   = intval($row['NB_APPLICANT']);
     if(!in_array($step, $steps)) $steps[] = $step;
     if(!in_array($cat, $categories)) $categories[] = $cat;
     if(!isset($matrix[$cat])) $matrix[$cat] = array();
     $matrix[$cat][$step] = $nb;
 }
 sort($steps, SORT_STRING);
 sort($categories, SORT_STRING);
  
 
 
 // build bootstrap table (responsive)
 //$out_scr .= "<div class='table-responsive p-2'><table class='table table-bordered table-striped'>";
  $out_scr .= "<div class='table-responsive p-2' style='margin-right:0;margin-left:auto;'><table class='table table-bordered table-striped' style='width:100%;margin:0;'>";
 // header
 $out_scr .= "<thead><tr ><th style='text-align:center;'>الفئة</th>";
 foreach($steps as $step){
     $out_scr .= "<th style='text-align:center;'>".htmlspecialchars($step)."</th>";
 }
 $out_scr .= "<th style='text-align:center;'>المجموع</th></tr></thead><tbody>";

 // rows and totals
 $grandTotal = 0;
 $stepTotals = array_fill(0, count($steps), 0);
 foreach($categories as $cat){
     $out_scr .= "<tr><td>".htmlspecialchars($cat)."</td>";
     $rowTotal = 0;
     foreach($steps as $i => $step){
         $val = isset($matrix[$cat][$step]) ? $matrix[$cat][$step] : 0;
         $rowTotal += $val;
         $stepTotals[$i] += $val;
         $out_scr .= "<td>".$val."</td>";
     }
     $grandTotal += $rowTotal;
     $out_scr .= "<td><strong>".$rowTotal."</strong></td></tr>";
 }

 // footer totals per step + grand total
 $out_scr .= "<tr><td><strong>المجموع</strong></td>";
 foreach($stepTotals as $t){
     $out_scr .= "<td><strong>".$t."</strong></td>";
 }
 $out_scr .= "<td><strong>".$grandTotal."</strong></td></tr>";

 $out_scr .= "</tbody></table></div>";
                                   
?>