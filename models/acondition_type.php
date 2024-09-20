<?php
        class AconditionType extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "acondition_type"; 
                public static $DB_STRUCTURE = null;

                public function __construct(){
                        parent::__construct("acondition_type","id","adm");
                        AdmAconditionTypeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AconditionType();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                // acondition_type 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 377;
      if ($currstep == 2) return 378;

      return 0;
   }

        }
?>