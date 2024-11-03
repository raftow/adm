<?php
/*
medali 24/09/2024
*/
        class ThirdParty extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "third_party"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("third_party","id","adm");
                        AdmThirdPartyAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ThirdParty();
                        
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