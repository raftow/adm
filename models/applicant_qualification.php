<?php
        /*
             RB 19/9/2024 :
             create unique index uk_applicant_qualification on c0adm.applicant_qualification(applicant_id,qualification_id,major_category_id);
        */
        class ApplicantQualification extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "applicant_qualification"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("applicant_qualification","id","adm");
                        AdmApplicantQualificationAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicantQualification();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang="ar")
                {
                       
                       $data = array();
                       $link = array();
        
                       list($data[0],$link[0]) = $this->displayAttribute("qualification_id",false, $lang);
                       list($data[1],$link[1]) = $this->displayAttribute("qualification_major_id",false, $lang);
        
                       
                       return implode(" - ",$data);
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

                public function beforeMaj($id, $fields_updated)
                {

                        if ($fields_updated["qualification_id"] or $fields_updated["major_category_id"]) {

                                $objMajorPath = MajorPath::loadByMainIndex($this->getVal("qualification_id"),$this->getVal("major_category_id"));

                                if ($objMajorPath) {
                                        $this->set("major_path_id", $objMajorPath->id);
                                }
                        }

                        return true;
                }

                public function afterInsert($id, $fields_updated)
                {                        
                        if($fields_updated["qualification_id"])
                        {
                                /**
                                 * @var Applicant $applicantObject
                                 */
                                $applicantObject = $this->get("applicant_id"); 
                                $applicantObject->updateQualificationLevelFields();                                
                        }
                }

                public function afterDelete($id, $id_replace)
                {                        
                        $applicantObject = $this->get("applicant_id"); 
                        $applicantObject->updateQualificationLevelFields();                                
                }


                public function shouldBeCalculatedField($attribute){
                        if($attribute=="level_enum") return true;
                        return false;
                }


                public function beforeDelete($id,$id_replace) 
                {
                        global $lang;

                        $server_db_prefix = AfwSession::config("db_prefix","c0");
                        
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
                                        // adm.application-مؤهل التقديم	applicant_qualification_id  ManyToOne (required field)
                                        // require_once "../adm/application.php";
                                        $obj = new Application();
                                        $obj->where("applicant_qualification_id = '$id' and active='Y' ");
                                        $nbRecords = $obj->count();
                                        // check if there's no record that block the delete operation
                                        if($nbRecords>0)
                                        {
                                                $this->deleteNotAllowedReason = self::tm("used in some applications as applicant qualification",$lang);
                                                return false;
                                        }
                                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                                        if(!$simul) $obj->deleteWhere("applicant_qualification_id = '$id' and active='N'");


                                        
                                        // FK part of me - deletable 

                                        
                                        // FK not part of me - replaceable 
                                        // adm.application-مؤهل التقديم	applicant_qualification_id  ManyToOne
                                        if(!$simul)
                                        {
                                                // require_once "../adm/application.php";
                                                Application::updateWhere(array('applicant_qualification_id'=>$id_replace), "applicant_qualification_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.application set applicant_qualification_id='$id_replace' where applicant_qualification_id='$id' ");
                                        }

                                        // MFK

                                }
                                else
                                {
                                        // FK on me 
                

                                        // adm.application-مؤهل التقديم	applicant_qualification_id  ManyToOne (required field)
                                        if(!$simul)
                                        {
                                                // require_once "../adm/application.php";
                                                Application::updateWhere(array('applicant_qualification_id'=>$id_replace), "applicant_qualification_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.application set applicant_qualification_id='$id_replace' where applicant_qualification_id='$id' ");
                                        
                                        } 
                                        

                                        // adm.application-مؤهل التقديم	applicant_qualification_id  ManyToOne
                                        if(!$simul)
                                        {
                                                // require_once "../adm/application.php";
                                                Application::updateWhere(array('applicant_qualification_id'=>$id_replace), "applicant_qualification_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.application set applicant_qualification_id='$id_replace' where applicant_qualification_id='$id' ");
                                        }

                                        
                                        // MFK

                                        
                                } 
                                return true;
                        }    
                }                  

        }
