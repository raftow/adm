<?php

global $enum_tables, $lookup_tables, $count_here;

class ApplicationField extends AdmObject
{

     public function __construct()
     {
          parent::__construct("application_field", "id", "adm");
          AdmApplicationFieldAfwStructure::initInstance($this);
     }




     public static $enum_tables;

     public static $lookup_tables;

     public static $DATABASE          = "";
     public static $MODULE              = "adm";
     public static $TABLE               = "";
     public static $DB_STRUCTURE = null;




     public static function loadById($id)
     {
          $obj = new ApplicationField();
          $obj->select_visibilite_horizontale();
          if ($obj->load($id)) {
               return $obj;
          } else return null;
     }



     public static function loadByMainIndex($field_name, $application_table_id, $create_obj_if_not_found = false)
     {


          $obj = new ApplicationField();
          $obj->select("field_name", $field_name);
          $obj->select("application_table_id", $application_table_id);

          if ($obj->load()) {
               if ($create_obj_if_not_found) $obj->activate();
               return $obj;
          } elseif ($create_obj_if_not_found) {
               $obj->set("field_name", $field_name);
               $obj->set("application_table_id", $application_table_id);

               $obj->insertNew();
               if (!$obj->id) return null; // means beforeInsert rejected insert operation
               $obj->is_new = true;
               return $obj;
          } else return null;
     }


     public function getDisplay($lang = "ar")
     {
          if ($this->getVal("field_title_$lang")) return $this->getVal("field_title_$lang");
          return $this->getVal("field_name");
     }

     public function getDropDownDisplay($lang = "ar")
     {
          return $this->getVal("shortname")."-".$this->getVal("field_name")."-".$this->getVal("field_title_$lang");
     }

     /*
        public function dynamicHelpCondition($attribute)
        {
             if($attribute=="titre_short") return ($this->getVal("titre_short") != $this->getVal("titre"));
             
             return true; 
        }*/

     public function select_visibilite_horizontale($dropdown = false)
     {
          $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
          $objme = AfwSession::getUserConnected();
          $me = ($objme) ? $objme->id : 0;
          $this->select_visibilite_horizontale_default();
          if (!$objme->isSuperAdmin()) {
               $this->select("active",'Y');
          }
     }




     public function needAnswerTable()
     {
          if (in_array($this->getVal("application_field_type_id"), array(12, 15))) {
               return (!$this->lookupListWithoutLookupTable());
          }

          return (in_array($this->getVal("application_field_type_id"), array(5, 6, 17)));
     }





     public function getNextFieldOrder()
     {

          $this->select("application_table_id", $this->getVal("application_table_id"));
          $this->select("reel", 'Y');
          $this->select("avail", 'Y');
          return $this->func("IF(ISNULL(max(field_order)), 0, max(field_order))+10");
     }

     public function isFK()
     {
          return ($this->getVal("application_field_type_id") == 5);
     }

     public function isMFK()
     {
          return ($this->getVal("application_field_type_id") == 6);
     }

     public function getScenarioItemId($currstep)
     {
          if ($currstep == 1) return 463;
          if ($currstep == 2) return 464;
          if ($currstep == 3) return 465;
          return 0;
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
                       // adm.acondition-الحقل	afield_id  حقل يفلتر به (required field)
                        // require_once "../adm/acondition.php";
                        $obj = new Acondition();
                        $obj->where("afield_id = '$id' and active='Y' ");
                        $nbRecords = $obj->count();
                        // check if there's no record that block the delete operation
                        if($nbRecords>0)
                        {
                            $this->deleteNotAllowedReason = "Used in some application condition(s) as the condition field";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!$simul) $obj->deleteWhere("afield_id = '$id' and active='N'");

                       // adm.application_model_field-الحقل	application_field_id  أنا تفاصيل لها (required field)
                        // require_once "../adm/application_model_field.php";
                        $obj = new ApplicationModelField();
                        $obj->where("application_field_id = '$id' and active='Y' ");
                        $nbRecords = $obj->count();
                        // check if there's no record that block the delete operation
                        if($nbRecords>0)
                        {
                            $this->deleteNotAllowedReason = "Used in some application model field(s) as The field";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!$simul) $obj->deleteWhere("application_field_id = '$id' and active='N'");


                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK
                       // adm.api_endpoint-الحقول المتوفرة	application_field_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/api_endpoint.php";
                            ApiEndpoint::updateWhere(array('application_field_mfk'=>"REPLACE(application_field_mfk, ',$id,', ',')"), "application_field_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.api_endpoint set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',') where application_field_mfk like '%,$id,%' ");
                        }
                        
                       // adm.app_model_api-الحقول المستعملة	application_field_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/app_model_api.php";
                            AppModelApi::updateWhere(array('application_field_mfk'=>"REPLACE(application_field_mfk, ',$id,', ',')"), "application_field_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.app_model_api set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',') where application_field_mfk like '%,$id,%' ");
                        }
                        
                       // adm.application_step-إظهار الحقول التالية	show_field_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/application_step.php";
                            ApplicationStep::updateWhere(array('show_field_mfk'=>"REPLACE(show_field_mfk, ',$id,', ',')"), "show_field_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_step set show_field_mfk=REPLACE(show_field_mfk, ',$id,', ',') where show_field_mfk like '%,$id,%' ");
                        }
                        
                       // adm.screen_model-الحقول المتوفرة في الشاشة	application_field_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/screen_model.php";
                            ScreenModel::updateWhere(array('application_field_mfk'=>"REPLACE(application_field_mfk, ',$id,', ',')"), "application_field_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.screen_model set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',') where application_field_mfk like '%,$id,%' ");
                        }
                        

               }
               else
               {
                        // FK on me 
 

                        // adm.acondition-الحقل	afield_id  حقل يفلتر به (required field)
                        if(!$simul)
                        {
                            // require_once "../adm/acondition.php";
                            Acondition::updateWhere(array('afield_id'=>$id_replace), "afield_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.acondition set afield_id='$id_replace' where afield_id='$id' ");
                            
                        } 
                        

 

                        // adm.application_model_field-الحقل	application_field_id  أنا تفاصيل لها (required field)
                        if(!$simul)
                        {
                            // require_once "../adm/application_model_field.php";
                            ApplicationModelField::updateWhere(array('application_field_id'=>$id_replace), "application_field_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_model_field set application_field_id='$id_replace' where application_field_id='$id' ");
                            
                        } 
                        


                        
                        // MFK
                       // adm.api_endpoint-الحقول المتوفرة	application_field_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/api_endpoint.php";
                            ApiEndpoint::updateWhere(array('application_field_mfk'=>"REPLACE(application_field_mfk, ',$id,', ',$id_replace,')"), "application_field_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.api_endpoint set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',$id_replace,') where application_field_mfk like '%,$id,%' ");
                        }
                       // adm.app_model_api-الحقول المستعملة	application_field_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/app_model_api.php";
                            AppModelApi::updateWhere(array('application_field_mfk'=>"REPLACE(application_field_mfk, ',$id,', ',$id_replace,')"), "application_field_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.app_model_api set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',$id_replace,') where application_field_mfk like '%,$id,%' ");
                        }
                       // adm.application_step-إظهار الحقول التالية	show_field_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/application_step.php";
                            ApplicationStep::updateWhere(array('show_field_mfk'=>"REPLACE(show_field_mfk, ',$id,', ',$id_replace,')"), "show_field_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_step set show_field_mfk=REPLACE(show_field_mfk, ',$id,', ',$id_replace,') where show_field_mfk like '%,$id,%' ");
                        }
                       // adm.screen_model-الحقول المتوفرة في الشاشة	application_field_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/screen_model.php";
                            ScreenModel::updateWhere(array('application_field_mfk'=>"REPLACE(application_field_mfk, ',$id,', ',$id_replace,')"), "application_field_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.screen_model set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',$id_replace,') where application_field_mfk like '%,$id,%' ");
                        }

                   
               } 
               return true;
            }    
	}

     /**
      * To do Static public method That execute
      * update pmu_adm.application_field af set af.active = (select f.avail from pmu_pag.afield f where f.id = af.id);

      */


}
