<?php

$file_dir_name = dirname(__FILE__);

require_once ("$file_dir_name/../config/global_config.php");

$datatable_on = 1;
$limite = 0;
$genere_xls = 0;

$arr_sql_conds = array();
$arr_sql_conds[] = "me.active='Y'";
$objme = AfwSession::getUserConnected();
$myEmplId = $objme->getEmployeeId();

/*
 * $crm_active_period = AfwSession::config("crm_active_period", 365);
 * $oldest_date = AfwDateHelper::shiftGregDate("", -$crm_active_period);
 * $newest_date = AfwDateHelper::shiftGregDate("", -2);
 *
 * $supList = CrmEmployee::getSupervisorList();
 *
 *
 * $where_old_still_not_assigned="active='Y' and status_id < 5 and (orgunit_id=0 or employee_id=0) and created_at between '$oldest_date' and '$newest_date'";
 *
 * $stats_arr = Request::aggreg($function="count(*)",
 *                 $where = $where_old_still_not_assigned,
 *                 $group_by = "supervisor_id",
 *                 $throw_error=true,
 *                 $throw_analysis_crash=true);
 *
 * if(!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
 *
 * $statsMatrix = array();
 * foreach($supList as $supItem)
 * {
 *         $supObj = $supItem["obj"];
 *         $sup_employee_id = $supObj->getVal("employee_id");
 *         if($stats_arr[$sup_employee_id]>0)
 *         {
 *             $statsMatrix[$sup_employee_id] = array('name'=>$supObj->getDisplay($lang), 'missed'=>$stats_arr[$sup_employee_id]);
 *         }
 * }
 *
 *
 * $reqList = Request::loadRecords($where_old_still_not_assigned, $limit="5", $order_by="id asc");
 *
 * $header_trad = array("missed"=>"عدد الطلبات", "name" => 'الادارة - المشرف');
 */
if (!$lang)
    $lang = AfwLanguageHelper::getGlobalLanguage();
if (!$lang)
    $lang = 'ar';
// $out_scr .= Page::showPage("adm", "main-page", $lang);

$application_plan_id = 11;
$out_scr .= '<ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" style="border: none !important;" href="/adm/index2.php?Main_Page=reports.php">تقارير المتقدمين</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="border: none !important;" href="/adm/index2.php?Main_Page=reports_candidate.php">تقارير المرشحين</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="border: none !important;" href="/adm/index2.php?Main_Page=reports_applicant.php">حالة التقديمات</a>
      </li>
    </ul>';
$out_scr .= "<div id='page-content-wrapper' class='qsearch_page'><div class='row row-filter-request'>";

// customer number increasing (cni)

if (true) {
    $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1>احصائيات عدد المتقدمين حسب الجنس (r)</h1></div>";
    $out_scr .= '<canvas id="cni" style="width:100%;max-width:900px;margin:auto"></canvas>';
    // $out_scr .= AfwChartHelper::oniChartScript("Applicant", "cni", "line", -10, 0, 1, 'y', 'year', '');
    $out_scr .= "
    <script type=\"text/javascript\">
    \$.ajax({
        url: \"/adm/api/getApplicantStats.php\",
        method: \"GET\",
        data:{method:1,application_plan_id:$application_plan_id},
        dataType: \"JSON\",
        success: function(data) {
            // Process the fetched data and create/update the chart
            createChart(data);
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });

    // عدد المتقدمين حسب شهادة التخرج و الفترة الدراسية\t
    \$.ajax({
      url: \"/adm/api/getApplicantStats.php\",
      method: \"GET\",
      data:{method:4,application_plan_id:$application_plan_id},
      dataType: \"JSON\",
      success: function(data) {
          createChartByPg(data,'rni3','bar','عدد المتقدمين');
      },
      error: function(error) {
          console.error('Error fetching data:', error);
      }
    });
    // توزيع محموع عدد المتقدمين على أيام فترة التقديم
    \$.ajax({
      url: \"/adm/api/getApplicantStats.php\",
      method: \"GET\",
      data:{method:5,application_plan_id:$application_plan_id},
      dataType: \"JSON\",
      success: function(data) {
          createChartByPg(data,'rni4','bar','عدد المتقدمين على أيام فترة التقديم');
      },
      error: function(error) {
          console.error('Error fetching data:', error);
      }
    });
    function createChart(chartData) {
        const cv = document.getElementById('cni');
        const ctx = cv.getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie', // or 'line', 'pie', etc.
            data: {
                labels: chartData.labels,//{'':'غير محدد',1:'ذكور',2:'إناث'}, // Assuming your data has a 'labels' property
                datasets: [{
                    label: 'My Dataset',
                    data: chartData.values, 
                    backgroundColor: ['rgba(212, 62, 205, 1)', 'rgba(37, 91, 209, 1)','red'],//'rgba(67, 21, 205, 0.2)',
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                // Chart options
            }
        });
        //const canvas = document.getElementById('cni');
    
    cv.onclick = (event) => {
        const activeElements = myChart.getElementsAtEventForMode(
            event,
            'nearest', // Mode to use for finding elements (e.g., 'nearest', 'index')
            { intersect: true }, // Options for the mode
            true // Use native events
        );

        if (activeElements.length > 0) {
            const clickedElement = activeElements[0];
            //console.log(clickedElement._datasetIndex);
            const datasetIndex = clickedElement._datasetIndex;
            const index = clickedElement._index;
            
            /*console.log(myChart.data.datasets[datasetIndex].data);
            console.log(index);*/
            
            //const label = myChart.data.labels[index];
            //const value = myChart.data.datasets[datasetIndex].data[index];
            
            
            //console.log(`Clicked on: \${label}, Value: \${value} `);
            //عدد المتقدمين حسب البرنامج و الجنس\tقائمة المتقدمين

            \$.ajax({
              url: \"/adm/api/getApplicantStats.php\",
              method: \"GET\",
              data:{method:2,application_plan_id:$application_plan_id,gender:index},
              dataType: \"JSON\",
              success: function(data) {
                  createChartByPg(data,'rni','bar','عدد المتقدمين حسب البرنامج');
              },
              error: function(error) {
                  console.error('Error fetching data:', error);
              }
            });
            //عدد المقبولين حسب البرنامج و الجنس\tقائمة المقبولين
            \$.ajax({
              url: \"/adm/api/getApplicantStats.php\",
              method: \"GET\",
              data:{method:3,application_plan_id:$application_plan_id,gender:index},
              dataType: \"JSON\",
              success: function(data) {
                  createChartByPg(data,'rni2','bar','عدد المقبولين حسب البرنامج');
              },
              error: function(error) {
                  console.error('Error fetching data:', error);
              }
            });

        }
    };
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

if (true) {
    $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1> احصائيات عدد طلبات التقديم حسب البرنامج و الجنس</h1></div>";
    $out_scr .= '<canvas id="rni" style="width:100%;max-width:900px;margin:auto"></canvas>';

    $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1>احصائيات عدد المقبولين حسب البرنامج و الجنس</h1></div>";
    $out_scr .= '<canvas id="rni2" style="width:100%;max-width:900px;margin:auto"></canvas>';

    $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1>عدد المتقدمين حسب شهادة التخرج و الفترة الدراسية</h1></div>";
    $out_scr .= '<canvas id="rni3" style="width:100%;max-width:900px;margin:auto"></canvas>';

    $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1>توزيع مجموع عدد المتقدمين على أيام فترة التقديم</h1></div>";
    $out_scr .= '<canvas id="rni4" style="width:100%;max-width:900px;margin:auto"></canvas>';

    // $out_scr .= AfwChartHelper::oniChartScript("Application", "rni", "line", -10, 0, 1, 'y', 'year', '', ['min'=>50, 'max'=>150]);
}

$out_scr .= '</div>';
// Generations

// list($error, $info, $warn, $technical) = ApplicationPlanBranch::genereAllNames($lang="ar");
// AfwSession::pushPbmResult($lang, $error, $info, $warn, $technical, "home");
// list($error, $info, $warn, $technical) = AcademicProgramOffering::genereAllNames($lang="ar");
// AfwSession::pushPbmResult($lang, $error, $info, $warn, $technical, "home");
// list($error, $info, $warn, $technical) = ApplicationModelBranch::genereAllNames($lang="ar");
// AfwSession::pushPbmResult($lang, $error, $info, $warn, $technical, "home");

/*
 * if(!class_exists("AfwSession")) die("page-not-found");
 * $file_dir_name = dirname(__FILE__);
 *
 * // require_once("$file_dir_name/../config/global_config.php");
 * // old include of afw.php
 * // require_once("$file_dir_name/../lib/afw/modes/afw_config.php");
 * // $datatable_on=1;
 * // $limite = 0;
 * // $genere_xls = 0;
 * // $arr_sql_conds = array();
 * // $arr_sql_conds[] = "me.active='Y'";
 * $objme = AfwSession::getUserConnected();
 * $myEmplObj = $objme->getEmployee();
 * $myEmplId = $myEmplObj->getId();
 *
 * if(!$myEmplId) $out_scr .= "No employee attached to this account<br>";
 *
 * $out_scr .= AfwShowHelper::showMinibox($myEmplObj);
 * global $MODE_SQL_PROCESS_LOURD;
 *
 * $MODE_SQL_PROCESS_LOURD = true;
 *
 * /*
 * $schoolList = SchoolEmployee::getSchoolList($myEmplId);
 * $structure = [];
 * $structure['MINIBOX-TEMPLATE'] = "tpl/school_minibox_tpl.php";
 * $structure['MINIBOX-TEMPLATE-PHP'] = true;
 * $structure['MINIBOX-OBJECT-KEY'] = "schoolObj";
 *
 * if(!count($schoolList)) $out_scr .= "No school attached to this employee<br>";
 *
 *
 * foreach($schoolList as $schoolObj)
 * {
 *   $out_scr .= AfwShowHelper::showMinibox($schoolObj, $structure);
 * }
 */

?>