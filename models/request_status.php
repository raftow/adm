<?php
// ------------------------------------------------------------------------------------
// 7/4/2020 :
// alter table request_status change lookup_code lookup_code  varchar(128) NOT NULL;
// alter table ".$server_db_prefix."crm.request_status add customer_status_name_ar varchar(128) NOT NULL;
// alter table ".$server_db_prefix."crm.request_status add customer_status_name_en varchar(128) NOT NULL;
// update ".$server_db_prefix."crm.request_status set customer_status_name_ar = request_status_name_ar;
// update ".$server_db_prefix."crm.request_status set customer_status_name_en = request_status_name_en;



$file_dir_name = dirname(__FILE__);

// old include of afw.php

class RequestStatus extends AdmObject
{


     public static $DATABASE          = "";
     public static $MODULE              = "adm";
     public static $TABLE               = "request_status";
     public static $DB_STRUCTURE = null;

     
     

     public function __construct()
     {
          parent::__construct("request_status", "id", "adm");
          $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
          $this->DISPLAY_FIELD = "request_status_name_ar";
          $this->ORDER_BY_FIELDS = "lookup_code";
          $this->IS_LOOKUP = true;
          $this->ignore_insert_doublon = true;
          $this->UNIQUE_KEY = array('lookup_code');

          $this->showQeditErrors = true;
          $this->showRetrieveErrors = true;
          $this->public_display = true;
     }

     public static function loadById($id)
     {
          $obj = new RequestStatus();
          $obj->select_visibilite_horizontale();
          if ($obj->load($id)) {
               return $obj;
          } else return null;
     }



     public static function loadByMainIndex($lookup_code, $create_obj_if_not_found = false)
     {
          $obj = new RequestStatus();
          if (!$lookup_code) $obj->_error("loadByMainIndex : lookup_code is mandatory field");


          $obj->select("lookup_code", $lookup_code);

          if ($obj->load()) {
               if ($create_obj_if_not_found) $obj->activate();
               return $obj;
          } elseif ($create_obj_if_not_found) {
               $obj->set("lookup_code", $lookup_code);

               $obj->insert();
               $obj->is_new = true;
               return $obj;
          } else return null;
     }


     public function getDisplay($lang = "ar")
     {

          if ($this->getVal("request_status_name_$lang")) return $this->getVal("request_status_name_$lang");
          $data = array();
          $link = array();




          return implode(" - ", $data);
     }





     protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
     {
          global $me, $objme, $lang;
          $otherLinksArray = array();
          $my_id = $this->getId();
          $displ = $this->getDisplay($lang);



          return $otherLinksArray;
     }

     protected function getPublicMethods()
     {

          $pbms = array();

          $color = "green";
          $title_ar = "xxxxxxxxxxxxxxxxxxxx";
          //$pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");



          return $pbms;
     }


     
}
