<?php
        class CheckType extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "check_type"; 
                public static $DB_STRUCTURE = null;
                
                public static $copypast = true;

                public function __construct(){
                        parent::__construct("check_type","id","adm");
                        AdmCheckTypeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new CheckType();
                        
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

        }
?>