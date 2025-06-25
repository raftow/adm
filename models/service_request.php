<?php
        class ServiceRequest extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "service_request"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("service_request","id","adm");
                        AdmServiceRequestAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ServiceRequest();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang = 'ar')
                {
                        return $this->getDefaultDisplay($lang);
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

                public function beforeMaj($id, $fields_updated)
                {
                        if($fields_updated["request_status"])      
                        {
                                $this->set("status_date", "now()");
                               
                        }
                        

                        return true;
                }

                public function calcApplicantIdLink($what = "value")
                {
                        $app_id = $this->getVal("applicant_id");
                        
                        if($app_id)
                        {
                                return "<a href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&id=".$app_id."'>المتقدم</a>";
                        }else{
                                return "بدون حساب".$app_id;
                        }
                }
                public function calcapplicantFileIdLink($what = "value")
                {
                        if($this->getVal("applicant_file_id"))
                        {
                                $obj = ApplicantFile::loadById($this->applicant_file_id);
                                return "<a href='https://objectstorage.me-jeddah-1.oraclecloud.com/p/RMGCewYtsTMiZBX2x_Tl6BkeE_qN7LER9Ls6QFkAkPWtTneKg159OcuLlx8i_ueQ/n/axrrw2c1zxeb/b/admission_dev/o/".$obj->name_ar."'>".$obj->name_ar." الملف المرفق</a>";
                        
                        }else{
                                return "لا مرفقات";
                        }
                       
                }

        }
?>