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
    public static function stepFields($application_model_id, $step_num)
    {
        $obj = new ApplicationModelField();
        $obj->select("application_model_id",$application_model_id);
        $obj->select("step_num",$step_num);
        $amfList = $obj->loadMany('',"screen_model_id, step_num, api_endpoint_id");
        $data = [];
        $scrObjArr = []; 

        foreach($amfList as $amfObj)
        {
            $afieldObj = $amfObj->het("application_field_id"); 
            if($afieldObj)
            {
                $scr_id = $amfObj->getVal("screen_model_id");
                if(!$scrObjArr[$scr_id]) $scrObjArr[$scr_id] = $amfObj->het("screen_model_id");
                $data["screen-$scr_id"]["name_ar"] = "??";
                $data["screen-$scr_id"]["name_en"] = "screen-not-found";
                if($scrObjArr[$scr_id])
                {
                    $data["screen-$scr_id"]["name_ar"] = $scrObjArr[$scr_id]->getDisplay("ar");
                    $data["screen-$scr_id"]["name_en"] = $scrObjArr[$scr_id]->getDisplay("en");
                }

                $field_name = $afieldObj->getVal("field_name");
                $application_table_id = $afieldObj->getVal("application_table_id");
                $application_table_code = self::code_of_application_table_id($application_table_id);
                $application_field_type_enum = $afieldObj->getVal("application_field_type_id");
                $afield_type_code = self::field_type_code($application_field_type_enum);
                $need_decode = self::need_decode($application_field_type_enum);
                $field_title_ar = $afieldObj->getVal("field_title_ar");
                $field_title_en = $afieldObj->getVal("field_title_en");
                $reel = $afieldObj->sureIs("reel");
                $additional = $afieldObj->sureIs("additional");
                 	  
                

                $data["screen-$scr_id"]["fields"][$afieldObj->id] = ['field' => $field_name, 'additional'=>$additional, 'reel'=>$reel, 'type'=>$afield_type_code, 'need_decode'=>$need_decode, 'table'=>$application_table_code, 'title_ar'=>$field_title_ar, 'title_en'=>$field_title_en];
            }
            
        }

        return $data;
        
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
