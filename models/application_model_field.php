<?php
class ApplicationModelField extends AdmObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "adm";
    public static $TABLE            = "application_model_field";
    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    private static $matrixApplicationModelField = [];

    public function __construct()
    {
        parent::__construct("application_model_field", "id", "adm");
        AdmApplicationModelFieldAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new ApplicationModelField();

        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($application_model_id, $application_field_id, $acondition_id=0, $duration_expiry=0, $create_obj_if_not_found = false)
    {
        if (!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
        if (!$application_field_id) throw new AfwRuntimeException("loadByMainIndex : application_field_id is mandatory field");

        if(self::$matrixApplicationModelField["am$application_model_id-af$application_field_id"])
        {
            if(self::$matrixApplicationModelField["am$application_model_id-af$application_field_id"]=="NOT-FOUND")
            {
                return null;
            }
            return self::$matrixApplicationModelField["am$application_model_id-af$application_field_id"];
        }
        $obj = new ApplicationModelField();
        $obj->select("application_model_id", $application_model_id);
        $obj->select("application_field_id", $application_field_id);

        if ($obj->load()) 
        {
            
            if ($create_obj_if_not_found) 
            {
                if($acondition_id) $obj->set("acondition_id", $acondition_id);
                if($duration_expiry) $obj->set("duration_expiry", $duration_expiry);
                
                $obj->activate();
            }
        } 
        elseif ($create_obj_if_not_found) 
        {
            $obj->set("application_model_id", $application_model_id);
            $obj->set("application_field_id", $application_field_id);
            if($acondition_id) $obj->set("acondition_id", $acondition_id);
            if($duration_expiry) $obj->set("duration_expiry", $duration_expiry);
            $obj->insertNew();
            if (!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
        } else $obj = null;

        if($obj)
        {
            self::$matrixApplicationModelField["am$application_model_id-af$application_field_id"]=$obj;
        }
        else
        {
            self::$matrixApplicationModelField["am$application_model_id-af$application_field_id"]="NOT-FOUND";
        }

        return $obj;
    }

    public function getDisplay($lang = 'ar')
    {
        return $this->getDefaultDisplay($lang);
    }

    public function stepsAreOrdered()
    {
        return false;
    }

    public function rowCategoryAttribute()
    {
        return 'step_num';
    }

    

    public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","default_db_");
            
            if(!$id)
            {
                $id = $this->getId();
                $simul = true;
            }
            else
            {
                $simul = false;
            }
            
            if($id)
            {   
               if($id_replace==0)
               {
                   // FK part of me - not deletable 

                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
}
