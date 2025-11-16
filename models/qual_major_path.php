<?php

class QualMajorPath extends AdmObject
{

    public static $DATABASE = '';

    public static $MODULE = 'adm';

    public static $TABLE = 'qual_major_path';

    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct('qual_major_path', 'id', 'adm');
        AdmQualMajorPathAfwStructure::initInstance($this);

    }

    public static function loadById($id)
    {
        $obj = new QualMajorPath();

        if ($obj->load($id)) {
            return $obj;
        } else {
            return null;
        }

    }

    public function getDisplay($lang = 'ar')
    {
        return $this->getDefaultDisplay($lang);
    }

    public function stepsAreOrdered()
    {
        return false;
    }

    
    public function beforeDelete($id, $id_replace)
    {
        $server_db_prefix = AfwSession::config('db_prefix', 'nauss_');

        if (! $id) {
            $id    = $this->getId();
            $simul = true;
        } else {
            $simul = false;
        }

        if ($id) {

            if ($id_replace == 0) {
                // FK part of me - not deletable

                // FK part of me - deletable

                // FK not part of me - replaceable

                // MFK

            } else {
                // FK on me

                // MFK

            }

            return true;
        }

    }

    protected function getPublicMethods()
    {

        $pbms = array();
        
        $color = "green";
        $title_ar = "طباعة التقرير";
        $methodName = "printReport";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "");/*'STEP' => 1*/
        
        
        return $pbms;
        
    }


    public function printReport($lang = "ar", $commit = true)
    {
        
        
        require_once __DIR__ . '/../../lib/vendor/autoload.php';
        //die(__DIR__ . '/../../lib/vendor/autoload.php');
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'default_font' => 'dejavusans', // يدعم العربية
            'margin_top' => 15, // Margin for the main body content
            'margin_bottom' => 25,
            'margin_header' => 5, // Margin for the header content
            'margin_footer' => 10, 
            'margin_left' => 3,
            'margin_right' =>3,
            'setAutoTopMargin' => 'pad'
        ]);
        $db = $this->getDatabase();
        $query = "select q.qualifcation_name_ar,q.qualifcation_name_en,
        qm.qualification_major_name_ar,qm.qualification_major_name_en,qm.saudi_unified_code,mp.major_path_name_ar,mp.major_path_name_en
        from $db.qualification q,$db.qualification_major qm,$db.qual_major_path qp,$db.major_path mp 
        where q.id=qp.qualification_id and qp.qualification_major_id=qm.id and mp.id=qp.major_path_id 
        and q.active='Y' and qm.active='Y' and qp.active='Y' and mp.active='Y'";
        $result = AfwDatabase::db_recup_rows($query);
        
        $arr_pdf = array();
        

        foreach($result as $row){
            $arr_pdf[$row["qualifcation_name_ar"]][$row["major_path_name_ar"]][] = array($row["qualification_major_name_ar"],$row["saudi_unified_code"]);
        }
        //die(var_dump($arr_pdf));
        $html_header = '<div style="background-color: rgb(46, 96, 102); padding: 10px 20px; font-family: Arial, sans-serif;">
    <table style="width: 100%; border-collapse: collapse; border: none;">
        <tr>
            <td style="width: 150px; border: none;">
                <img width="150" src="https://frontend.bmeholding.com/images/logo.svg" alt="brand logo" />
            </td>
            <td style="vertical-align: middle; font-size: 18px; font-weight: bold; color: white; border: none;">
                قائمة تخصصات المؤهلات
            </td>
            <td style="text-align:left;vertical-align: middle; font-size: 14px; font-weight: bold; color: white; border: none;">'.date('Y/m/d').'</td>
        </tr>
    </table>
</div>
';
        $mpdf->SetHTMLHeader($html_header);

        // محتوى HTML
        $html = '
        <html dir="rtl" lang="ar">

            <style>
                body { font-family: "dejavusans"; }
                h1 { text-align: center; color: #2b2b2b; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #444; padding: 8px; text-align: center; }
                th { background-color: #f2f2f2; }
                /*.container, .auth-navbar {
                    box-shadow: unset;
                   background-image: url(https://frontend.bmeholding.com/images/pattern_menu.svg);
                    /*background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;*/
                    position: relative;
                }
                .container::before, .auth-navbar::before {
                    content: "";
                    position: absolute;
                    inset: 0; /* top:0; right:0; bottom:0; left:0; */
                    background: rgba(255, 255, 255, 0.9); /* لون أبيض شبه شفاف */
                    pointer-events: none; /* لا تعيق النقر على العناصر */
                    z-index: 1;
                }

                /* لضمان محتوى العنصر فوق الطبقة */
                .container > *, .auth-navbar > * {
                    position: relative;
                    z-index: 2;
                }*/
            </style>
        ';


           $list .= '<ul class="qualifications-list">';

            foreach($arr_pdf as $qualification => $majors) {
                $list .= '<li>';
                $list .= '<strong>' . htmlspecialchars($qualification) . '</strong>';

                $list .= '<ul class="majors-list">';

                foreach($majors as $majorPath => $majorsList) {
                    // لكل مسار تخصصات

                    // عنوان المسار
                    $list .= '<li>';
                    $list .= '<h3 style="margin-top:20px; font-size:18px;">' . htmlspecialchars($majorPath) . '</h3>';

                    // جدول التخصصات
                    $list .= '
                        <table style="width:100%; border-collapse: collapse; margin-bottom:20px;">
                            <thead>
                                <tr style="background:#f2f2f2;">
                                    <th style="border:1px solid #ccc; padding:8px;" width="70%">اسم التخصص</th>
                                    <th style="border:1px solid #ccc; padding:8px;">التصنيف السعودي للتخصص</th>
                                </tr>
                            </thead>
                            <tbody>
                    ';

                    foreach ($majorsList as $major) {
                        $extraValue = isset($major[1]) ? htmlspecialchars($major[1]) : '';
                        $list .= '
                            <tr>
                                <td style="border:1px solid #ccc; padding:8px;">' . htmlspecialchars($major[0]) . '</td>
                                <td style="border:1px solid #ccc; padding:8px;">' . $extraValue . '</td>
                            </tr>
                        ';
                    }

                    $list .= '
                            </tbody>
                        </table>
                    ';
                    $list .= '</li>';
                }

                $list .= '</ul>';
                $list .= '</li>';
            }

            $list .= '</ul>';

        $html .= $list;

        $html .= '<br><br><br><p style="text-align:right; margin-top:20px;">
                تم إنشاء التقرير بتاريخ '.date('Y-m-d').'
            </p>

        ';
        $mpdf->SetMargins(15, 50,15);
        //$mpdf->SetHeaderMargin(10);
        //$mpdf->SetFooterMargin(10);

        // توليد PDF
        $mpdf->WriteHTML($html);
        $mpdf->Output('sales-report.pdf', 'I'); // 'I' = عرض في المتصفح

        //return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

}
