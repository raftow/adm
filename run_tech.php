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



// Generations

list($error, $info, $warn, $technical) = ApplicationField::reverseEngineeringAll($lang = "ar");
AfwSession::pushPbmResult($lang, $error, $info, $warn, $technical, "home");

$out_scr .= "<div id='page-content-wrapper' class='qsearch_page'><div class='row row-filter-request'>";
$out_scr .= "done";
$out_scr .= "</div>";


                                   
?>