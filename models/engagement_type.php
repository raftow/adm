<?php
// medali 15/09/2024
        class EngagementType extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "engagement_type"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("engagement_type","id","adm");
                        AdmEngagementTypeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new EngagementType();
                        
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