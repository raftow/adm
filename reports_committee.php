<?php
$file_dir_name = dirname(__FILE__);
require_once("$file_dir_name/../config/global_config.php");

$datatable_on = 1;
$limite = 0;
$genere_xls = 0;

$objme = AfwSession::getUserConnected();
$myEmplId = $objme->getEmployeeId();

if (!isset($lang)) $lang = AfwLanguageHelper::getGlobalLanguage();
else AfwLanguageHelper::setGlobalLanguage($lang);

$server_db_prefix = AfwSession::currentDBPrefix();
$application_plan_id = intval($_GET['application_plan_id'] ?? 11);
if (!$application_plan_id) $application_plan_id = 11;

$active_tab = 'reports_committee';
require(__DIR__ . '/reports_tabs.php');

// ── plan selector ─────────────────────────────────────────────────────────────
$q_plans = "SELECT id, application_model_name_ar FROM {$server_db_prefix}adm.application_plan ORDER BY id DESC";
$plans_list = AfwDatabase::db_recup_rows($q_plans);

$out_scr .= "<div id='page-content-wrapper' class='container-fluid h-100'>";
$out_scr .= "<div class='container-fluid m-3'>
    <div class='row'>
        <div class='col-md-4'>
            <label>الدفعة</label>
            <select id='sel_plan' class='form-control'>";
foreach ($plans_list as $plan) {
    $sel = ($plan['id'] == $application_plan_id) ? 'selected' : '';
    $out_scr .= "<option value='{$plan['id']}' $sel>{$plan['application_model_name_ar']}</option>";
}
$out_scr .= "       </select>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#sel_plan').change(function() {
        var plan = $(this).val();
        if (plan) window.location.href = 'index2.php?Main_Page=reports_committee.php&application_plan_id=' + plan;
    });
});
</script>";

// ── Query 1: committee pivot ───────────────────────────────────────────────────
$q1 = "SELECT
    p.scope_name_ar  AS program,
    g.workflow_stage_name_ar AS stage,
    s.workflow_status_name_ar AS status,
    COUNT(DISTINCT r.id) AS total_count
FROM {$server_db_prefix}workflow.workflow_request r
INNER JOIN {$server_db_prefix}workflow.workflow_stage g   ON g.id = r.workflow_stage_id
INNER JOIN {$server_db_prefix}workflow.workflow_status s  ON s.id = r.workflow_status_id
INNER JOIN {$server_db_prefix}workflow.workflow_scope p   ON p.id = r.workflow_scope_id
INNER JOIN {$server_db_prefix}workflow.workflow_session ws
        ON ws.id = r.workflow_session_id AND ws.external_code = 'PLAN-$application_plan_id'
INNER JOIN {$server_db_prefix}adm.applicant a ON a.idn = r.idn
WHERE r.workflow_stage_id IN (2, 3)
GROUP BY p.scope_name_ar, g.workflow_stage_name_ar, s.workflow_status_name_ar
ORDER BY p.scope_name_ar, g.workflow_stage_name_ar, s.workflow_status_name_ar";

$q1_rows = AfwDatabase::db_recup_rows($q1);

// build pivot matrix
$pivot        = [];
$stages       = [];
$stage_status = [];

foreach ($q1_rows as $row) {
    $prog   = $row['program'];
    $stage  = $row['stage'];
    $status = $row['status'];
    $count  = intval($row['total_count']);

    $pivot[$prog][$stage][$status] = $count;
    $stages[$stage] = true;
    if (!in_array($status, $stage_status[$stage] ?? [])) {
        $stage_status[$stage][] = $status;
    }
}

// ── Table 1 ───────────────────────────────────────────────────────────────────
$out_scr .= "<div id='committeeReport' class='container-fluid p-2'>";
$out_scr .= "<h5 class='mb-2'>أعمال اللجان</h5>
<div class='table-responsive'>
<table id='tbl1' class='table table-bordered table-sm table-striped' style='width:100%;'>
<thead>
<tr>
    <th rowspan='2' style='text-align:right;vertical-align:middle;'>البرنامج</th>";

foreach (array_keys($stages) as $stage) {
    $colspan = count($stage_status[$stage] ?? [1]);
    $out_scr .= "<th colspan='{$colspan}' style='text-align:center;'>{$stage}</th>";
}
$out_scr .= "<th rowspan='2' style='text-align:center;vertical-align:middle;'>العدد الإجمالي</th></tr><tr>";

foreach (array_keys($stages) as $stage) {
    foreach ($stage_status[$stage] ?? [] as $status) {
        $out_scr .= "<th style='text-align:center;'>{$status}</th>";
    }
}
$out_scr .= "</tr></thead><tbody>";

$col_totals  = [];
$grand_total = 0;

foreach ($pivot as $prog => $stage_data) {
    $row_total = 0;
    $out_scr .= "<tr><td style='text-align:right;'>".htmlspecialchars($prog)."</td>";
    foreach (array_keys($stages) as $stage) {
        foreach ($stage_status[$stage] ?? [] as $status) {
            $val = $pivot[$prog][$stage][$status] ?? 0;
            $out_scr .= "<td style='text-align:center;'>{$val}</td>";
            $row_total += $val;
            $col_totals[$stage][$status] = ($col_totals[$stage][$status] ?? 0) + $val;
        }
    }
    $out_scr .= "<td style='text-align:center;font-weight:bold;color:#dc3545;'>{$row_total}</td></tr>";
    $grand_total += $row_total;
}

$out_scr .= "<tr><td style='text-align:right;font-weight:bold;'>العدد الإجمالي</td>";
foreach (array_keys($stages) as $stage) {
    foreach ($stage_status[$stage] ?? [] as $status) {
        $val = $col_totals[$stage][$status] ?? 0;
        $out_scr .= "<td style='text-align:center;font-weight:bold;color:#dc3545;'>{$val}</td>";
    }
}
$out_scr .= "<td style='text-align:center;font-weight:bold;color:#dc3545;'>{$grand_total}</td></tr>";
$out_scr .= "</tbody></table></div>";

// ── Query 2: CV tracking ───────────────────────────────────────────────────────
$q2 = "SELECT
    p.scope_name_ar AS program,
    COUNT(DISTINCT a.id)                                    AS total_applicant_id,
    COUNT(cv.applicant_id)                                  AS have_cv,
    COUNT(DISTINCT a.id) - COUNT(cv.applicant_id)           AS without_cv,
    COUNT(cv.total_score)                                   AS cv_evaluated
FROM {$server_db_prefix}workflow.workflow_request r
INNER JOIN {$server_db_prefix}workflow.workflow_stage g   ON g.id = r.workflow_stage_id
INNER JOIN {$server_db_prefix}workflow.workflow_status s  ON s.id = r.workflow_status_id
INNER JOIN {$server_db_prefix}workflow.workflow_scope p   ON p.id = r.workflow_scope_id
INNER JOIN {$server_db_prefix}workflow.workflow_session ws
        ON ws.id = r.workflow_session_id AND ws.external_code = 'PLAN-$application_plan_id'
INNER JOIN {$server_db_prefix}adm.applicant a ON a.idn = r.idn
LEFT JOIN (
    SELECT applicant_id, total_score
    FROM {$server_db_prefix}adm.application_cv_score
) cv ON cv.applicant_id = a.id
WHERE r.workflow_stage_id IN (2, 3, 4)
GROUP BY p.scope_name_ar
ORDER BY p.scope_name_ar";

$q2_rows = AfwDatabase::db_recup_rows($q2);

$out_scr .= "<h5 class='mt-4 mb-2'>متابعة السير الذاتية</h5>
<div class='table-responsive'>
<table id='tbl2' class='table table-bordered table-sm table-striped' style='width:100%;'>
<thead>
<tr>
    <th style='text-align:right;'>البرنامج</th>
    <th style='text-align:center;'>عدد المتقدمين المحالين</th>
    <th style='text-align:center;'>لم يدخلوا سيرة ذاتية</th>
    <th style='text-align:center;'>لديهم سيرة ذاتية</th>
    <th style='text-align:center;'>تم تقييمهم</th>
    <th style='text-align:center;'>لم يتم تقييمهم</th>
</tr>
</thead><tbody>";

$t_total = $t_without = $t_have = $t_eval = $t_not_eval = 0;

foreach ($q2_rows as $r) {
    $not_evaluated = intval($r['have_cv']) - intval($r['cv_evaluated']);
    $out_scr .= "<tr>
        <td style='text-align:right;'>".htmlspecialchars($r['program'])."</td>
        <td style='text-align:center;'>".intval($r['total_applicant_id'])."</td>
        <td style='text-align:center;'>".intval($r['without_cv'])."</td>
        <td style='text-align:center;'>".intval($r['have_cv'])."</td>
        <td style='text-align:center;color:green;font-weight:bold;'>".intval($r['cv_evaluated'])."</td>
        <td style='text-align:center;color:red;font-weight:bold;'>{$not_evaluated}</td>
    </tr>";
    $t_total   += intval($r['total_applicant_id']);
    $t_without += intval($r['without_cv']);
    $t_have    += intval($r['have_cv']);
    $t_eval    += intval($r['cv_evaluated']);
    $t_not_eval += $not_evaluated;
}

$out_scr .= "<tr>
    <td style='text-align:right;font-weight:bold;'>العدد الإجمالي</td>
    <td style='text-align:center;font-weight:bold;'>{$t_total}</td>
    <td style='text-align:center;font-weight:bold;'>{$t_without}</td>
    <td style='text-align:center;font-weight:bold;'>{$t_have}</td>
    <td style='text-align:center;font-weight:bold;color:green;'>{$t_eval}</td>
    <td style='text-align:center;font-weight:bold;color:red;'>{$t_not_eval}</td>
</tr>";
$out_scr .= "</tbody></table></div>";

// ── PDF export ─────────────────────────────────────────────────────────────────
$out_scr .= "<br><button class='btn btn-primary m-2' onclick='exportCommitteePDF()'>تصدير PDF</button>";
$out_scr .= "</div>"; // #committeeReport

$out_scr .= "<script>
function exportCommitteePDF() {
    var content = document.getElementById('committeeReport').innerHTML;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index2.php?Main_Page=report_pdf.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'table_html'; i1.value = content;
    form.appendChild(i1);
    var i2 = document.createElement('input');
    i2.type = 'hidden'; i2.name = 'title'; i2.value = 'تقرير أعمال اللجان';
    form.appendChild(i2);
    document.body.appendChild(form);
    form.submit();
}
</script>";

$out_scr .= "</div>";
?>
