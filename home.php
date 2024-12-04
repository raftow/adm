<?php

$file_dir_name = dirname(__FILE__);

require_once("$file_dir_name/../external/db.php");

$datatable_on=1;
$limite = 0;
$genere_xls = 0;

$arr_sql_conds = array();
$arr_sql_conds[] = "me.active='Y'";
$objme = AfwSession::getUserConnected();
$myEmplId = $objme->getEmployeeId();

/*
$crm_active_period = AfwSession::config("crm_active_period", 365);
$oldest_date = AfwDateHelper::shiftGregDate("", -$crm_active_period);
$newest_date = AfwDateHelper::shiftGregDate("", -2);

$supList = CrmEmployee::getSupervisorList();


$where_old_still_not_assigned="active='Y' and status_id < 5 and (orgunit_id=0 or employee_id=0) and created_at between '$oldest_date' and '$newest_date'";

$stats_arr = Request::aggreg($function="count(*)", 
                $where = $where_old_still_not_assigned, 
                $group_by = "supervisor_id",
                $throw_error=true, 
                $throw_analysis_crash=true);

if(!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();

$statsMatrix = array();
foreach($supList as $supItem)                
{
        $supObj = $supItem["obj"];
        $sup_employee_id = $supObj->getVal("employee_id");
        if($stats_arr[$sup_employee_id]>0)
        {
            $statsMatrix[$sup_employee_id] = array('name'=>$supObj->getDisplay($lang), 'missed'=>$stats_arr[$sup_employee_id]);
        }        
}
                          

$reqList = Request::loadRecords($where_old_still_not_assigned, $limit="5", $order_by="id asc");

$header_trad = array("missed"=>"عدد الطلبات", "name" => 'الادارة - المشرف');
*/

$out_scr .= '<div class="row justify-content-center">    
<div class="col-lg-12">
                    <div class="single_element">
                        <div class="quick_activity">
                            <div class="row">
                                <div class="col-12">
                                    <div class="quick_activity_wrap">
                                        <div class="single_quick_activity d-flex">
                                            <div class="icon">
                                                <img src="pic/man.svg" alt="">
                                            </div>
                                            <div class="count_content">
                                                <h3><span class="counter">520</span> </h3>
                                                <p>المتقدمين</p>
                                            </div>
                                        </div>
                                        <div class="single_quick_activity d-flex">
                                            <div class="icon">
                                                <img src="pic/request.svg" alt="">
                                            </div>
                                            <div class="count_content">
                                                <h3><span class="counter">6969</span> </h3>
                                                <p>طلبات التقديم</p>
                                            </div>
                                        </div>
                                        <div class="single_quick_activity d-flex">
                                            <div class="icon">
                                                <img src="pic/university.svg" alt="">
                                            </div>
                                            <div class="count_content">
                                                <h3><span class="counter">7509</span> </h3>
                                                <p>الوحدات المفتوحة</p>
                                            </div>
                                        </div>
                                        <div class="single_quick_activity d-flex">
                                            <div class="icon">
                                                <img src="pic/branch.svg" alt="">
                                            </div>
                                            <div class="count_content">
                                                <h3><span class="counter">2110</span> </h3>
                                                <p>التخصصات</p>
                                            </div>
                                        </div>
                                        <div class="single_quick_activity d-flex">
                                            <div class="icon">
                                                <img src="pic/feedback.svg" alt="">
                                            </div>
                                            <div class="count_content">
                                                <h3><span class="counter">2110</span> </h3>
                                                <p>نسبة رضا العملاء</p>
                                            </div>
                                        </div>
                                        <div class="single_quick_activity d-flex">
                                            <div class="icon">
                                                <img src="pic/tasks.svg" alt="">
                                            </div>
                                            <div class="count_content">
                                                <h3><span class="counter">10</span> </h3>
                                                <p>مهامي</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>';

$out_scr .= "<div id='page-content-wrapper' class='qsearch_page'><div class='row row-filter-request'>";

// customer number increasing (cni)

if(true)
{
    $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1>احصائيات نمو عدد المتقدمين</h1></div>";
    $out_scr .= "<canvas id=\"cni\" style=\"width:100%;max-width:900px;margin:auto\"></canvas>";
    $out_scr .= AfwChartHelper::oniChartScript("Applicant", "cni", "line", -10, 0, 1, 'y', 'year', '');
}

if(true)
{
  $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1>احصائيات نمو عدد طلبات التقديم</h1></div>";
    $out_scr .= "<canvas id=\"rni\" style=\"width:100%;max-width:900px;margin:auto\"></canvas>";
    $out_scr .= AfwChartHelper::oniChartScript("Application", "rni", "line", -10, 0, 1, 'y', 'year', '', ['min'=>50, 'max'=>150]);
}


$out_scr .= "</div>";

/*
if(!class_exists("AfwSession")) die("page-not-found");
$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../external/db.php");
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

$out_scr .= $myEmplObj->showMinibox();
global $MODE_SQL_PROCESS_LOURD;

$MODE_SQL_PROCESS_LOURD = true;
//AcademicProgramOffering::genereAllNames($lang="ar");
/*
list($error, $info, $warn, $technical) = ApplicationModelBranch::genereAllNames($lang="ar");
AfwSession::pushPbmResult($lang, $error, $info, $warn, $technical, "home");
*/
/*
$schoolList = SchoolEmployee::getSchoolList($myEmplId);    
$structure = [];
$structure['MINIBOX-TEMPLATE'] = "tpl/school_minibox_tpl.php";
$structure['MINIBOX-TEMPLATE-PHP'] = true;
$structure['MINIBOX-OBJECT-KEY'] = "schoolObj";

if(!count($schoolList)) $out_scr .= "No school attached to this employee<br>";


foreach($schoolList as $schoolObj)
{
  $out_scr .= $schoolObj->showMinibox($structure);      
}
*/
                                   
?>