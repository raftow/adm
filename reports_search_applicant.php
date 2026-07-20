<?php
/**
 * @var string $modp
 */
$file_dir_name = dirname(__FILE__);
require_once("$file_dir_name/../lib/afw/core/afw_autoloader.php");
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);

$datatable_on = 1;
$limite = 0;
$genere_xls = 0;

AfwSession::startSession();

require_once("$file_dir_name/../config/global_config.php");
$only_members = true;
$debug_name   = "autocomplete";
require("$file_dir_name/../lib/afw/includes/afw_check_member.php");

if (!isset($objme)) $objme = AfwSession::getUserConnected();
if (!isset($lang))  $lang  = AfwLanguageHelper::getGlobalLanguage();
else AfwLanguageHelper::setGlobalLanguage($lang);

if ($currmod) AfwAutoLoader::addMainModule($currmod);
if ($modp and ($modp != $currmod)) AfwAutoLoader::addModule($modp);

$server_db_prefix = AfwSession::currentDBPrefix();

// ── label maps ────────────────────────────────────────────────────────────────
$gender_labels = [1 => 'ذكر', 2 => 'أنثى'];
$period_labels = [1 => 'صباحي', 2 => 'مسائي'];
$app_status_labels = [
    1 => 'تقديم غير مكتمل',
    2 => 'تقديم مكتمل',
    3 => 'منسحب',
    4 => 'مراجعة البيانات',
    5 => 'مقبول',
    6 => 'مرفوض',
];

// ── search ────────────────────────────────────────────────────────────────────
$search      = trim($_GET['search'] ?? '');
$applicant   = null;
$desires     = [];
$application = null;

if ($search) {
    $s = addslashes($search);

    $q_applicant = "SELECT
            a.id,
            a.idn,
            CONCAT(
                COALESCE(a.first_name_ar,''), ' ',
                COALESCE(a.father_name_ar,''), ' ',
                COALESCE(a.middle_name_ar,''), ' ',
                COALESCE(a.last_name_ar,'')
            ) AS full_name_ar,
            a.gender_enum,
            a.mobile,
            a.email,
            a.employer_desc,
            aq.gpa,
            aq.gpa_from,
            gs.value_ar  AS grading_scale,
            aq.source_name,
            q.qualifcation_name_ar,
            mc.major_category_name_ar,
            qm.qualification_major_name_ar
        FROM {$server_db_prefix}adm.applicant a
        LEFT JOIN {$server_db_prefix}adm.applicant_qualification aq
               ON aq.applicant_id = a.id AND aq.active = 'Y'
        LEFT JOIN {$server_db_prefix}adm.grading_scale gs
               ON gs.id = aq.grading_scale_id
        LEFT JOIN {$server_db_prefix}adm.qualification q
               ON q.id = aq.qualification_id
        LEFT JOIN {$server_db_prefix}adm.major_category mc
               ON mc.id = aq.major_category_id
        LEFT JOIN {$server_db_prefix}adm.qualification_major qm
               ON qm.id = aq.qualification_major_id
        WHERE a.active = 'Y'
          AND (a.idn = '$s' OR a.mobile = '$s' OR a.email = '$s')
        LIMIT 1";

    $rows = AfwDatabase::db_recup_rows($q_applicant);
    if (!empty($rows)) {
        $applicant      = $rows[0];
        $applicant_id   = $applicant['id'];

        // latest active application
        $q_app = "SELECT applicant_id, application_plan_id, application_status_enum
                  FROM {$server_db_prefix}adm.application
                  WHERE applicant_id = '$applicant_id' AND active = 'Y'
                  ORDER BY created_at DESC LIMIT 1";
        $app_rows = AfwDatabase::db_recup_rows($q_app);
        if (!empty($app_rows)) {
            $application = $app_rows[0];
            $app_plan_id = $application['application_plan_id'];

            // desires for that application
            $q_desires = "SELECT
                    ad.desire_num,
                    ac.program_name_ar,
                    apb.training_period_enum,
                    apb.gender_enum AS branch_gender
                FROM {$server_db_prefix}adm.application_desire ad
                LEFT JOIN {$server_db_prefix}adm.application_plan_branch apb
                       ON apb.id = ad.application_plan_branch_id
                LEFT JOIN {$server_db_prefix}adm.academic_program ac
                       ON ac.id = apb.program_id
                WHERE ad.applicant_id = '$applicant_id'
                  AND ad.application_plan_id = '$app_plan_id'
                  AND ad.active = 'Y'
                ORDER BY ad.desire_num";
            $desires = AfwDatabase::db_recup_rows($q_desires);

            // workflow status via idn + plan session
            $applicant_idn = addslashes($applicant['idn']);
            $q_wf = "SELECT ws.workflow_status_name_ar, wg.workflow_stage_name_ar
                FROM {$server_db_prefix}workflow.workflow_request wr
                JOIN {$server_db_prefix}workflow.workflow_session wses
                       ON wses.id = wr.workflow_session_id
                LEFT JOIN {$server_db_prefix}workflow.workflow_status ws
                       ON ws.id = wr.workflow_status_id
                LEFT JOIN {$server_db_prefix}workflow.workflow_stage wg
                       ON wg.id = wr.workflow_stage_id
                WHERE wr.idn = '$applicant_idn'
                  AND wses.external_code = 'PLAN-$app_plan_id'
                LIMIT 1";
            $wf_rows = AfwDatabase::db_recup_rows($q_wf);
            $workflow_status_name = $wf_rows[0]['workflow_status_name_ar'] ?? '-';
            $workflow_stage_name  = $wf_rows[0]['workflow_stage_name_ar']  ?? '-';
        }
    }
}

// ── nav tabs ──────────────────────────────────────────────────────────────────
$active_tab = 'reports_search_applicant';
require(__DIR__ . '/reports_tabs.php');

$out_scr .= "<div id='page-content-wrapper' class='container-fluid h-100'>";
$out_scr .= "<br><br><br><h2 class='m-2'>بحث عن متقدم</h2><br>";
$out_scr .= "</div>";

// ── search form ───────────────────────────────────────────────────────────────
$out_scr .= "<div class='container-fluid m-3'>
    <form method='get'>
        <input type='hidden' name='Main_Page' value='reports_search_applicant.php'>
        <div class='row'>
            <div class='col-md-5'>
                <label>السجل المدني / الجوال / البريد الإلكتروني</label>
                <input type='text' name='search' value='".htmlspecialchars($search)."'
                       class='form-control' placeholder='ابحث بالسجل المدني أو الجوال أو البريد الإلكتروني'>
            </div>
            <div class='col-md-2 d-flex align-items-end'>
                <button type='submit' class='btn btn-primary w-100'>بحث</button>
            </div>
        </div>
    </form>
</div>";

// ── results ───────────────────────────────────────────────────────────────────
if ($search && $applicant === null) {
    $out_scr .= "<div class='container-fluid m-3'><div class='alert alert-warning'>لم يتم العثور على متقدم بهذه المعلومات.</div></div>";
}

if ($applicant) {
    $app_status_label  = $app_status_labels[intval($application['application_status_enum'])] ?? '-';
    $gender_label      = $gender_labels[intval($applicant['gender_enum'])] ?? '-';

    $out_scr .= "<div class='container-fluid m-3' id='applicantResult'>";

    // personal info
    $out_scr .= "<h5 class='mb-3'>المعلومات الشخصية</h5>
    <table class='table table-bordered table-sm' style='max-width:900px;'>
        <tr>
            <th>السجل المدني</th>
            <td>".htmlspecialchars($applicant['idn'])."</td>
            <th>الاسم الكامل</th>
            <td>".htmlspecialchars($applicant['full_name_ar'])."</td>
        </tr>
        <tr>
            <th>الجنس</th>
            <td>".$gender_label."</td>
            <th>الجوال</th>
            <td>".htmlspecialchars($applicant['mobile'])."</td>
        </tr>
        <tr>
            <th>البريد الإلكتروني</th>
            <td colspan='3'>".htmlspecialchars($applicant['email'])."</td>
        </tr>
        <tr>
            <th>جهة العمل</th>
            <td colspan='3'>".htmlspecialchars($applicant['employer_desc'])."</td>
        </tr>
        <tr>
            <th>المعدل (GPA)</th>
            <td>".htmlspecialchars($applicant['gpa'])."</td>
            <th>من</th>
            <td>".htmlspecialchars($applicant['gpa_from'])."</td>
        </tr>
        <tr>
            <th>التقدير</th>
            <td>".htmlspecialchars($applicant['grading_scale'])."</td>
            <th>الجامعة / المعهد</th>
            <td>".htmlspecialchars($applicant['source_name'])."</td>
        </tr>
        <tr>
            <th>المؤهل</th>
            <td colspan='3'>".htmlspecialchars($applicant['qualifcation_name_ar'])."</td>
        </tr>
        <tr>
            <th>التخصص</th>
            <td>".htmlspecialchars($applicant['major_category_name_ar'])."</td>
            <th>التخصص الدقيق</th>
            <td>".htmlspecialchars($applicant['qualification_major_name_ar'])."</td>
        </tr>
        <tr>
            <th>حالة التقديم</th>
            <td colspan='3'><strong>".$app_status_label."</strong></td>
        </tr>
    </table>";

    // desires
    if (!empty($desires)) {
        $out_scr .= "<h5 class='mt-4 mb-3'>الرغبات</h5>
        <table class='table table-bordered table-sm table-striped' style='max-width:900px;'>
            <thead>
                <tr>
                    <th style='text-align:center;'>رقم الرغبة</th>
                    <th style='text-align:center;'>البرنامج</th>
                    <th style='text-align:center;'>الفترة</th>
                    <th style='text-align:center;'>مرحلة الطلب</th>
                    <th style='text-align:center;'>حالة الرغبة</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($desires as $d) {
            $period_label    = $period_labels[intval($d['training_period_enum'])] ?? '-';
            $d_stage_label   = htmlspecialchars($workflow_stage_name  ?? '-');
            $d_status_label  = htmlspecialchars($workflow_status_name ?? '-');
            $out_scr .= "<tr>
                <td style='text-align:center;'>".intval($d['desire_num'])."</td>
                <td>".htmlspecialchars($d['program_name_ar'])."</td>
                <td style='text-align:center;'>".$period_label."</td>
                <td style='text-align:center;'>".$d_stage_label."</td>
                <td style='text-align:center;'>".$d_status_label."</td>
            </tr>";
        }
        $out_scr .= "</tbody></table>";
    } else {
        $out_scr .= "<p class='text-muted'>لا توجد رغبات مسجلة.</p>";
    }

    $out_scr .= "<br><button class='btn btn-primary' onclick='exportToPDF()'>تصدير PDF</button>";
    $out_scr .= "</div>"; // #applicantResult
}

// ── PDF export ────────────────────────────────────────────────────────────────
if ($applicant) {
    $pdf_title = 'معلومات المتقدم - ' . htmlspecialchars($applicant['full_name_ar']);
    $out_scr .= "<script>
    function exportToPDF() {
        var content = document.getElementById('applicantResult').innerHTML;

        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index2.php?Main_Page=report_pdf.php';

        var input1 = document.createElement('input');
        input1.type  = 'hidden';
        input1.name  = 'table_html';
        input1.value = content;
        form.appendChild(input1);

        var input2 = document.createElement('input');
        input2.type  = 'hidden';
        input2.name  = 'title';
        input2.value = " . json_encode($pdf_title) . ";
        form.appendChild(input2);

        document.body.appendChild(form);
        form.submit();
    }
    </script>";
}
?>
