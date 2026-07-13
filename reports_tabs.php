<?php
// $active_tab must be set by the including page to one of the keys below
$_tabs = [
    'reports'                  => 'تقارير المتقدمين',
    'reports_candidate'        => 'تقارير المرشحين',
    'reports_applicant'        => 'حالة التقديمات',
    'reports_search_applicant' => 'بحث عن متقدم',
];

$_style_inactive = 'border:none !important;color:#6c757d;';
$_style_active   = 'border:none !important;border-bottom:3px solid #007bff !important;color:#007bff;font-weight:600;background:transparent;';

$out_scr .= "<ul class='nav nav-tabs p-2'>";
foreach ($_tabs as $page => $label) {
    $is_active = (isset($active_tab) && $active_tab === $page);
    $cls   = $is_active ? 'nav-link active' : 'nav-link';
    $style = $is_active ? $_style_active : $_style_inactive;
    $out_scr .= "<li class='nav-item'>
        <a class='{$cls}' style='{$style}'
           href='/adm/index2.php?Main_Page={$page}.php'>{$label}</a>
      </li>";
}
$out_scr .= "</ul>";
