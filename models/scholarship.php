<?php
        class Scholarship extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "scholarship"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("scholarship","id","adm");
                        AdmScholarshipAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Scholarship();
                        
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

                protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
                {
                        $lang = AfwLanguageHelper::getGlobalLanguage();
                        // $objme = AfwSession::getUserConnected();
                        // $me = ($objme) ? $objme->id : 0;

                        $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                        $my_id = $this->getId();
                        $displ = $this->getDisplay($lang);
                        
                        

                        if($mode=="mode_ApplicantScholarshipList")
                        {
                                unset($link);
                                $link = array();
                                $title = "إضافة مستفيد";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicantScholarship&currmod=adm&sel_scholarship_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["PUBLIC"] = true;
                                $otherLinksArray[] = $link;
                        }
                        
                        
                        
                        // check errors on all steps (by default no for optimization)
                        // rafik don't know why this : \//  = false;
                        
                        return $otherLinksArray;
                }

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
                       // adm.applicant_scholarship-المنحة	scholarship_id  حقل يفلتر به (required field)
                        // require_once "../adm/applicant_scholarship.php";
                        $obj = new ApplicantScholarship();
                        $obj->where("scholarship_id = '$id' and active='Y' ");
                        $nbRecords = $obj->count();
                        // check if there's no record that block the delete operation
                        if($nbRecords>0)
                        {
                            $this->deleteNotAllowedReason = "Used in some Applicant scholarships(s) as Scholarship";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!$simul) $obj->deleteWhere("scholarship_id = '$id' and active='N'");


                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
 

                        // adm.applicant_scholarship-المنحة	scholarship_id  حقل يفلتر به (required field)
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_scholarship.php";
                            ApplicantScholarship::updateWhere(array('scholarship_id'=>$id_replace), "scholarship_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.applicant_scholarship set scholarship_id='$id_replace' where scholarship_id='$id' ");
                            
                        } 
                        


                        
                        // MFK

                   
               } 
               return true;
            }    
	} 

}
?>