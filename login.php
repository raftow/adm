<?php
      $file_dir_name = dirname(__FILE__); 
      include_once ("$file_dir_name/ini.php");
      include_once ("$file_dir_name/module_config.php"); 
      $direct_page = "login_ums.php";
      $direct_page_path = "$file_dir_name/../ums";
      require("$file_dir_name/../lib/afw/afw_main_page.php"); 
      AfwMainPage::echoDirectPage($MODULE, $direct_page, $direct_page_path);
?>