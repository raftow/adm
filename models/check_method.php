<?php
        class CheckMethod extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "check_method"; 
                public static $DB_STRUCTURE = null;
                
                public static $copypast = true;

                public function __construct(){
                        parent::__construct("check_method","id","adm");
                        AdmCheckMethodAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new CheckMethod();
                        
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