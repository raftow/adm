<?php
class ApplicantApiRequest extends AdmObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "adm";
    public static $TABLE            = "applicant_api_request";
    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct("applicant_api_request", "id", "adm");
        AdmApplicantApiRequestAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new ApplicantApiRequest();

        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($applicant_id, $api_endpoint_id, $create_obj_if_not_found = false)
    {
        if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
        if (!$api_endpoint_id) throw new AfwRuntimeException("loadByMainIndex : api_endpoint_id is mandatory field");


        $obj = new ApplicantApiRequest();
        $obj->select("applicant_id", $applicant_id);
        $obj->select("api_endpoint_id", $api_endpoint_id);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("applicant_id", $applicant_id);
            $obj->set("api_endpoint_id", $api_endpoint_id);

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

    public function beforeDelete($id,$id_replace)
    {
        return true;
    }

    public function calcExpiry_date($what="value")
    {
        $aepObj = $this->het("api_endpoint_id");
        if(!$aepObj) return "0000-00-00";
        $duration_expiry = $aepObj->getVal("duration_expiry");
        if (!$duration_expiry) $duration_expiry = 15;
        return AfwDateHelper::shiftGregDate('', -$duration_expiry);
    }


    public function calcRefresh_needed($what="value", $lang = "")
    {
        list($yes,$no) = AfwLanguageHelper::translateYesNo($what, $lang);
        if($this->sureIs("need_refresh")) 
        {
            // $need_refresh = $this->getVal("need_refresh");
            // die("calcRefresh_needed => need_refresh=$need_refresh => $yes");
            return $yes;
        }
        $expiry_date = $this->calcExpiry_date();
        $run_date = $this->getVal("run_date");
        // if($run_date<$expiry_date) 
        // die("calcRefresh_needed => ($run_date<$expiry_date) => $yes : $no");
        return ($run_date<$expiry_date) ? $yes : $no;  // run date is too much old
    }

    public function shouldBeCalculatedField($attribute){
        if($attribute=="expiry_date") return true;
        if($attribute=="refresh_needed") return true;
        return false;
    }

    public function switcherConfig($col, $auser = null)
    {
        $switcher_authorized = false;
        $switcher_title = "";
        $switcher_text = "";

        if ($col == "need_refresh") {
            $switcher_authorized = true;
        }

        if ($col == $this->fld_ACTIVE()) {
            $switcher_authorized = true;
        }

        return [$switcher_authorized, $switcher_title, $switcher_text];
    }


    public function runMeOn($applicantObject, $lang="ar", $force=false, $echo=false, $ignorePublish=false)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];
        /**
         * @var ApiEndpoint $apiEndPoint
         */
        $apiEndPoint = $this->het("api_endpoint_id");
        //
        if ($apiEndPoint and ($ignorePublish or $apiEndPoint->sureIs("published"))) {
                $run_date = $this->getVal("run_date");
                if ($run_date == "0000-00-00") $run_date = "";
                if ($run_date == "0000-00-00 00:00:00") $run_date = "";

                $refresh_needed = ($this->sureIs("refresh_needed") or $force);

                if ($run_date) $can_refresh = $apiEndPoint->sureIs("can_refresh");
                else $can_refresh = true;

                if ($refresh_needed and $can_refresh) {
                        $api_name = $apiEndPoint->getShortDisplay($lang);
                        $api_endpoint_code = $apiEndPoint->getVal("api_endpoint_code");
                        $api_runner_method = "run_api_" . $api_endpoint_code;
                        $api_runner_class = self::loadApiRunner();
                        list($err, $inf, $war, $tech) = $api_runner_class::$api_runner_method($applicantObject);
                        if($echo and $err) AfwBatch::print_error($err);
                        if($echo and $inf) AfwBatch::print_info($err);
                        if($echo and $war) AfwBatch::print_warning($err);
                        if($echo and $tech) AfwBatch::print_debugg($err);

                        if ($err) $err_arr[] = "$api_name : " . $err;
                        if ($inf) $inf_arr[] = "$api_name : " . $inf;
                        if ($war) $war_arr[] = "$api_name : " . $war;
                        if ($tech) $tech_arr[] = $tech;

                        if (!$err) {
                                $this->set("need_refresh", "N");
                                $this->set("run_date", date("Y-m-d H:i:s"));
                                $this->commit();
                        }
                } 
                elseif (!$refresh_needed) $war_arr[] = $apiEndPoint . " " . $this->tm("doesn't need update as recently updated at") . " $run_date";
                elseif (!$can_refresh) $war_arr[] = $apiEndPoint . " " . $this->tm("can not be refreshed and already called at") . " $run_date";
        } else $war_arr[] = $apiEndPoint . " " . $this->tm("is not published");


        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }
}
