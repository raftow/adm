<?php
    // create unique index uk_qualification_major_ar on c0adm.qualification_major(qualification_major_name_ar);
    // create unique index uk_qualification_major_en on c0adm.qualification_major(qualification_major_name_en);

    class QualificationMajor extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "qualification_major"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("qualification_major","id","adm");
                        AdmQualificationMajorAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new QualificationMajor();
                        
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

                public function beforeDelete($id,$id_replace) 
                {
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

                                        
                                // FK part of me - deletable 

                                
                                // FK not part of me - replaceable 
                                // adm.qual_major_path-Qualification Major	qualification_major_id  ManyToOne
                                        if(!$simul)
                                        {
                                                // require_once "../adm/qual_major_path.php";
                                                QualMajorPath::updateWhere(array('qualification_major_id'=>$id_replace), "qualification_major_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.qual_major_path set qualification_major_id='$id_replace' where qualification_major_id='$id' ");
                                        }
                                // adm.program_qualification-Major	qualification_major_id  ManyToOne
                                        if(!$simul)
                                        {
                                                // require_once "../adm/program_qualification.php";
                                                ProgramQualification::updateWhere(array('qualification_major_id'=>$id_replace), "qualification_major_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.program_qualification set qualification_major_id='$id_replace' where qualification_major_id='$id' ");
                                        }
                                // adm.applicant_qualification-Major	qualification_major_id  ManyToOne
                                        if(!$simul)
                                        {
                                                // require_once "../adm/applicant_qualification.php";
                                                ApplicantQualification::updateWhere(array('qualification_major_id'=>$id_replace), "qualification_major_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.applicant_qualification set qualification_major_id='$id_replace' where qualification_major_id='$id' ");
                                        }

                                        
                                
                                // MFK

                        }
                        else
                        {
                                        // FK on me 
                                // adm.qual_major_path-Qualification Major	qualification_major_id  ManyToOne
                                        if(!$simul)
                                        {
                                                // require_once "../adm/qual_major_path.php";
                                                QualMajorPath::updateWhere(array('qualification_major_id'=>$id_replace), "qualification_major_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.qual_major_path set qualification_major_id='$id_replace' where qualification_major_id='$id' ");
                                        }
                                // adm.program_qualification-Major	qualification_major_id  ManyToOne
                                        if(!$simul)
                                        {
                                                // require_once "../adm/program_qualification.php";
                                                ProgramQualification::updateWhere(array('qualification_major_id'=>$id_replace), "qualification_major_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.program_qualification set qualification_major_id='$id_replace' where qualification_major_id='$id' ");
                                        }
                                // adm.applicant_qualification-Major	qualification_major_id  ManyToOne
                                        if(!$simul)
                                        {
                                                // require_once "../adm/applicant_qualification.php";
                                                ApplicantQualification::updateWhere(array('qualification_major_id'=>$id_replace), "qualification_major_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.applicant_qualification set qualification_major_id='$id_replace' where qualification_major_id='$id' ");
                                        }

                                        
                                        // MFK

                                
                        } 
                        return true;
                }    
                }

        }
?>