<?php
        class ProgramTrack extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "program_track"; 
                public static $DB_STRUCTURE = null;
                
                
                public static $copypast = true;

                public function __construct(){
                        parent::__construct("program_track","id","adm");
                        AdmProgramTrackAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ProgramTrack();
                        
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