<?php

$file_dir_name = dirname(__FILE__);
require_once("$file_dir_name/../../lib/afw/core/afw_autoloader.php");
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);

AfwSession::startSession();

require_once("$file_dir_name/../../config/global_config.php");
$only_members = true;
$debug_name   = "getCandidatesList";
require("$file_dir_name/../lib/afw/includes/afw_check_member.php");

if (!isset($objme)) $objme = AfwSession::getUserConnected();

$server_db_prefix    = AfwSession::currentDBPrefix();
$authority_id        = intval($_GET['authority_id'] ?? 0);
$application_plan_id = intval($_GET['application_plan_id'] ?? 0);
$branch_id           = intval($_GET['branch_id'] ?? 0);

if (!$authority_id || !$application_plan_id) {
    echo "<div class='alert alert-warning'>بيانات غير كافية.</div>";
    exit;
}

$app_status_labels = [
    1 => 'تقديم غير مكتمل',
    2 => 'تقديم مكتمل',
    3 => 'منسحب',
    4 => 'مراجعة البيانات',
    5 => 'مقبول',
    6 => 'مرفوض',
];

$branch_filter = $branch_id ? "AND EXISTS (
    SELECT 1 FROM {$server_db_prefix}adm.application_desire ad_f
    WHERE ad_f.applicant_id = ap2.id
      AND ad_f.application_plan_id = $application_plan_id
      AND ad_f.application_plan_branch_id = $branch_id
      AND ad_f.active = 'Y'
)" : "";

$q = "SELECT
        nc.idn,
        CONCAT(COALESCE(nc.first_name_ar,''),' ',COALESCE(nc.last_name_ar,'')) AS candidate_name,
        nl.letter_code AS nomination_letter_num,
        na.nominating_authority_name_ar,
        app.application_status_enum,
        desires.branch_names,
        ws.workflow_status_name_ar
    FROM {$server_db_prefix}adm.nominating_candidates nc
    JOIN {$server_db_prefix}adm.nomination_letter nl
           ON nl.id = nc.nomination_letter_id
    JOIN {$server_db_prefix}adm.nominating_authority na
           ON na.id = nl.nominating_authority_id
    LEFT JOIN {$server_db_prefix}adm.applicant ap2
           ON ap2.idn = nc.idn AND ap2.active = 'Y'
    LEFT JOIN {$server_db_prefix}adm.application app
           ON app.applicant_id = ap2.id
          AND app.application_plan_id = $application_plan_id
          AND app.active = 'Y'
    LEFT JOIN (
        SELECT ad.applicant_id,
               GROUP_CONCAT(apb.name_ar ORDER BY ad.desire_num SEPARATOR ' / ') AS branch_names
        FROM {$server_db_prefix}adm.application_desire ad
        JOIN {$server_db_prefix}adm.application_plan_branch apb
               ON apb.id = ad.application_plan_branch_id
        WHERE ad.application_plan_id = $application_plan_id AND ad.active = 'Y'
        GROUP BY ad.applicant_id
    ) desires ON desires.applicant_id = ap2.id
    LEFT JOIN {$server_db_prefix}workflow.workflow_request wr
           ON wr.idn = nc.idn
    LEFT JOIN {$server_db_prefix}workflow.workflow_session wses
           ON wses.id = wr.workflow_session_id
          AND wses.external_code = 'PLAN-$application_plan_id'
    LEFT JOIN {$server_db_prefix}workflow.workflow_status ws
           ON ws.id = wr.workflow_status_id
    WHERE nl.application_plan_id = $application_plan_id
      AND na.id = $authority_id
      $branch_filter
    ORDER BY nc.last_name_ar, nc.first_name_ar";

$rows = AfwDatabase::db_recup_rows($q);

if (empty($rows)) {
    echo "<div class='alert alert-info'>لا يوجد مرشحون لهذه الجهة.</div>";
    exit;
}

echo "<div class='table-responsive'>
<table class='table table-bordered table-sm table-striped' id='candidatesDetailTable'>
<thead>
<tr>
    <th>#</th>
    <th>السجل المدني</th>
    <th>اسم المرشح</th>
    <th>رقم خطاب الترشيح</th>
    <th>جهة الترشيح</th>
    <th>فروع التقديم</th>
    <th>حالة التقديم</th>
    <th>حالة الطلب</th>
</tr>
</thead>
<tbody>";

foreach ($rows as $i => $r) {
    $status_label = $app_status_labels[intval($r['application_status_enum'])] ?? '-';
    echo "<tr>
        <td style='text-align:center;'>".($i+1)."</td>
        <td>".htmlspecialchars($r['idn'])."</td>
        <td>".htmlspecialchars($r['candidate_name'])."</td>
        <td style='text-align:center;'>".htmlspecialchars($r['nomination_letter_num'])."</td>
        <td>".htmlspecialchars($r['nominating_authority_name_ar'])."</td>
        <td>".htmlspecialchars($r['branch_names'] ?? '-')."</td>
        <td style='text-align:center;'>".$status_label."</td>
        <td>".htmlspecialchars($r['workflow_status_name_ar'] ?? '-')."</td>
    </tr>";
}

echo "</tbody></table></div>";
echo "<small class='text-muted'>إجمالي المرشحين: ".count($rows)."</small>";
?>
