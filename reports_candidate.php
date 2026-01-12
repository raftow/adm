<?php

$file_dir_name = dirname(__FILE__);

require_once("$file_dir_name/../config/global_config.php");

$datatable_on=1;
$limite = 0;
$genere_xls = 0;

$arr_sql_conds = array();
$arr_sql_conds[] = "me.active='Y'";
$objme = AfwSession::getUserConnected();
$myEmplId = $objme->getEmployeeId();

if(!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
if(!$lang) $lang = "ar";
// $out_scr .= Page::showPage("adm", "main-page", $lang);
$server_db_prefix = AfwSession::currentDBPrefix();

$application_plan_id = $_GET['application_plan_id'];
if(!$application_plan_id) $application_plan_id = 11;
$out_scr .= "<ul class=\"nav nav-tabs p-2\">
      <li class=\"nav-item\">
        <a class=\"nav-link\" style=\"border: none !important;\" href=\"/adm/index2.php?Main_Page=reports.php\">تقارير المتقدمين</a>
      </li>
      <li class=\"nav-item\">
        <a class=\"nav-link active\" style=\"border: none !important;\" href=\"/adm/index2.php?Main_Page=reports_candidate.php\">تقارير المرشحين</a>
      </li>
      <li class=\"nav-item\">
        <a class=\"nav-link\" style=\"border: none !important;\" href=\"/adm/index2.php?Main_Page=reports_applicant.php\">حالة التقديمات</a>
      </li>
    </ul>";

$out_scr .= "<div id='page-content-wrapper' class=\"container-fluid h-100\">";//<div id='page-content-wrapper' class='qsearch_page'>

// customer number increasing (cni)

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
               window.location.href = 'index2.php?Main_Page=reports_candidate.php&application_plan_id=' + application_plan_id;
            }
        });
    });
</script>";

$q = "select id,name_ar,name_en from " . $server_db_prefix . "adm.study_funding_status where active='Y'";
$funding_status_list = AfwDatabase::db_recup_rows($q);
$q2 = "select count(*) NB_CANDIDATE,sfs.name_ar,na.nominating_authority_name_ar from ".$server_db_prefix."adm.nominating_candidates nc inner join ".$server_db_prefix."adm.nomination_letter nl on nc.nomination_letter_id = nl.id
       inner join ".$server_db_prefix."adm.nominating_authority na on nl.nominating_authority_id = na.id 
       left outer join ".$server_db_prefix."adm.study_funding_status sfs on nc.study_funding_status_id = sfs.id
      where nl.application_plan_id = $application_plan_id group by sfs.name_ar,na.nominating_authority_name_ar";
$results = AfwDatabase::db_recup_rows($q2);

$columns = [];
$rows = [];

foreach ($results as $row) {
    $authority = $row['nominating_authority_name_ar'];
    $name = $row['name_ar'] ?? 'غير محدد';

    $columns[$name] = true;
    $rows[$authority][$name] = $row['NB_CANDIDATE'];
}

$out_scr .= '<div class="table-responsive p-2" style="margin-right:0;margin-left:auto;"><table border="1" cellpadding="5" class="table table-bordered table-striped" style="width:100%;margin:0;">';

// Header
$out_scr .= '<thead><tr><th style="text-align:center;">جهة الترشيح</th>';
foreach (array_keys($columns) as $col) {
    $out_scr .= "<th style='text-align:center;'>{$col}</th>";
}
//$out_scr .= '</tr>';
 $out_scr .= "<th style='text-align:center;'>المجموع</th></tr>";

// Body
$out_scr .= "</thead><tbody>";
$total_col = [];
foreach ($rows as $authority => $data) {
    $out_scr .= "<tr>";
    $out_scr .= "<td>{$authority}</td>";
    
    $total_row = 0;
    foreach (array_keys($columns) as $col) {
        $out_scr .= '<td>' . ($data[$col] ?? 0) . '</td>';
        $total_row += $data[$col];
        $total_col[$col] = ($total_col[$col] ?? 0) + ($data[$col] ?? 0);

    }
    $out_scr .= '<td>' . ($total_row) . '</td>';
    //$total_col[$col] += $data[$col];
    $out_scr .= "</tr>";
}
$out_scr .= "<tr><td>المجموع</td>";
//die(var_dump($total_col));
foreach (array_keys($columns) as $col) {
    $out_scr .= '<td>' . ($total_col[$col] ?? 0) . '</td>';
}
    $out_scr .= '<td>' . array_sum($total_col) . '</td>';

$out_scr .= "</tr>";
$out_scr .= '</tbody></table></div>';
$out_scr .="<br><br><br>";
if(true)
{
    
    //$out_scr .= AfwChartHelper::oniChartScript("Applicant", "cni", "line", -10, 0, 1, 'y', 'year', '');
    $out_scr .= "
    <script type=\"text/javascript\">
    $.ajax({
        url: \"/adm/api/getCandidateStats.php\",
        method: \"GET\",
        data:{method:10,application_plan_id:$application_plan_id},
        dataType: \"JSON\",
        success: function(data) {
            // Process the fetched data and create/update the chart
            $.each(data, function(index, datarow) {
                 createChart(datarow,index);
            })
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });

    
    function createChart(chartData,index) {
        const cv = document.getElementById('candidate'+index);
        const ctx = cv.getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie', // or 'line', 'pie', etc.
            data: {
                labels: chartData.labels,//{'':'غير محدد',1:'ذكور',2:'إناث'}, // Assuming your data has a 'labels' property
                datasets: [{
                    label: chartData.title,
                    data: chartData.values, 
                    backgroundColor: ['green', 'Blue','red'],//'rgba(67, 21, 205, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                // Chart options
                title: {
                    display: true,
                    text: chartData.title
                }
            }
        });
        //const canvas = document.getElementById('cni');
    
    
    }

    
    function createChartByPg(chartData,divId,chartType,Dataset) {
          const cv2 = document.getElementById(divId);
          //cv2.html('');
          const ctx = cv2.getContext('2d');
          const myChart = new Chart(ctx, {
              type: chartType, // or 'line', 'pie', etc.
              data: {
                  labels: chartData.labels,
                  datasets: [{
                      label: Dataset,
                      data: chartData.values, 
                      //backgroundColor: ['grey', 'Blue','red'],//'rgba(67, 21, 205, 0.2)',
                      //borderColor: 'rgba(75, 192, 192, 1)',
                      borderWidth: 1
                  }]
              },
              options: {
                  // Chart options
              }
            });
      }
  </script>";
}

if(true)
{
    /*$out_scr .= "<div class='row row-filter-request'><div class='qfilter col-sm-5 col-md-5 pb5'><div class='qfilter col-sm-10 col-md-10 pb10'><h1>احصائيات عدد المتقدمين حسب الجنس (r)</h1></div>";
    $out_scr .= "<div class='qfilter col-sm-5 col-md-5 pb5'><canvas id=\"cni\" style=\"width:100%;max-width:900px;margin:auto\"></canvas></div>";
    $out_scr .= "<div class='qfilter col-sm-5 col-md-5 pb5'><div class='qfilter col-sm-10 col-md-10 pb10'><h1> احصائيات عدد طلبات التقديم حسب البرنامج و الجنس</h1></div>";
    $out_scr .= "<canvas id=\"rni\" style=\"width:100%;max-width:900px;margin:auto\"></canvas></div></div></div>";

    $out_scr .= "<div class='qfilter col-sm-5 col-md-5 pb5'><div class='qfilter col-sm-10 col-md-10 pb10'><h1>احصائيات عدد المقبولين حسب البرنامج و الجنس</h1></div>";
    $out_scr .= "<canvas id=\"rni2\" style=\"width:100%;max-width:900px;margin:auto\"></canvas></div>";
    
    $out_scr .= "<div class='qfilter col-sm-5 col-md-5 pb5'><div class='qfilter col-sm-10 col-md-10 pb10'><h1>عدد المتقدمين حسب شهادة التخرج و الفترة الدراسية</h1></div>";
    $out_scr .= "<canvas id=\"rni3\" style=\"width:100%;max-width:900px;margin:auto\"></canvas></div>";
    
    $out_scr .= "<div class='qfilter col-sm-5 col-md-5 pb5'><div class='qfilter col-sm-10 col-md-10 pb10'><h1>توزيع مجموع عدد المتقدمين على أيام فترة التقديم</h1></div>";
    $out_scr .= "<canvas id=\"rni4\" style=\"width:100%;max-width:900px;margin:auto\"></canvas></div>";*/
    $out_scr .= "<div class=\"row h-50\" width=\"100%\">

        <!-- Area 1 -->
        <div class=\"col-6 text-white d-flex align-items-center justify-content-center\">
        
          <canvas id=\"candidate1\" style=\"width:100%;margin:auto\"></canvas>
        </div>

        <!-- Area 2 -->
        <div class=\"col-6 text-white d-flex align-items-center justify-content-center\">
          <canvas id=\"candidate2\" style=\"width:100%;margin:auto\"></canvas>
        </div>
      </div>
<br><br><br>
      <div class=\"row h-50\">

        <!-- Area 3 -->
        <div class=\"col-6  text-dark d-flex align-items-center justify-content-center\">
          <canvas id=\"candidate3\" style=\"width:100%;margin:auto\"></canvas>
        </div>

        <!-- Area 4 -->
        <div class=\"col-6 text-white d-flex align-items-center justify-content-center\">
          <canvas id=\"candidate4\" style=\"width:100%;margin:auto\"></canvas>
        </div>
      </div>";
    //$out_scr .= AfwChartHelper::oniChartScript("Application", "rni", "line", -10, 0, 1, 'y', 'year', '', ['min'=>50, 'max'=>150]);
}


$out_scr .= "</div>";
// Generations


// list($error, $info, $warn, $technical) = ApplicationPlanBranch::genereAllNames($lang="ar");
// AfwSession::pushPbmResult($lang, $error, $info, $warn, $technical, "home");
// list($error, $info, $warn, $technical) = AcademicProgramOffering::genereAllNames($lang="ar");
// AfwSession::pushPbmResult($lang, $error, $info, $warn, $technical, "home");
// list($error, $info, $warn, $technical) = ApplicationModelBranch::genereAllNames($lang="ar");
// AfwSession::pushPbmResult($lang, $error, $info, $warn, $technical, "home");

/*
if(!class_exists("AfwSession")) die("page-not-found");
$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../config/global_config.php");
// old include of afw.php
// require_once("$file_dir_name/../lib/afw/modes/afw_config.php");
// $datatable_on=1;
// $limite = 0;
// $genere_xls = 0;
// $arr_sql_conds = array();
// $arr_sql_conds[] = "me.active='Y'";
$objme = AfwSession::getUserConnected();
$myEmplObj = $objme->getEmployee();
$myEmplId = $myEmplObj->getId();

if(!$myEmplId) $out_scr .= "No employee attached to this account<br>";

$out_scr .= AfwShowHelper::showMinibox($myEmplObj);
global $MODE_SQL_PROCESS_LOURD;

$MODE_SQL_PROCESS_LOURD = true;

/*
$schoolList = SchoolEmployee::getSchoolList($myEmplId);    
$structure = [];
$structure['MINIBOX-TEMPLATE'] = "tpl/school_minibox_tpl.php";
$structure['MINIBOX-TEMPLATE-PHP'] = true;
$structure['MINIBOX-OBJECT-KEY'] = "schoolObj";

if(!count($schoolList)) $out_scr .= "No school attached to this employee<br>";


foreach($schoolList as $schoolObj)
{
  $out_scr .= AfwShowHelper::showMinibox($schoolObj, $structure);      
}
*/
                                   
?>