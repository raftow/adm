<?php
$file_dir_name = dirname(__FILE__); 
include_once ("$file_dir_name/ini.php");
include_once ("$file_dir_name/module_config.php"); 
require("$file_dir_name/../lib/afw/afw_main_page.php"); 
if($_REQUEST["Main_Page"])
{
    $Main_Page = $_REQUEST["Main_Page"];
}
else
{
    $Main_Page = "home.php";
}
$table = $_REQUEST["cl"]; // AfwStringHelper::classToTable($_REQUEST["cl"]);
if(!$table) $table = "all";

$options = AfwMainPage::getDefaultOptions($Main_Page, "adm", $table);
// die("main-options for $Main_Page : ".var_export($options,true));
AfwMainPage::echoMainPage($MODULE, $Main_Page, $file_dir_name, $options);