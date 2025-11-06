<?php
$file_dir_name = dirname(__FILE__); 
include_once ("$file_dir_name/ini.php");
include_once ("$file_dir_name/module_config.php"); 
require("$file_dir_name/../lib/afw/afw_main_page.php"); 
//die("rafik is upgrading librairies code=ADEF202511061552-01 ...");
if($_REQUEST["Main_Page"])
{
    $Main_Page = $_REQUEST["Main_Page"];
}
else
{
    $Main_Page = "home.php";
}
$table = null;
if(isset($_REQUEST["cl"])) $table = strtolower($_REQUEST["cl"]); 
// $table = AfwStringHelper::classToTable($_REQUEST["cl"]);
if(!$table) $table = "all";

$options = AfwMainPage::getDefaultOptions($Main_Page, "adm", $table);
// die("main-options for $Main_Page : ".var_export($options,true));
die("rafik is upgrading librairies code=ADEF202511061552-02 ...");
AfwMainPage::echoMainPage($MODULE, $Main_Page, $file_dir_name, $options);