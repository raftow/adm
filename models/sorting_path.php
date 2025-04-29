<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class SortingPath extends AFWObject
{

        public static $MY_ATABLE_ID = 13947;

        public static $DATABASE        = "uoh_adm";
        public static $MODULE                = "adm";
        public static $TABLE            = "sorting_path";

        public static $DB_STRUCTURE = null;
        public static $arrTrackTranslation = [];
        public static $nbPathsArr = [];
        public static $arrTrackMajorPathId = [];
        

        public function __construct()
        {
                parent::__construct("sorting_path", "id", "adm");
                AdmSortingPathAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new SortingPath();
                $obj->select_visibilite_horizontale();
                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }


        public static function loadByNum($application_model_id, $sorting_num)
        {
                if (!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
                if (!$sorting_num) throw new AfwRuntimeException("loadByMainIndex : sorting_num is mandatory field");


                $obj = new SortingPath();
                $obj->select("application_model_id", $application_model_id);
                $obj->select("sorting_num", $sorting_num);

                if ($obj->load()) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex(
                $application_model_id,
                $sorting_path_code,
                $name_ar = "",
                $desc_ar = "",
                $name_en = "",
                $desc_en = "",
                $capacity_pct = 0,
                $short_name_ar = "",
                $short_name_en = "",
                $sorting_num = 0,
                $create_obj_if_not_found = false,
                $update_obj_if_found = false
        ) {
                if (!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
                if (!$sorting_path_code) throw new AfwRuntimeException("loadByMainIndex : sorting_path_code is mandatory field");

                $obj = new SortingPath();
                $obj->select("application_model_id", $application_model_id);
                $obj->select("sorting_path_code", $sorting_path_code);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) {
                                if ($name_ar) $obj->set("name_ar", $name_ar);
                                if ($desc_ar) $obj->set("desc_ar", $desc_ar);
                                if ($name_en) $obj->set("name_en", $name_en);
                                if ($desc_en) $obj->set("desc_en", $desc_en);

                                if ($short_name_ar) $obj->set("short_name_ar", $short_name_ar);
                                if ($short_name_en) $obj->set("short_name_en", $short_name_en);
                                if ($sorting_num) $obj->set("sorting_num", $sorting_num);

                                if ($capacity_pct and $update_obj_if_found) $obj->set("capacity_pct", $capacity_pct);
                                $obj->activate();
                        }
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        if (!$name_ar) throw new AfwRuntimeException("loadByMainIndex to create new record : name_ar is mandatory field");
                        if (!$name_en) throw new AfwRuntimeException("loadByMainIndex to create new record : name_en is mandatory field");
                        $obj->set("application_model_id", $application_model_id);
                        $obj->set("sorting_path_code", $sorting_path_code);
                        $obj->set("name_ar", $name_ar);
                        $obj->set("desc_ar", $desc_ar);
                        $obj->set("name_en", $name_en);
                        $obj->set("desc_en", $desc_en);
                        $obj->set("capacity_pct", $capacity_pct);
                        $obj->set("short_name_ar", $short_name_ar);
                        $obj->set("short_name_en", $short_name_en);
                        $obj->set("sorting_num", $sorting_num);
                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }



        public function getScenarioItemId($currstep)
        {

                return 0;
        }

        public function getDisplay($lang = "ar")
        {
                return $this->getVal("name_$lang");
        }





        protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
        {
                global $lang;
                // $objme = AfwSession::getUserConnected();
                // $me = ($objme) ? $objme->id : 0;

                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
                $my_id = $this->getId();
                $displ = $this->getDisplay($lang);



                // check errors on all steps (by default no for optimization)
                // rafik don't know why this : \//  = false;

                return $otherLinksArray;
        }

        protected function getPublicMethods()
        {

                $pbms = array();

                $color = "green";
                $title_ar = "xxxxxxxxxxxxxxxxxxxx";
                $methodName = "mmmmmmmmmmmmmmmmmmmmmmm";
                //$pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("xxyy"));



                return $pbms;
        }

        public function fld_CREATION_USER_ID()
        {
                return "created_by";
        }

        public function fld_CREATION_DATE()
        {
                return "created_at";
        }

        public function fld_UPDATE_USER_ID()
        {
                return "updated_by";
        }

        public function fld_UPDATE_DATE()
        {
                return "updated_at";
        }

        public function fld_VALIDATION_USER_ID()
        {
                return "validated_by";
        }

        public function fld_VALIDATION_DATE()
        {
                return "validated_at";
        }

        public function fld_VERSION()
        {
                return "version";
        }

        public function fld_ACTIVE()
        {
                return  "active";
        }

        public function isTechField($attribute)
        {
                return (($attribute == "created_by") or ($attribute == "created_at") or ($attribute == "updated_by") or ($attribute == "updated_at") or ($attribute == "validated_by") or ($attribute == "validated_at") or ($attribute == "version"));
        }


        public function beforeDelete($id, $id_replace)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "uoh_");

                if (!$id) {
                        $id = $this->getId();
                        $simul = true;
                } else {
                        $simul = false;
                }

                if ($id) {
                        if ($id_replace == 0) {
                                // FK part of me - not deletable 


                                // FK part of me - deletable 


                                // FK not part of me - replaceable 



                                // MFK

                        } else {
                                // FK on me 


                                // MFK


                        }
                        return true;
                }
        }


        /**
         * convert major path ID to track num
         */
        public static function majorPathIdTrack($application_model_id, $major_path_id)
        {
                $nbPaths = self::nbPaths($application_model_id);
                for($path=1;$path<=$nbPaths;$path++)
                {
                     $majPathId = self::trackMajorPathId($application_model_id, $path);   
                     if($majPathId==$major_path_id) return $path;
                }

                return 0;
        }

        public static function nbPaths($application_model_id)
        {
                if (!self::$nbPathsArr[$application_model_id]) {
                        for($path_num=4; $path_num>0;$path_num--)
                        {
                                $obj = SortingPath::loadByNum($application_model_id, $path_num);
                                if ($obj) {
                                        self::$nbPathsArr[$application_model_id] = $path_num;  
                                        break;
                                }
                        }
                        
                }

                return self::$nbPathsArr[$application_model_id];
        }


        /**
         * get translation label for a track num
         */

        public static function trackTranslation($application_model_id, $path_num, $lang)
        {
                if (!self::$arrTrackTranslation[$application_model_id][$path_num][$lang]) {
                        $obj = SortingPath::loadByNum($application_model_id, $path_num);
                        $capacity_translated = AfwLanguageHelper::translateCompanyMessage("path ", "adm", $lang);
                        if ($obj) {
                                self::$arrTrackTranslation[$application_model_id][$path_num][$lang] = $capacity_translated . $obj->getVal("short_name_$lang");
                        } else {
                                self::$arrTrackTranslation[$application_model_id][$path_num][$lang] = $capacity_translated. "-" . $path_num;
                        }
                }

                return self::$arrTrackTranslation[$application_model_id][$path_num][$lang];
        }

        /**
         * convert track num to major path ID
         */

        public static function trackMajorPathId($application_model_id, $path_num)
        {
                if (!self::$arrTrackMajorPathId[$application_model_id][$path_num]) 
                {
                        self::$arrTrackMajorPathId[$application_model_id][$path_num] = "NOT-FOUND";
                        $obj = SortingPath::loadByNum($application_model_id, $path_num);
                        if ($obj) 
                        {
                                list($method_code, $majorPathId) = explode("-",$obj->getVal("sorting_path_code"));
                                if($method_code=="MPS")
                                {
                                        self::$arrTrackMajorPathId[$application_model_id][$path_num] = $majorPathId;
                                }
                        } 
                }

                if(self::$arrTrackMajorPathId[$application_model_id][$path_num]=="NOT-FOUND") return null;

                return self::$arrTrackMajorPathId[$application_model_id][$path_num];
        }
}



// errors 
