<?php
/**
 * @var string $modp
 */
$file_dir_name = dirname(__FILE__);
require_once("$file_dir_name/../lib/afw/core/afw_autoloader.php");
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);

$datatable_on=1;
$limite = 0;
$genere_xls = 0;

        
AfwSession::startSession();

require_once("$file_dir_name/../config/global_config.php");
// old include of afw.php
$only_members = true;
$debug_name = "autocomplete";
require("$file_dir_name/../lib/afw/includes/afw_check_member.php");

if(!isset($objme)) $objme = AfwSession::getUserConnected();
if(!isset($lang)) $lang = AfwLanguageHelper::getGlobalLanguage();
else AfwLanguageHelper::setGlobalLanguage($lang);
 
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
$q = "select count(*) NB_APPLICANT, ac.program_name_ar category, ap.application_step_id stepid, a.gender_enum from ".$server_db_prefix."adm.applicant a
        inner join ".$server_db_prefix."adm.application ap on a.id=ap.applicant_id
        inner join ".$server_db_prefix."adm.application_desire ad on ad.application_plan_id=ap.application_plan_id
        and ad.application_simulation_id=ap.application_simulation_id
        and ad.application_model_id=ap.application_model_id
        and ad.applicant_id=ap.applicant_id
        inner join ".$server_db_prefix."adm.application_plan_branch ab on ad.application_plan_branch_id = ab.id
        inner join ".$server_db_prefix."adm.academic_program ac on ab.program_id = ac.id

        where   ap.application_plan_id='".$application_plan_id."' group by category, stepid, a.gender_enum; ";/*st.show_in_FrondEnd='Y'*/

//inner join ".$server_db_prefix."adm.application_step st  on ap.application_step_id=st.id 
  $a_json = AfwDatabase::db_recup_rows($q);
//die(var_dump($a_json));

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
                <select name='application_plan_id' id='application_plan_id' class='form-control'>";
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


$q_total = "select count(distinct a.id) as TOTAL from ".$server_db_prefix."adm.applicant a
        inner join ".$server_db_prefix."adm.application ap on a.id=ap.applicant_id
        where ap.application_plan_id='".$application_plan_id."'";
$total_result = AfwDatabase::db_recup_rows($q_total);
$total_applicants = intval($total_result[0]['TOTAL']);

$q_apps = "select count(*) as TOTAL from ".$server_db_prefix."adm.application ap
        where ap.application_plan_id='".$application_plan_id."'";
$apps_result = AfwDatabase::db_recup_rows($q_apps);
$total_applications = intval($apps_result[0]['TOTAL']);

$q_complete = "select count(*) as TOTAL from ".$server_db_prefix."adm.application ap
        where ap.application_plan_id='".$application_plan_id."' and ap.application_status_enum=2";
$complete_result = AfwDatabase::db_recup_rows($q_complete);
$total_complete = intval($complete_result[0]['TOTAL']);

$pdf_stats_html = '<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:18px;"><tr>
    <td style="background:#007bff;color:#fff;border-radius:8px;padding:14px 20px;text-align:center;">
        <div style="font-size:26px;font-weight:bold;line-height:1.1;">'.$total_applicants.'</div>
        <div style="font-size:12px;margin-top:5px;">إجمالي المتقدمين</div>
    </td>
    <td width="12"></td>
    <td style="background:#6c757d;color:#fff;border-radius:8px;padding:14px 20px;text-align:center;">
        <div style="font-size:26px;font-weight:bold;line-height:1.1;">'.$total_applications.'</div>
        <div style="font-size:12px;margin-top:5px;">إجمالي التقديمات</div>
    </td>
    <td width="12"></td>
    <td style="background:#28a745;color:#fff;border-radius:8px;padding:14px 20px;text-align:center;">
        <div style="font-size:26px;font-weight:bold;line-height:1.1;">'.$total_complete.'</div>
        <div style="font-size:12px;margin-top:5px;">التقديمات المكتملة</div>
    </td>
</tr></table>';

$out_scr .= "<div class='container-fluid mb-3' style='display:flex;gap:16px;flex-wrap:wrap;'>
    <div style='background:#007bff;color:#fff;border-radius:10px;padding:14px 24px;min-width:160px;text-align:center;'>
        <div style='font-size:2rem;font-weight:700;line-height:1.1;'>".$total_applicants."</div>
        <div style='font-size:0.9rem;margin-top:4px;'>إجمالي المتقدمين</div>
    </div>
    <div style='background:#6c757d;color:#fff;border-radius:10px;padding:14px 24px;min-width:160px;text-align:center;'>
        <div style='font-size:2rem;font-weight:700;line-height:1.1;'>".$total_applications."</div>
        <div style='font-size:0.9rem;margin-top:4px;'>إجمالي التقديمات</div>
    </div>
    <div style='background:#28a745;color:#fff;border-radius:10px;padding:14px 24px;min-width:160px;text-align:center;'>
        <div style='font-size:2rem;font-weight:700;line-height:1.1;'>".$total_complete."</div>
        <div style='font-size:0.9rem;margin-top:4px;'>التقديمات المكتملة</div>
    </div>
</div>";

// pivot data: category rows x step columns, values broken down by gender
 $steps = array();
 $categories = array();
 $matrix = array();
 foreach($a_json as $row){
     $step   = $row['stepid'];
     $cat    = $row['category'];
     $nb     = intval($row['NB_APPLICANT']);
     $gender = intval($row['gender_enum']); // 1=boys, 2=girls
     if(!in_array($step, $steps)) $steps[] = $step;
     if(!in_array($cat, $categories)) $categories[] = $cat;
     if(!isset($matrix[$cat][$step])) $matrix[$cat][$step] = ['total'=>0, 1=>0, 2=>0];
     $matrix[$cat][$step]['total'] += $nb;
     $matrix[$cat][$step][$gender]  += $nb;
 }
 sort($steps, SORT_STRING);
 sort($categories, SORT_STRING);

 // build bootstrap table (responsive)
 $out_scr .= "<div class='table-responsive p-2' style='margin-right:0;margin-left:auto;'><table id='reportTable' class='table table-bordered table-striped' style='width:100%;margin:0;'>";

 $step_name_override = ['مرحلة إجراءات القبول' => 'الطلبات المكتملة'];

 // header row 1: البرنامج + step names (colspan=2 each) + المجموع (single, rowspan=2)
 $out_scr .= "<thead><tr><th rowspan='2' style='text-align:center;vertical-align:middle;'>البرنامج</th>";
 foreach($steps_list as $step){
     $label = isset($step_name_override[$step["step_name_ar"]]) ? $step_name_override[$step["step_name_ar"]] : $step["step_name_ar"];
     $out_scr .= "<th colspan='2' style='text-align:center;'>".htmlspecialchars($label)."</th>";
 }
 $out_scr .= "<th rowspan='2' style='text-align:center;vertical-align:middle;'>المجموع</th></tr>";

 // header row 2: طلاب / طالبات only under each step (not under المجموع)
 $out_scr .= "<tr>";
 foreach($steps_list as $step){
     $out_scr .= "<th style='text-align:center;'>طلاب</th><th style='text-align:center;'>طالبات</th>";
 }
 $out_scr .= "</tr></thead><tbody>";

 // rows
 $grandTotal = 0;
 $stepTotals = array();
 foreach($categories as $cat){
     $out_scr .= "<tr><td>".htmlspecialchars($cat)."</td>";
     $rowTotal = 0;
     foreach($steps_list as $i => $step){
         $cell = isset($matrix[$cat][$step["id"]]) ? $matrix[$cat][$step["id"]] : [1=>0, 2=>0];
         $rowTotal += $cell[1] + $cell[2];
         if(!isset($stepTotals[$i])) $stepTotals[$i] = [1=>0, 2=>0];
         $stepTotals[$i][1] += $cell[1];
         $stepTotals[$i][2] += $cell[2];
         $out_scr .= "<td style='text-align:center;'>".$cell[1]."</td><td style='text-align:center;'>".$cell[2]."</td>";
     }
     $grandTotal += $rowTotal;
     $out_scr .= "<td style='text-align:center;'><strong>".$rowTotal."</strong></td></tr>";
 }

 // footer totals: each step merged (colspan=2), grand total single cell
 $out_scr .= "<tr><td><strong>المجموع</strong></td>";
 foreach($stepTotals as $t){
     $stepSum = $t[1] + $t[2];
     $out_scr .= "<td colspan='2' style='text-align:center;'><strong>".$stepSum."</strong></td>";
 }
 $out_scr .= "<td style='text-align:center;'><strong>".$grandTotal."</strong></td></tr>";

 $out_scr .= "</tbody></table>";
 $out_scr .= "<p style='font-size:0.85rem;color:#666;margin-top:8px;'>* الأعمدة تمثل المرحلة التي وقف عنها المتقدم</p>";
 $out_scr .= '<br><br><button class="btn btn-primary" onclick="exportToPDF()">تصدير PDF</button>';
 $out_scr .= "</div>";

$out_scr .="<script>
        function exportToPDF() {
            var tableHTML = document.getElementById('reportTable').outerHTML;
            var statsHTML = ".json_encode($pdf_stats_html).";

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

            var input3 = document.createElement('input');
            input3.type = 'hidden';
            input3.name = 'stats_html';
            input3.value = statsHTML;
            form.appendChild(input3);

            document.body.appendChild(form);
            form.submit();
        }
    </script>";

?>