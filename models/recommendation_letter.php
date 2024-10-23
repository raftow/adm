<?php
        class RecommendationLetter extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "recommendation_letter"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("recommendation_letter","id","adm");
                        AdmRecommendationLetterAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new RecommendationLetter();
                        
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
