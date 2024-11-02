<?php
        class AppmodelFintran extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "appmodel_fintran"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("appmodel_fintran","id","adm");
                        AdmAppmodelFintranAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AppmodelFintran();
                        
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