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

class RequestStatus extends CrmObject
{

     public static $MY_ATABLE_ID = 3570;


     // lookup Value List codes 
     // NEW - طلب جديد  
     public static $REQUEST_STATUS_DRAFT = 1;

     // MISSED_INFO -  عودة للعميل لاستكمال البيانات
     public static $REQUEST_STATUS_MISSED_INFO = 101;

     // MISSED_FILES -  عودة للعميل لاستكمال المرفقات
     public static $REQUEST_STATUS_MISSED_FILES = 102;

     // SENT - طلب مرسل  
     public static $REQUEST_STATUS_SENT = 2;

     // REDIRECT - طلب إعادة التحويل  
     public static $REQUEST_STATUS_REDIRECT = 3;

     // ONGOING - طلب تحت الإنجاز  
     public static $REQUEST_STATUS_ONGOING = 4;

     // DONE - تمت الإجابة  
     public static $REQUEST_STATUS_DONE = 5;

     // CANCELED - طلب ملغى  
     public static $REQUEST_STATUS_CANCELED = 6;

     // CLOSED - طلب مغلق  
     public static $REQUEST_STATUS_CLOSED = 7;

     // REJECTED - طلب مرفوض  
     public static $REQUEST_STATUS_REJECTED = 8;

     // IGNORED - طلب مهمل  
     public static $REQUEST_STATUS_IGNORED = 9;



     public static $DATABASE          = "";
     public static $MODULE              = "crm";
     public static $TABLE               = "request_status";
     public static $DB_STRUCTURE = null;

     
     

     public function __construct()
     {
          parent::__construct("request_status", "id", "crm");
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


     public function beforeDelete($id, $id_replace)
     {


          if ($id) {
               if ($id_replace == 0) {
                    $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - not deletable 


                    $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - deletable 


                    // FK not part of me - replaceable 
                    // crm.request-حالة التذكرة	status_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ${server_db_prefix}crm.request set status_id='$id_replace' where status_id='$id' ");
                    // crm.response-الحالة الجديدة للطلب	new_status_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ${server_db_prefix}crm.response set new_status_id='$id_replace' where new_status_id='$id' ");
                    // crm.action_policy-حالة التذكرة قبل	old_status_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ${server_db_prefix}crm.action_policy set old_status_id='$id_replace' where old_status_id='$id' ");
                    // crm.action_policy-حالة التذكرة بعد	new_status_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ${server_db_prefix}crm.action_policy set new_status_id='$id_replace' where new_status_id='$id' ");



                    // MFK

               } else {
                    $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK on me 
                    // crm.request-حالة التذكرة	status_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ${server_db_prefix}crm.request set status_id='$id_replace' where status_id='$id' ");
                    // crm.response-الحالة الجديدة للطلب	new_status_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ${server_db_prefix}crm.response set new_status_id='$id_replace' where new_status_id='$id' ");
                    // crm.action_policy-حالة التذكرة قبل	old_status_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ${server_db_prefix}crm.action_policy set old_status_id='$id_replace' where old_status_id='$id' ");
                    // crm.action_policy-حالة التذكرة بعد	new_status_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ${server_db_prefix}crm.action_policy set new_status_id='$id_replace' where new_status_id='$id' ");


                    // MFK


               }
               return true;
          }
     }
}
