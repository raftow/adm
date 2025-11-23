<?php
$direct_dir_name = $file_dir_name = dirname(__FILE__);
include("$file_dir_name/adm_start.php");
$objme = AfwSession::getUserConnected();
//if(!$objme) $studentMe = AfwSession::getStudentConnected();
$page_css_file = "content";
if($_REQUEST["Main_Page"])
{
    $Main_Page = $_REQUEST["Main_Page"];
}
else
{
    $Main_Page = "reports.php";
}
//$Main_Page = "home.php";
$MODULE = $My_Module = "adm";
$options = [];
$options["dashboard-stats"] = true;
$options["chart-js"] = true;
AfwMainPage::echoMainPage($My_Module, $Main_Page, $file_dir_name, $options);


