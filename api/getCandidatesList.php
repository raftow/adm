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

if (!$application_plan_id) {
    echo "<div class='alert alert-warning'>بيانات غير كافية.</div>";
    exit;
}

$period_labels = [1 => 'صباحي', 2 => 'مسائي'];

$branch_filter = $branch_id ? "AND EXISTS (
    SELECT 1 FROM {$server_db_prefix}adm.application_plan_branch apb
    WHERE apb.id = $branch_id AND apb.program_id = n.academic_program_id
)" : "";

$q = "SELECT
        n.idn,
        CONCAT(COALESCE(n.first_name_ar,''), ' ', COALESCE(n.last_name_ar,'')) AS candidate_name,
        l.letter_code                       AS nomination_letter_num,
        o.nominating_authority_name_ar      AS authority_name,
        f.name_ar                           AS funding_status_name,
        p.program_title_ar                  AS program,
        n.training_period_enum,
        (SELECT 1 FROM {$server_db_prefix}workflow.workflow_request w
            INNER JOIN {$server_db_prefix}workflow.workflow_session ws2
                ON ws2.id = w.workflow_session_id AND ws2.external_code = 'PLAN-$application_plan_id'
            WHERE w.idn = n.idn LIMIT 1)    AS has_workflow,
        g.workflow_stage_name_ar,
        s.workflow_status_name_ar
    FROM {$server_db_prefix}adm.nominating_candidates n
    INNER JOIN {$server_db_prefix}adm.nomination_letter l
            ON l.id = n.nomination_letter_id
    INNER JOIN {$server_db_prefix}adm.nominating_authority o
            ON o.id = l.nominating_authority_id
    INNER JOIN {$server_db_prefix}adm.study_funding_status f
            ON f.id = n.study_funding_status_id
    LEFT JOIN {$server_db_prefix}adm.academic_program p
            ON p.id = n.academic_program_id
    LEFT JOIN {$server_db_prefix}workflow.workflow_request r
            ON r.idn = n.idn
    LEFT JOIN {$server_db_prefix}workflow.workflow_session ws
            ON ws.id = r.workflow_session_id AND ws.external_code = 'PLAN-$application_plan_id'
    LEFT JOIN {$server_db_prefix}workflow.workflow_stage g
            ON g.id = r.workflow_stage_id
    LEFT JOIN {$server_db_prefix}workflow.workflow_scope sp
            ON sp.id = r.workflow_scope_id
    LEFT JOIN {$server_db_prefix}workflow.workflow_status s
            ON s.id = r.workflow_status_id
    WHERE l.application_plan_id = $application_plan_id
      " . ($authority_id ? "AND o.id = $authority_id" : "") . "
      $branch_filter
    ORDER BY n.last_name_ar, n.first_name_ar";

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
    <th>رقم الخطاب</th>
    <th>جهة الترشيح</th>
    <th>نوع التمويل</th>
    <th>البرنامج</th>
    <th>الفترة</th>
    <th>لديه طلب</th>
    <th>المرحلة</th>
    <th>حالة الطلب</th>
</tr>
</thead>
<tbody>";

foreach ($rows as $i => $r) {
    $period  = $period_labels[intval($r['training_period_enum'])] ?? '-';
    $has_wf  = $r['has_workflow'] ? '<span class=\"badge badge-success\">نعم</span>' : '<span class=\"badge badge-secondary\">لا</span>';
    echo "<tr>
        <td style='text-align:center;'>".($i+1)."</td>
        <td>".htmlspecialchars($r['idn'])."</td>
        <td>".htmlspecialchars($r['candidate_name'])."</td>
        <td style='text-align:center;'>".htmlspecialchars($r['nomination_letter_num'] ?? '-')."</td>
        <td>".htmlspecialchars($r['authority_name'])."</td>
        <td>".htmlspecialchars($r['funding_status_name'])."</td>
        <td>".htmlspecialchars($r['program'] ?? '-')."</td>
        <td style='text-align:center;'>{$period}</td>
        <td style='text-align:center;'>{$has_wf}</td>
        <td>".htmlspecialchars($r['workflow_stage_name_ar'] ?? '-')."</td>
        <td>".htmlspecialchars($r['workflow_status_name_ar'] ?? '-')."</td>
    </tr>";
}

echo "</tbody></table></div>";
echo "<small class='text-muted'>إجمالي المرشحين: ".count($rows)."</small>";
?>
