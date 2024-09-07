<?php
        class QualSource extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "qual_source"; 
                public static $DB_STRUCTURE = null;
                //public static $copypast = true;

                public function __construct(){
                        parent::__construct("qual_source","id","adm");
                        AdmQualSourceAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new QualSource();
                        
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

        }
?>