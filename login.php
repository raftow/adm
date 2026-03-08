<?php
      $file_dir_name = dirname(__FILE__); 
      include_once ("$file_dir_name/ini.php");
      include_once ("$file_dir_name/module_config.php"); 
      $direct_page = "login_ums.php";
      $direct_page_path = "$file_dir_name/../ums";
      require("$file_dir_name/../lib/afw/afw_main_page.php"); 
      //AfwMainPage::echoDirectPage($MODULE, $direct_page, $direct_page_path);

      /**WSO2 */
      $clientId = 'h51_DG3tGSlVV7tnmjNMuofMxAUa';
$redirectUri = 'https://localhost/adm/login_ums.php'; // عدلها حسب دومينك الحقيقي

$wso2AuthUrl = 'https://ethostest.nauss.edu.sa:443/oauth2/authorize';

$params = [
    'response_type' => 'code',
    'client_id'     => $clientId,
    'redirect_uri'  => $redirectUri,
    'scope'         => 'openid profile email',
    'state'         => bin2hex(random_bytes(8)), // لمنع CSRF
];

header('Location: ' . $wso2AuthUrl . '?' . http_build_query($params));
exit;
?>