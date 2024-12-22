<?php
        class SponsorType extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "sponsor_type"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("sponsor_type","id","adm");
                        AdmSponsorTypeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new SponsorType();
                        
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
