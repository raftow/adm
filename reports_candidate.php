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

if(!isset($lang)) $lang = AfwLanguageHelper::getGlobalLanguage();
else AfwLanguageHelper::setGlobalLanguage($lang);

$server_db_prefix = AfwSession::currentDBPrefix();

$application_plan_id = intval($_GET['application_plan_id'] ?? 11);
if(!$application_plan_id) $application_plan_id = 11;
$branch_id = intval($_GET['branch_id'] ?? 0);

$active_tab = 'reports_candidate';
require(__DIR__ . '/reports_tabs.php');

$out_scr .= "<div id='page-content-wrapper' class='container-fluid h-100'>";

// ── plan select ───────────────────────────────────────────────────────────────
$q_plans = "SELECT id, application_model_name_ar FROM {$server_db_prefix}adm.application_plan ORDER BY id DESC";
$plans_list = AfwDatabase::db_recup_rows($q_plans);

// ── branch select ─────────────────────────────────────────────────────────────
$q_branches = "SELECT id, name_ar FROM {$server_db_prefix}adm.application_plan_branch
               WHERE application_plan_id = $application_plan_id AND active = 'Y'
               ORDER BY id";
$branches_list = AfwDatabase::db_recup_rows($q_branches);

$out_scr .= "<div class='container-fluid m-3'>
    <div class='row'>
        <div class='col-md-4'>
            <label>الدفعة</label>
            <select id='application_plan_id' class='form-control'>
                <option value='' disabled>اختر الدفعة</option>";
foreach ($plans_list as $plan) {
    $sel = ($plan['id'] == $application_plan_id) ? 'selected' : '';
    $out_scr .= "<option value='{$plan['id']}' $sel>{$plan['application_model_name_ar']}</option>";
}
$out_scr .= "       </select>
        </div>
        <div class='col-md-4'>
            <label>فرع التقديم</label>
            <select id='branch_id' class='form-control'>
                <option value='0'>الكل</option>";
foreach ($branches_list as $b) {
    $sel = ($b['id'] == $branch_id) ? 'selected' : '';
    $out_scr .= "<option value='{$b['id']}' $sel>{$b['name_ar']}</option>";
}
$out_scr .= "       </select>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    function reloadPage() {
        var plan = $('#application_plan_id').val();
        var branch = $('#branch_id').val();
        if(plan) window.location.href = 'index2.php?Main_Page=reports_candidate.php&application_plan_id=' + plan + '&branch_id=' + branch;
    }
    $('#application_plan_id').change(reloadPage);
    $('#branch_id').change(reloadPage);
});
</script>";

// ── summary query ─────────────────────────────────────────────────────────────
$q_funding = "SELECT id, name_ar FROM {$server_db_prefix}adm.study_funding_status WHERE active='Y'";
$funding_status_list = AfwDatabase::db_recup_rows($q_funding);

$branch_where = "";
if ($branch_id) {
    $branch_where = "AND EXISTS (
        SELECT 1 FROM {$server_db_prefix}adm.application_desire ad_f
        JOIN {$server_db_prefix}adm.applicant ap_f ON ap_f.id = ad_f.applicant_id
        WHERE ap_f.idn = nc.idn
          AND ad_f.application_plan_id = $application_plan_id
          AND ad_f.application_plan_branch_id = $branch_id
          AND ad_f.active = 'Y'
    )";
}

$q_summary = "SELECT COUNT(*) NB_CANDIDATE, sfs.name_ar, na.nominating_authority_name_ar, na.id AS authority_id
    FROM {$server_db_prefix}adm.nominating_candidates nc
    JOIN {$server_db_prefix}adm.nomination_letter nl ON nc.nomination_letter_id = nl.id
    JOIN {$server_db_prefix}adm.nominating_authority na ON nl.nominating_authority_id = na.id
    LEFT JOIN {$server_db_prefix}adm.study_funding_status sfs ON nc.study_funding_status_id = sfs.id
    WHERE nl.application_plan_id = $application_plan_id
    $branch_where
    GROUP BY sfs.name_ar, na.nominating_authority_name_ar, na.id";
$results = AfwDatabase::db_recup_rows($q_summary);

$columns = [];
$rows    = [];
$auth_ids = [];

foreach ($results as $row) {
    $authority = $row['nominating_authority_name_ar'];
    $name      = $row['name_ar'] ?? 'غير محدد التمويل';
    $rows[$authority][$name] = $row['NB_CANDIDATE'];
    $auth_ids[$authority]    = $row['authority_id'];
}
foreach ($funding_status_list as $fs) {
    $columns[$fs['name_ar']] = true;
}

// ── summary table ─────────────────────────────────────────────────────────────
$out_scr .= '<div class="table-responsive p-2">';
$out_scr .= '<table id="reportTable" class="table table-bordered table-striped" style="width:100%;margin:0;">';
$out_scr .= '<thead><tr><th style="text-align:center;">جهة الترشيح</th>';
foreach (array_keys($columns) as $col) {
    $out_scr .= "<th style='text-align:center;'>{$col}</th>";
}
$out_scr .= "<th style='text-align:center;'>الكل</th></tr></thead><tbody>";

$total_col = [];
foreach ($rows as $authority => $data) {
    $aid = intval($auth_ids[$authority]);
    $out_scr .= "<tr>";
    $out_scr .= "<td style='text-align:right;'>
        <a href='#' class='text-primary font-weight-bold authority-link'
           data-authority-id='{$aid}'
           data-authority-name='".htmlspecialchars($authority)."'>
            ".htmlspecialchars($authority)."
        </a>
    </td>";
    $total_row = 0;
    foreach (array_keys($columns) as $col) {
        $val = $data[$col] ?? 0;
        $out_scr .= "<td style='text-align:center;'>{$val}</td>";
        $total_row += $val;
        $total_col[$col] = ($total_col[$col] ?? 0) + $val;
    }
    $out_scr .= "<td style='text-align:center;'>{$total_row}</td></tr>";
}
$grand_total_val = array_sum($total_col);
$out_scr .= "<tr><td style='text-align:center;'>
    <a href='#' class='text-primary font-weight-bold authority-link'
       data-authority-id='0'
       data-authority-name='الكل'>الكل</a>
</td>";
foreach (array_keys($columns) as $col) {
    $out_scr .= "<td style='text-align:center;'>".($total_col[$col] ?? 0)."</td>";
}
$out_scr .= "<td style='text-align:center;'>{$grand_total_val}</td></tr>";
$out_scr .= '</tbody></table></div>';

$out_scr .= '<button class="btn btn-primary m-2" onclick="exportToPDF()">تصدير PDF</button>';

// ── inline candidates panel ───────────────────────────────────────────────────
$out_scr .= "
<div id='candidatesPanel' style='display:none;' class='mt-4'>
    <div class='d-flex align-items-center justify-content-between mb-2'>
        <h5 id='candidatesPanelTitle' class='mb-0'></h5>
        <div>
            <button class='btn btn-success btn-sm mr-2' onclick='exportCandidatesPDF()'>تصدير PDF</button>
            <button class='btn btn-secondary btn-sm' onclick='closeCandidatesPanel()'>إغلاق</button>
        </div>
    </div>
    <div id='candidatesPanelBody'></div>
</div>";

// ── scripts ───────────────────────────────────────────────────────────────────
$out_scr .= "<script>
$(document).on('click', '.authority-link', function(e) {
    e.preventDefault();
    var authorityId   = \$(this).data('authority-id');
    var authorityName = \$(this).data('authority-name');
    \$('#candidatesPanelTitle').text('قائمة المرشحين - ' + authorityName);
    \$('#candidatesPanelBody').html('<div class=\"text-center p-4\"><div class=\"spinner-border text-primary\"></div></div>');
    \$('#candidatesPanel').show();
    \$('html, body').animate({ scrollTop: \$('#candidatesPanel').offset().top - 20 }, 400);
    \$.ajax({
        url: '/adm/api/getCandidatesList.php',
        method: 'GET',
        data: {
            authority_id: authorityId,
            application_plan_id: $application_plan_id,
            branch_id: $branch_id
        },
        success: function(html) {
            \$('#candidatesPanelBody').html(html);
        },
        error: function() {
            \$('#candidatesPanelBody').html('<div class=\"alert alert-danger\">حدث خطأ أثناء تحميل البيانات.</div>');
        }
    });
});

function closeCandidatesPanel() {
    \$('#candidatesPanel').hide();
    \$('#candidatesPanelBody').html('');
}

function exportCandidatesPDF() {
    var title   = \$('#candidatesPanelTitle').text();
    var content = document.getElementById('candidatesPanelBody').innerHTML;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index2.php?Main_Page=report_pdf.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'table_html'; i1.value = content;
    form.appendChild(i1);
    var i2 = document.createElement('input');
    i2.type = 'hidden'; i2.name = 'title'; i2.value = title;
    form.appendChild(i2);
    document.body.appendChild(form);
    form.submit();
}

function exportToPDF() {
    var tableHTML = document.getElementById('reportTable').outerHTML;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index2.php?Main_Page=report_pdf.php';
    var i1 = document.createElement('input');
    i1.type = 'hidden'; i1.name = 'table_html'; i1.value = tableHTML;
    form.appendChild(i1);
    var i2 = document.createElement('input');
    i2.type = 'hidden'; i2.name = 'title'; i2.value = 'قائمة المرشحين حسب التمويل';
    form.appendChild(i2);
    document.body.appendChild(form);
    form.submit();
}
</script>";

$out_scr .= "</div>";
?>
