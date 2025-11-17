<?php
class ProgramQualification extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "program_qualification";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;
        public static $arrAllProgramQualification = [];

        public function __construct()
        {
                parent::__construct("program_qualification", "id", "adm");
                AdmProgramQualificationAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                if(!self::$arrAllProgramQualification[$id])
                {
                        $obj = new ProgramQualification();
                        if($obj->load($id))
                        {
                                self::$arrAllProgramQualification[$id] =& $obj;
                        }
                        else self::$arrAllProgramQualification[$id] = "NOT-FOUND";
                }
                if(self::$arrAllProgramQualification[$id]=="NOT-FOUND") return null;

                return self::$arrAllProgramQualification[$id];                
        }

        public static function loadByMainIndex($academic_program_id, $qualification_id, $major_path_id, $qualification_major_id=0, $create_obj_if_not_found = false)
        {
                if (!$academic_program_id) throw new AfwRuntimeException("loadByMainIndex : academic_program_id is mandatory field");
                if (!$qualification_id) throw new AfwRuntimeException("loadByMainIndex : qualification_id is mandatory field");
                if (!$major_path_id) throw new AfwRuntimeException("loadByMainIndex : major_path_id is mandatory field");
                $id = "UK$academic_program_id-$qualification_id-$major_path_id-$qualification_major_id";
                if(!self::$arrAllProgramQualification[$id])
                {

                        $obj = new ProgramQualification();
                        $obj->select("academic_program_id", $academic_program_id);
                        $obj->select("qualification_id", $qualification_id);
                        $obj->select("major_path_id", $major_path_id);
                        $obj->select("qualification_major_id", $qualification_major_id);

                        if ($obj->load()) {
                                if ($create_obj_if_not_found) $obj->activate();
                                self::$arrAllProgramQualification[$id] =& $obj;
                        } elseif ($create_obj_if_not_found) {
                                $obj->set("academic_program_id", $academic_program_id);
                                $obj->set("qualification_id", $qualification_id);
                                $obj->set("major_path_id", $major_path_id);
                                $obj->set("qualification_major_id", $qualification_major_id);

                                $obj->insertNew();
                                if (!$obj->id) self::$arrAllProgramQualification[$id] = "NOT-FOUND";
                                $obj->is_new = true;
                                self::$arrAllProgramQualification[$id] =& $obj;
                        } else self::$arrAllProgramQualification[$id] = "NOT-FOUND";
                }

                if(self::$arrAllProgramQualification[$id]=="NOT-FOUND") return null;

                return self::$arrAllProgramQualification[$id];
        }


        public static function pathExistsFor($academic_program_id, $split_sorting_by_enum, $major_path_id, $returnObject=false)
        {
                // 2 = "تقسيم حسب مجموعة التأهيل" = "Split with major path"
                if ($split_sorting_by_enum == 2) {
                        $mpObj = MajorPath::loadById($major_path_id);
                        $qualification_id = $mpObj->getVal("qualification_id");
                        if($academic_program_id and $qualification_id and $major_path_id)
                        {
                                $progQualObj = self::loadByMainIndex($academic_program_id, $qualification_id, $major_path_id, 0);
                        }
                        else $progQualObj = null;

                        // if(!$progQualObj) die("self::loadByMainIndex($academic_program_id, $qualification_id, $major_path_id, 0) not found");

                        if($returnObject) return $progQualObj;
                        else return ($progQualObj and ($progQualObj->id>0));
                }


                if($returnObject) return null;
                else return false;
        }




        public function getDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        protected function getPublicMethods()
        {

                $pbms = array();
                
                $color = "green";
                $title_ar = "طباعة التقرير";
                $methodName = "programQualificationReport";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "");/*'STEP' => 1*/
                
                
                return $pbms;
                
        }
        public function programQualificationReport($lang = "ar", $commit = true)
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
                $query = "select v.academic_level_name_ar, pg.program_name_ar,f.id qualifcation, f.qualifcation_name_ar, g.id major_category_id,g.major_category_name_ar ,
                        m.id qualification_major_id , m.qualification_major_name_ar,bridging,bridging_semester
                        from $db.academic_level v, $db.academic_program pg, $db.major_category g, $db.qualification_major m, $db.qualification f ,  $db.major_path t,$db.program_qualification pq
                        where pq.qualification_id = f.id and pq.qualification_major_id  =m.id and pq.major_path_id =t.id and pq.academic_level_id=v.id and pq.academic_program_id=pg.id 
                        and pg.academic_level_id=v.id and t.major_category_id=g.id
                        ";
                $result = AfwDatabase::db_recup_rows($query);
                
                $arr_pdf = array();
                

                foreach($result as $row){
                $arr_pdf[$row["academic_level_name_ar"]][$row["program_name_ar"]][$row["qualifcation_name_ar"]][$row["major_category_name_ar"]][] = array($row["qualification_major_name_ar"],$row["bridging"],$row["bridging_semester"]);
                }
                //die(var_dump($arr_pdf));
                $html_header = '<div style="background-color: rgb(46, 96, 102); padding: 10px 20px; font-family: Arial, sans-serif;">
                <table style="width: 100%; border-collapse: collapse; border: none;">
                        <tr>
                        <td style="width: 150px; border: none;">
                                <img width="150" src="https://frontend.bmeholding.com/images/logo.svg" alt="brand logo" />
                        </td>
                        <td style="vertical-align: middle; font-size: 18px; font-weight: bold; color: white; border: none;">
                                قائمة مسارات البرامج الاكاديمية
                        </td>
                        <td style="text-align:left;vertical-align: middle; font-size: 14px; font-weight: bold; color: white; border: none;">'.date('Y/m/d').'</td>
                        </tr>
                </table>
                </div>';
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

                        foreach($majors as $AcademicLevel => $programList) {
                                $list .= '<li>';
                                $list .= '<h3 style="margin-top:20px; font-size:18px;">' . htmlspecialchars($AcademicLevel) . '</h3>';
                                $list .= '<ul class="majors-list">';
                                foreach($programList as $program => $majorsList) {
                                        $list .= '<li>';
                                        $list .= '<h3 style="margin-top:20px; font-size:18px;">' . htmlspecialchars($program) . '</h3>';
                                        $list .= '<ul class="majors-list">';
                                                
                                        foreach($majorsList as $Qualification => $QualificationList) {
                                                $list .= '<li>';
                                                $list .= '<h4 style="margin-top:20px; font-size:18px;">' . htmlspecialchars($Qualification) . '</h4>';
                                                // جدول التخصصات
                                                $list .= '
                                                        <table style="width:100%; border-collapse: collapse; margin-bottom:20px;">
                                                        <thead>
                                                                <tr style="background:#f2f2f2;">
                                                                <th style="border:1px solid #ccc; padding:8px;" width="50%">اسم التخصص</th>
                                                                <th style="border:1px solid #ccc; padding:8px;">مقررات تكميلية؟</th>
                                                                <th style="border:1px solid #ccc; padding:8px;">عدد فصول المقررات التكميلية</th>

                                                                </tr>
                                                        </thead>
                                                        <tbody>';
//die(var_dump($QualificationList));
                                                foreach ($QualificationList as $major) {
                                                        $extraValue = ($major[1]=='Y') ? 'نعم' : 'لا';
                                                        $list .= '
                                                        <tr>
                                                                <td style="border:1px solid #ccc; padding:8px;">' . htmlspecialchars($major[0]) . '</td>
                                                                <td style="border:1px solid #ccc; padding:8px;">' . htmlspecialchars($extraValue) . '</td>
                                                                <td style="border:1px solid #ccc; padding:8px;">' . htmlspecialchars($major[2]) . '</td>

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
