<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class ApplicationCvScore extends AFWObject{

        public static $MY_ATABLE_ID=14031; 
  
        public static $DATABASE		= "nauss_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "application_cv_score";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("application_cv_score","id","adm");
            AdmApplicationCvScoreAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new ApplicationCvScore();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        

        public function getScenarioItemId($currstep)
                {
                    
                    return 0;
                }
        
        public static function loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id,$create_obj_if_not_found=false)
        {
           if(!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
           if(!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
           if(!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");


           $obj = new ApplicationCvScore();
           $obj->select("applicant_id",$applicant_id);
           $obj->select("application_plan_id",$application_plan_id);
           $obj->select("application_simulation_id",$application_simulation_id);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("applicant_id",$applicant_id);
                $obj->set("application_plan_id",$application_plan_id);
                $obj->set("application_simulation_id",$application_simulation_id);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }
        
        public function getDisplay($lang="ar")
        {
               
        }
        
        
        

        
        protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
        {
             $lang = AfwLanguageHelper::getGlobalLanguage();
             // $objme = AfwSession::getUserConnected();
             // $me = ($objme) ? $objme->id : 0;

             $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             
             
             // check errors on all steps (by default no for optimization)
             // rafik don't know why this : \//  = false;
             
             return $otherLinksArray;
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_en = "Print CV";
            $title_ar = "طباعة السيرة الذاتية";
            $methodName = "printCvPdf";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                    "METHOD" => $methodName,
                    "COLOR" => $color,
                    "LABEL_AR" => $title_ar,
                    "LABEL_EN" => $title_en,
                    "PUBLIC" => true,
                    "BF-ID" => "",
                    'STEPS' => 'all'
            );

            
            
            return $pbms;
        }
        
        public function fld_CREATION_USER_ID()
        {
                return "created_by";
        }

        public function fld_CREATION_DATE()
        {
                return "created_at";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return "updated_by";
        }

        public function fld_UPDATE_DATE()
        {
        	return "updated_at";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return "validated_by";
        }

        public function fld_VALIDATION_DATE()
        {
                return "validated_at";
        }
        
        public function fld_VERSION()
        {
        	return "version";
        }

        public function fld_ACTIVE()
        {
        	return  "active";
        }
        
        /*
        public function isTechField($attribute) {
            return (($attribute=="created_by") or 
                    ($attribute=="created_at") or 
                    ($attribute=="updated_by") or 
                    ($attribute=="updated_at") or 
                    // ($attribute=="validated_by") or ($attribute=="validated_at") or 
                    ($attribute=="version"));  
        }*/
        
        
        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","nauss_");
            
            if(!$id)
            {
                $id = $this->getId();
                $simul = true;
            }
            else
            {
                $simul = false;
            }
            
            if($id)
            {   
               if($id_replace==0)
               {
                   // FK part of me - not deletable 

                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}

    public function afterMaj($id, $fields_updated)
    {
        	
        if ($fields_updated["score_QUAL"]) {
            
            $this->set("review_date_QUAL", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_PEXP"]) {
            
            $this->set("review_date_PEXP", date("Y-m-d H:i:s"));    
        }
        if ($fields_updated["score_CRWQ"]) {
            
            $this->set("review_date_CRWQ", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_SCINT"]) {
            
            $this->set("review_date_SCINT", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_VOLAC"]) {
            
            $this->set("review_date_VOLAC", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_AWAP"]) {
            
            $this->set("review_date_AWAP", date("Y-m-d H:i:s"));
        }
        if ($fields_updated["score_SCRSC"]) {
            
            $this->set("review_date_SCRSC", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_LANGP"]) {
            
            $this->set("review_date_LANGP", date("Y-m-d H:i:s"));
        }
        if ($fields_updated["score_SCCONF"]) {
            
            $this->set("review_date_SCCONF", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_RECLT"]) {
            
            $this->set("review_date_RECLT", date("Y-m-d H:i:s"));
        }
        // update total score
        $cvRubricObj = new CvRubric();
        $cvRubricObj->where("active='Y'");
        $objList = $cvRubricObj->loadMany();

        foreach ($objList as $objItem) {
            $rubricItemObj = $objItem->het("cv_rubric_item_id");
            $weight = $objItem->getVal("weight");

            $rubricItemCode = $rubricItemObj->getVal("lookup_code");
            $total += floatval($this->getVal("score_".$rubricItemCode)) * floatval($weight)/100;
                // $objItem->genereApplicationModelBranchList($lang);                                
        }
        $this->set("total_score",  $total);
        $this->commit();
    }

    public function printCvPdf(){
        
        $id = $this->id;
        require __DIR__ . '/../../lib/vendor/autoload.php';

        $applicantObj = $this->het("applicant_id");
        $applicant_id = $this->getVal("id");
        $applicationObj = new Application();
        $applicationObj->where("application_plan_id = '".$this->getVal("application_plan_id")."' and applicant_id = '".$applicant_id."' and active='Y' ");
        $applicationObj->load();
        $applicant_id = $applicantObj->getVal("id");
        // applicant language
        $applicantLanguageObj = new ApplicantLanguageProficiency();
        $applicantLanguageObj->select("applicant_id",$applicant_id);
        $applicantLanguageObj->select("active","Y");
        $applicantLanguageObjList = $applicantLanguageObj->loadMany();
        // applicant professional experience
        $applicantProfessionalExperienceObj = new ApplicantProfessionalExperience();
        $applicantProfessionalExperienceObj->select("applicant_id",$applicant_id);
        $applicantProfessionalExperienceObj->select("active","Y");
        $applicantProfessionalExperienceObjList = $applicantProfessionalExperienceObj->loadMany();
        $ApplicantQualificationObj = new ApplicantQualification();
        $ApplicantQualificationObj->select("applicant_id",$applicant_id);
        $ApplicantQualificationObj->select("active","Y");
        $ApplicantQualificationObj->load();
        
        $ApplicantScientificConference = new ApplicantScientificConference();
        $ApplicantScientificConference->select("applicant_id",$applicant_id);
        $ApplicantScientificConference->select("active","Y");
        $ApplicantScientificConferenceList = $ApplicantScientificConference->loadMany();
        
        $ApplicantCourses = new ApplicantCourses();
        $ApplicantCourses->select("applicant_id",$applicant_id);
        $ApplicantCourses->select("active","Y");
        $ApplicantCoursesList = $ApplicantCourses->loadMany();
        
        $ApplicantCourses = new ApplicantCourses();
        $ApplicantCourses->select("applicant_id",$applicant_id);
        $ApplicantCourses->select("active","Y");
        $ApplicantCoursesList = $ApplicantCourses->loadMany();
        
        $ApplicantCertificationAppreciation = new ApplicantCertificationAppreciation();
        $ApplicantCertificationAppreciation->select("applicant_id",$applicant_id);
        $ApplicantCertificationAppreciation->select("active","Y");
        $ApplicantCertificationAppreciationList = $ApplicantCertificationAppreciation->loadMany();
        
        $ApplicantVolunteerActivity = new ApplicantVolunteerActivity();
        $ApplicantVolunteerActivity->select("applicant_id",$applicant_id);
        $ApplicantVolunteerActivity->select("active","Y");
        $ApplicantVolunteerActivityList = $ApplicantVolunteerActivity->loadMany();
        
        $ApplicantScientificResearch = new ApplicantScientificResearch();
        $ApplicantScientificResearch->select("applicant_id",$applicant_id);
        $ApplicantScientificResearch->select("active","Y");
        $ApplicantScientificResearchList = $ApplicantScientificResearch->loadMany();

        $cvRubricGuideObj = new CvRubricGuide();
        $cvRubricGuideObj->select("active","Y");
        $cvRubricGuideObjList = $cvRubricGuideObj->loadMany();
        $cv_score_guide = [];
        foreach ($cvRubricGuideObjList as $item) {
            $cv_score_guide[$item->getVal('cv_rubric_item_id')][] = $item;
        }
        //die(var_dump($cv_score_guide[2]));
        // Create mPDF instance with Arabic support
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 70,
            'margin_bottom' => 5,
            'margin_header' => 10,
            'margin_footer' => 10,
            'direction' => 'rtl'
        ]);

        // CSS Styling
        $css = <<<CSS
        body {
            font-family: 'dejavusans','DejaVu Sans', sans-serif;
            font-size: 9pt;
            direction: rtl;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .section-title {
            background-color: #d9d9d9;
            font-weight: bold;
            padding: 10px;
            margin-top: 15px;
            margin-bottom: 10px;
            text-align: center;
        }
        .evaluation-row {
            background-color: #f9f9f9;
        }
        .checkbox {
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            display: inline-block;
            margin: 0 5px;
        }
        .total-score {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            border: 2px solid #000;
        }
        CSS;
        $header_page = '
                <div class="header">
                
                    <div style="text-align: center; margin-bottom: 5px;">
                        <img src="../../client-nauss/pic/logo-cover-nauss.jfif" style="width: 100%; height: auto;">
                    </div>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td style="width: 25%; text-align: right; border: none;" dir="rtl">
                                تاريخ '.date('d/m/Y').'<br>
                                الصفحة {PAGENO}/{nbpg}
                            </td>
                            <td style="width: 50%; text-align: center; border: none; font-weight: bold; font-size: 12pt;">
                                تقييم معايير التقييم المتدرج لطلب القبول
                            </td>
                            <td style="width: 25%; text-align: left; border: none;" dir="ltr">
                                Date: '.date('d/m/Y').'<br>
                                Page: {PAGENO}/{nbpg}
                            </td>
                        </tr>
                    </table>
                    
                    <div style="clear: both;"></div>
                </div>';
        // HTML Content - Page 1
        $mpdf->SetHTMLHeader($header_page);
        $html .= '<table>
            <tr>
                <td colspan="2">المتقدم: '.$applicantObj->getVal("first_name_ar").' '.$applicantObj->getVal("second_name_ar").' '.$applicantObj->getVal("third_name_ar").' '.$applicantObj->getVal("last_name_ar").'</td>
                <td>الميلاد:'.$applicantObj->getVal("birth_date").'</td>
                <td >الجنسية:'.$applicantObj->het("country_id")->getVal("country_name_ar").'</td>
            </tr>
            <tr>
                <td>المؤهل: '.$ApplicantQualificationObj->het("qualification_id")->getVal("qualifcation_name_ar").'</td>
                <td>التخصص:'.$ApplicantQualificationObj->het("major_category_id")->getVal("major_category_name_ar").'</td>
                <td colspan="2">التخصص الدقيق:'.$ApplicantQualificationObj->het("qualification_major_id")->getVal("qualification_major_name_ar").'</td>
            </tr>
            <tr>
                <td>الجامعة:'.$ApplicantQualificationObj->getVal("source_name").'</td>
                <td>سنة التخرج:'.$ApplicantQualificationObj->getVal("date").'</td>
                <td>الدولة:'.$ApplicantQualificationObj->het("country_id")->getVal("country_name_ar").'</td>
                <td>نوع الدراسة:'.$ApplicantQualificationObj->het("study_type_id")->getVal("name_ar").'</td>
            </tr>
            <tr>
                <td>التقدير:'.$ApplicantQualificationObj->het("grading_scale_id")->getVal("value_ar").'</td>
                <td>المعدل التراكمي:'.$ApplicantQualificationObj->getVal("gpa").'</td>
                <td colspan="2">نوع المعدل:'.$ApplicantQualificationObj->getVal("gpa_from").'</td>
            </tr>
        </table>';
        $html .= '<div class="section-title">الخبرات العملية إن وجدت</div>
        <table>
            
            <tr>
                <td>عدد سنوات الخبرة</td>
                <td>جهة العمل</td>
                <td>مسمى الوظيفة</td>

            </tr>';
        if (count($applicantProfessionalExperienceObjList) > 0) {
        
            foreach($applicantProfessionalExperienceObjList as $row_prof){

                $html .= '
                    <tr>
                        <td >'.$row_prof->getVal("job_duration").'</td>
                        <td>'.$row_prof->getVal("employer").'</td>
                        <td >'.$row_prof->getVal("job_title_ar").'</td>
                    </tr>';

            }
        }
        
        $html .= '</table>';
    $html .= $this->getCommitteeEvaluationHtml($cv_score_guide[2],'تقييم اللجنة للوظيفة');
        
 
        

    $html .= '<div class="section-title">اللغات</div>

        <table>
            <tr>
                <th style="text-align: center;" colspan="2">إجادة لغة أخرى غير العربية:</th>
            </tr>
            <tr>
                <td style="text-align: center;text-decoration: bold;">اللغة:</td>
                <td style="text-align: center;text-decoration: bold;">مستوى الإجادة:</td>
            </tr>';
            if (count($applicantLanguageObjList) > 0) {
                foreach($applicantLanguageObjList as $row_lang){
                    $html .= '
                        <tr>
                            <td style="text-align: center;">'.$row_lang->het("language_id")->getVal("name_ar").'</td>
                            <td style="text-align: center;">'.$row_lang->het("proficiency_level_id")->getVal("name_ar").'</td>
                        </tr>';
                } 
            }

        $html .= '</table>';
        $html .= $this->getCommitteeEvaluationHtml($cv_score_guide[8],'تقييم اللجنة للغات الأجنبية');

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // Page 2
        //$mpdf->AddPage();

        $html2 = '
        <div class="section-title">المؤهلات العلمية</div>

        <table>
            <tr>
                <th>مسمى المؤهل: '.$ApplicantQualificationObj->het("qualification_id")->getVal("qualifcation_name_ar").'</th>
                <td>التخصص:'.$ApplicantQualificationObj->het("major_category_id")->getVal("major_category_name_ar").'</td>
                <td colspan="2">التخصص الدقيق:'.$ApplicantQualificationObj->het("qualification_major_id")->getVal("qualification_major_name_ar").'</td>
            </tr>
            <tr>
                <td>الجامعة:'.$ApplicantQualificationObj->getVal("source_name").'</td>
                <td>سنة التخرج:'.$ApplicantQualificationObj->getVal("date").'</td>
                <td>الدولة:'.$ApplicantQualificationObj->het("country_id")->getVal("country_name_ar").'</td>
                <td>نوع الدراسة:'.$ApplicantQualificationObj->het("study_type_id")->getVal("name_ar").'</td>
            </tr>
            <tr>
                <td>التقدير:'.$ApplicantQualificationObj->het("grading_scale_id")->getVal("value_ar").'</td>
                <td>المعدل التراكمي:'.$ApplicantQualificationObj->getVal("gpa").'</td>
                <td colspan="2">نوع المعدل:'.$ApplicantQualificationObj->getVal("gpa_from").'</td>
            </tr>
        </table>';
        $html2 .= $this->getCommitteeEvaluationHtml($cv_score_guide[1],'تقييم اللجنة المؤهلات العلمية');
        $html2 .= '
        <div class="section-title">حضور المؤتمرات العلمية في التخصص</div>

        <table>
            <tr>
                <th>عنوان المؤتمر</th>
                <td>الجهة</td>
                <td>العام</td>
            </tr>';
            foreach($ApplicantScientificConferenceList as $applicantScientificConference){
                $html2 .= '<tr>';
                $html2 .= '<td style="text-align: center;">'.$applicantScientificConference->getVal("event_name_ar").'</td>';
                $html2 .= '<td style="text-align: center;">'.$applicantScientificConference->getVal("event_topic").'</td>';
                $html2 .= '<td style="text-align: center;">'.$applicantScientificConference->getVal("event_date").'</td>';
                $html2 .= '</tr>';
            }
            $html2 .= '
        
        </table>';
        $html2 .= $this->getCommitteeEvaluationHtml($cv_score_guide[9],'تقييم اللجنة المؤتمرات العلمية');

        $mpdf->WriteHTML($html2, \Mpdf\HTMLParserMode::HTML_BODY);

        // Page 3
        //$mpdf->AddPage();

        //$html3 = $header_page;
        $html3 .= '
        <div class="section-title">الدورات التدريبية وورش العمل</div>

        <table>
            <tr>
                <th>عنوان الدورة - الورشة</th>
                <td>الجهة</td>
                <td>العام</td>
            </tr>';
         foreach($ApplicantCoursesList as $applicantCourse){
                $html3 .= '<tr>';
                $html3 .= '<td style="text-align: center;">'.$applicantCourse->getVal("course_title").'</td>';
                $html3 .= '<td style="text-align: center;">'.$applicantCourse->getVal("course_provider").'</td>';
                $html3 .= '<td style="text-align: center;">'.$applicantCourse->getVal("course_date").'</td>';
                $html3 .= '</tr>';
            }   
        
        $html3 .='</table>';
        $html3 .= $this->getCommitteeEvaluationHtml($cv_score_guide[3],'تقييم اللجنة الدورات التدريبية وورش العمل');
        $html3 .='
        <div class="section-title">عضوية المؤسسات والجمعيات العلمية</div>

        <table>
            <tr>
                <th>الجهة:</th>
                <td>الدولة:</td>
                <td>تاريخ العضوية:</td>
            </tr>
            
        </table>';
        $html3 .= $this->getCommitteeEvaluationHtml($cv_score_guide[4],'تقييم اللجنة عضوية المؤسسات والجمعيات العلمية');
        $html3 .='
        <div class="section-title">أبرز الأنشطة التطوعية وخدمة المجتمع</div>

        <table>';
        foreach($ApplicantVolunteerActivityList as $applicantVolunteerActivity){
            $html3 .= '<tr>';
            $html3 .= '<td style="text-align: center;">'.$applicantVolunteerActivity->getVal("role_held").'</td>';
            $html3 .= '</tr>';
        }
        $html3 .='</table>';
        $html3 .= $this->getCommitteeEvaluationHtml($cv_score_guide[5],'تقييم اللجنة الأنشطة التطوعية وخدمة المجتمع');

        $mpdf->WriteHTML($html3, \Mpdf\HTMLParserMode::HTML_BODY);

        // Page 4
        //$mpdf->AddPage();
        //$html4 = $header_page;

        $html4 .= '
        <div class="section-title">شهادات الشكر والتقدير</div>

        <table>
            <tr>
                <th>الشهادة</th>
                <td>الجهة المانحة</td>
                <td>التاريخ</td>
            </tr>';
        foreach($ApplicantCertificationAppreciationList as $ApplicantCertification){
            $html4 .= '<tr>';
            $html4 .= '<td style="text-align: center;">'.$ApplicantCertification->getVal("certification_name").'</td>';
            $html4 .= '<td style="text-align: center;">'.$ApplicantCertification->getVal("certification_issuer").'</td>';
            $html4 .= '<td style="text-align: center;">'.$ApplicantCertification->getVal("certification_year").'</td>';
            $html4 .= '</tr>';
        }    
        $html4 .='</table>';
        $html4 .= $this->getCommitteeEvaluationHtml($cv_score_guide[6],'تقييم اللجنة الشهادات الشكر والتقدير');
        
        /*$html4 .='<div class="section-title">الجوائز الحائز عليها</div>

        <table>
            <tr>
                <th>مسمى الجائزة:</th>
                <td>الجهة المانحة:</td>
                <td>العام:</td>
            </tr>
            <tr>
                <th>مسمى الجائزة:</th>
                <td>الجهة المانحة:</td>
                <td>العام:</td>
            </tr>
        </table>

        <table>
            <tr class="evaluation-row">
                <th colspan="5">تقييم الجوائز الحائز عليها</th>
            </tr>';
            foreach($cv_score_guide[6] as $row_guide){
                $html4 .= '<tr>';
                $html4 .= '<td style="text-align: center;">'.$row_guide->getVal("rubric_score").'</td>';
                $html4 .= '<td style="text-align: center;">'.$row_guide->getVal("rubric_desc").'</td>';
                $html4 .= '<td style="text-align: center;">'.$row_guide->getVal("score_explanation").'</td>';
                $html4 .= '</tr>';
               
            }

            $html4 .='</table>';*/

        $html4 .='<div class="section-title">النشر العلمي والأبحاث</div>

        <table>
            <tr>
                <th>عنوان البحث</th>
                <th>المجلة</th>
                <th>العام</th>
            </tr>';
           foreach($ApplicantScientificResearchList as $ApplicantScientificResearch){
            $html4 .= '<tr>';
            $html4 .= '<td style="text-align: center;">'.$ApplicantScientificResearch->getVal("title").'</td>';
            $html4 .= '<td style="text-align: center;">'.$ApplicantScientificResearch->getVal("publication_venue").'</td>';
            $html4 .= '<td style="text-align: center;">'.$ApplicantScientificResearch->getVal("publication_date").'</td>';
            $html4 .= '</tr>';
           }
        $html4 .='</table>';
        $html4 .= $this->getCommitteeEvaluationHtml($cv_score_guide[7],'تقييم اللجنة النشر العلمي والأبحاث');
        $html4 .= '<br>
        <div class="total-score">
            مجموع درجات معايير التقييم المتدرج للسيرة الذاتية<br>
            من 80
        </div>
        ';

        $mpdf->WriteHTML($html4, \Mpdf\HTMLParserMode::HTML_BODY);

        // Page 5
        //$mpdf->AddPage();

        //$html5 = $header_page;

        $html5 .= '
        <div class="section-title">تقييم المقابلة الشخصية</div>

        <table>
            <tr>
                <th colspan="4" style="padding: 40px; text-align: center; font-size: 12pt;">
                    تقييم المقابلة الشخصية من 100
                </th>
            </tr>
            <tr>
                <td style="padding: 30px;"></td>
                <td style="padding: 30px;"></td>
                <td style="padding: 30px;"></td>
                <td style="padding: 30px;"></td>
            </tr>
        </table>
        ';

        $mpdf->WriteHTML($html5, \Mpdf\HTMLParserMode::HTML_BODY);

        // Output PDF
        $mpdf->Output('CV_Evaluation_Form.pdf', 'I'); // 'I' for inline display, 'D' for download


    }
    public function getCommitteeEvaluationHtml($cv_score_guide_items,$title)
    {
        $html = '<div style="width:100%;">
            <div style="float: right; width:60%;">
                <table>
                    <tr class="evaluation-row" style="background-color: #f9f9f9;">
                        <th colspan="2">'.$title.'</th>
                    </tr>';
        foreach ($cv_score_guide_items as $row_guide) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . $row_guide->getVal("rubric_score") . '</td>';
            $html .= '<td style="text-align: center;">' . $row_guide->getVal("rubric_desc") . '</td>';
            $html .= '</tr>';
        }
            $html .= '</table>
            </div>
            <div style="float: left; width:40%; text-align: center;">
                <div style="width: 140px; height: 70px; border: 2px solid #000; margin: 0 auto; text-align: center; line-height: 70px; font-size: 18px; font-weight: bold;">
                    &nbsp;
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>';
        return $html;
    }         
}

