<?php

        class ApplicationModelEngagement extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_model_engagement"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_model_engagement","id","adm");
                        AdmApplicationModelEngagementAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationModelEngagement();
                        
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