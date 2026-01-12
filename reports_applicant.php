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
$application_model_id = $_GET['application_model_id'] ? $_GET['application_model_id'] : 14;
$server_db_prefix = AfwSession::currentDBPrefix();

$q0 = "select id,step_name_ar,step_name_en from ".$server_db_prefix."adm.application_step where  application_model_id='".$application_model_id."' and id in (45,46,49) order by step_num;";
$steps_list = AfwDatabase::db_recup_rows($q0);
$q = "select count(*) NB_APPLICANT, ac.program_name_ar category,ap.application_step_id stepid from ".$server_db_prefix."adm.applicant a 
        inner join ".$server_db_prefix."adm.application ap on a.id=ap.applicant_id 
        inner join ".$server_db_prefix."adm.application_desire ad on ad.application_plan_id=ap.application_plan_id 
        and ad.application_simulation_id=ap.application_simulation_id
        and ad.application_model_id=ap.application_model_id 
        and ad.applicant_id=ap.applicant_id
        inner join ".$server_db_prefix."adm.application_plan_branch ab on ad.application_plan_branch_id = ab.id
        inner join ".$server_db_prefix."adm.academic_program ac on ab.program_id = ac.id
        
        where   ap.application_plan_id='".$application_plan_id."' group by category,stepid; ";/*st.show_in_FrondEnd='Y'*/

//inner join ".$server_db_prefix."adm.application_step st  on ap.application_step_id=st.id 
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

$out_scr .= "<br><br><br><h2 class='m-2'>احصائية التقديم حسب البرامج والمراحل</h2><br>";

$out_scr .= "</div>";
// Generations

$q_plans = "select id, application_model_name_ar from " . $server_db_prefix . "adm.application_plan order by id desc";
$plans_list = AfwDatabase::db_recup_rows($q_plans);
//die(var_dump($plans_list));
$out_scr .= "<div class='container-fluid m-3'>
    <form method='post'>
        <div class='row'>
            <div class='col-md-6'>
                <label for='application_plan_id'>البرنامج</label>
                <select name='application_plan_id' id='application_plan_id' class='form-control'>
                    <option value='' disabled selected>اختر البرنامج</option>";
                     foreach ($plans_list as $plan) { 
                        if($plan['id'] == $application_plan_id) $out_scr .= "<option value='".$plan['id'] ."' selected>".$plan['application_model_name_ar'] ."</option>";
                        else $out_scr .= "<option value='".$plan['id'] ."'>".$plan['application_model_name_ar'] ."</option>";
                     } 
$out_scr .= "                </select>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#application_plan_id').change(function() {
            var application_plan_id = $(this).val();
            if(application_plan_id) {
               window.location.href = 'index2.php?Main_Page=reports_applicant.php&application_plan_id=' + application_plan_id;
            }
        });
    });
</script>
";


// pivot data: category rows x step_name_ar columns, values = NB_APPLICANT
 $steps = array();
 $categories = array();
 $matrix = array();
 foreach($a_json as $row){
     $step = $row['stepid'];
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
  $out_scr .= "<div class='table-responsive p-2' style='margin-right:0;margin-left:auto;'><table id='reportTable' class='table table-bordered table-striped' style='width:100%;margin:0;'>";
 // header
 $out_scr .= "<thead><tr ><th style='text-align:center;'>البرنامج</th>";
 foreach($steps_list as $step){
     $out_scr .= "<th style='text-align:center;'>".htmlspecialchars($step["step_name_ar"])."</th>";
 }
 $out_scr .= "<th style='text-align:center;'>المجموع</th></tr></thead><tbody>";

 // rows and totals
 $grandTotal = 0;
 //$stepTotals = array_fill(0, count($steps)-1, 0);
 $stepTotals  = array();
 foreach($categories as $cat){
     $out_scr .= "<tr><td>".htmlspecialchars($cat)."</td>";
     $rowTotal = 0;
     foreach($steps_list as $i => $step){
         $val = isset($matrix[$cat][$step["id"]]) ? $matrix[$cat][$step["id"]] : 0;
         $rowTotal += $val;
         if($stepTotals[$i]) $stepTotals[$i] += $val;
         else $stepTotals[$i] += $val;
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

 $out_scr .= "</tbody></table>";
 $out_scr .= '<button class="btn btn-primary" onclick="exportToPDF()">تصدير PDF</button>';
 $out_scr .= "</div>";

$out_scr .="<script>
        function exportToPDF() {
            // Get the table HTML
            var tableHTML = document.getElementById('reportTable').outerHTML;
            
            // Create a form and submit
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index2.php?Main_Page=report_pdf.php';
            
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'table_html';
            input.value = tableHTML;
            form.appendChild(input);
            
            var input2 = document.createElement('input');
            
            input2.type = 'hidden';
            input2.name = 'title';
            input2.value = 'احصائية التقديم حسب البرامج والمراحل';
            form.appendChild(input2);

            
            document.body.appendChild(form);
            form.submit();
        }
    </script>";

?>