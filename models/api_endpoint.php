<?php
class ApiEndpoint extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "api_endpoint";
        public static $DB_STRUCTURE = null;
        public static $allApiEndpointList = null;
        public static $apiEndpointByCode = null;
        public static $apiEndpointListForField = [];
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("api_endpoint", "id", "adm");
                AdmApiEndpointAfwStructure::initInstance($this);
        }

        public static function loadAll($only_published=true)
        {
                $obj = new ApiEndpoint();
                $obj->select("active", 'Y');
                if($only_published) $obj->select("published", 'Y');

                $objList = $obj->loadMany();

                return $objList;
        }

        public static function loadAllApiEndpoints()
        {
                if(!self::$allApiEndpointList) self::$allApiEndpointList = ApiEndpoint::loadAll(false); 
                if(!self::$apiEndpointByCode)
                {
                        foreach(self::$allApiEndpointList as $apiEndpoint)
                        {
                                $code = $apiEndpoint->getVal("api_endpoint_code");
                                self::$apiEndpointByCode[$code] = $apiEndpoint;
                        }
                }
        }

        public static function findAllApiEndpointForField($application_field_id, $nb_max=9999)
        {
                if(!self::$apiEndpointListForField[$application_field_id])
                {
                        self::loadAllApiEndpoints();
                        self::$apiEndpointListForField[$application_field_id] = [];
                        reset(self::$allApiEndpointList);
                        foreach (self::$allApiEndpointList as $apiEndpointItem) {
                                $field_exists    = $apiEndpointItem->findInMfk("application_field_mfk", $application_field_id);
                                if ($field_exists and (count(self::$apiEndpointListForField[$application_field_id])<$nb_max)) {
                                        self::$apiEndpointListForField[$application_field_id][] = $apiEndpointItem;
                                }
                        }
                }
                 

                return self::$apiEndpointListForField[$application_field_id];
        }

        public static function loadById($id)
        {
                $obj = new ApiEndpoint();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($api_endpoint_code, $create_obj_if_not_found = false)
        {
                if (!$api_endpoint_code) throw new AfwRuntimeException("loadByMainIndex : api_endpoint_code is mandatory field");

                if(!self::$apiEndpointByCode[$api_endpoint_code])
                {
                        $obj = new ApiEndpoint();
                        $obj->select("api_endpoint_code", $api_endpoint_code);

                        if ($obj->load()) {
                                if ($create_obj_if_not_found) $obj->activate();
                                self::$apiEndpointByCode[$api_endpoint_code] = $obj;
                        } elseif ($create_obj_if_not_found) {
                                $obj->set("api_endpoint_code", $api_endpoint_code);
                                $obj->insertNew();
                                if (!$obj->id) self::$apiEndpointByCode[$api_endpoint_code] = null; // means beforeInsert rejected insert operation
                                else
                                {
                                        $obj->is_new = true;
                                        self::$apiEndpointByCode[$api_endpoint_code] = $obj;
                                }
                                
                        } else self::$apiEndpointByCode[$api_endpoint_code] = null;

                        if(!self::$apiEndpointByCode[$api_endpoint_code]) self::$apiEndpointByCode[$api_endpoint_code] = "NOT-FOUND";
                }

                if(self::$apiEndpointByCode[$api_endpoint_code] == "NOT-FOUND") return null;

                return self::$apiEndpointByCode[$api_endpoint_code];
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        public function stepsAreOrdered()
        {
                return false;
        }


        /**
        * switcherConfig
        * @param string $col
        * @param Auser $auser
        * should be overridden in subclasses if more columns should be switchable
        * return array[$switcher_authorized, $switcher_title, $switcher_text]
        * 
        * $switcher_authorized : if true means the column $col should be switchable
        * $switcher_title, $switcher_text are the title and warning that will be shown by the confirmation popup before do the switch
        */

        public function switcherConfig($col, $auser=null)
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();

                $switcher_authorized = false;        
                $switcher_title = "";
                $switcher_text = "";

                if(($col== $this->fld_ACTIVE()) or ($col== "import"))
                {
                        $switcher_authorized = true;        
                }

                if($col == "published")
                {
                        $switcher_authorized = true;        
                        $switcher_title = $this->tm("Are you sure ?", $lang);
                        $switcher_text = $this->tm("This will enable or disable the use of this API to update applicant fields", $lang);
                }

                return [$switcher_authorized, $switcher_title, $switcher_text];
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
                       // adm.app_model_api-معرف API	api_endpoint_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/app_model_api.php";
                            AppModelApi::removeWhere("api_endpoint_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.app_model_api where api_endpoint_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.application_model_field-الخدمة الالكترونية	api_endpoint_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/application_model_field.php";
                            ApplicationModelField::removeWhere("api_endpoint_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.application_model_field where api_endpoint_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.applicant_api_request-الخدمة الالكترونية	api_endpoint_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_api_request.php";
                            ApplicantApiRequest::removeWhere("api_endpoint_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.applicant_api_request where api_endpoint_id = '$id' ");
                            
                        } 
                        
                        

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
                       // adm.app_model_api-معرف API	api_endpoint_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/app_model_api.php";
                            AppModelApi::updateWhere(array('api_endpoint_id'=>$id_replace), "api_endpoint_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.app_model_api set api_endpoint_id='$id_replace' where api_endpoint_id='$id' ");
                            
                        }
                        
                       // adm.application_model_field-الخدمة الالكترونية	api_endpoint_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/application_model_field.php";
                            ApplicationModelField::updateWhere(array('api_endpoint_id'=>$id_replace), "api_endpoint_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_model_field set api_endpoint_id='$id_replace' where api_endpoint_id='$id' ");
                            
                        }
                        
                       // adm.applicant_api_request-الخدمة الالكترونية	api_endpoint_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_api_request.php";
                            ApplicantApiRequest::updateWhere(array('api_endpoint_id'=>$id_replace), "api_endpoint_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.applicant_api_request set api_endpoint_id='$id_replace' where api_endpoint_id='$id' ");
                            
                        }
                        

                        
                        // MFK

                   
               } 
               return true;
            }    
	}


        public function moveColumn()
        {
                return "priority_num";
        }

        
}
