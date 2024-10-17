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

     /*
        public function dynamicHelpCondition($attribute)
        {
             if($attribute=="titre_short") return ($this->getVal("titre_short") != $this->getVal("titre"));
             
             return true; 
        }*/

     public function select_visibilite_horizontale($dropdown = false)
     {
          $server_db_prefix = AfwSession::config("db_prefix", "c0");
          $objme = AfwSession::getUserConnected();
          $me = ($objme) ? $objme->id : 0;
          $this->select_visibilite_horizontale_default();
          if (!$objme->isSuperAdmin()) {
               $this->where("(${server_db_prefix}adm.fnGetModuleId(id) in (select mu.id_module from ${server_db_prefix}ums.module_auser mu where mu.id_auser = '$me' and mu.avail='Y'))");
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


}
