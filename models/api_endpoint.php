<?php
class ApiEndpoint extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "api_endpoint";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("api_endpoint", "id", "adm");
                AdmApiEndpointAfwStructure::initInstance($this);
        }

        public static function loadAll()
        {
                $obj = new ApiEndpoint();
                $obj->select("active", 'Y');

                $objList = $obj->loadMany();

                return $objList;
        }

        public static function findAllApiEndpointForField($application_field_id)
        {
                $apiEndpointList = ApiEndpoint::loadAll();
                $arr_result = [];
                foreach ($apiEndpointList as $apiEndpointItem) {
                        $field_exists    = $apiEndpointItem->findInMfk("application_field_mfk", $application_field_id);
                        if ($field_exists) {
                                $arr_result[] = $apiEndpointItem;
                        }
                }

                return $arr_result;
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


                $obj = new ApiEndpoint();
                $obj->select("api_endpoint_code", $api_endpoint_code);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("api_endpoint_code", $api_endpoint_code);

                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
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
