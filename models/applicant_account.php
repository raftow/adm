<?php
class ApplicantAccount extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "applicant_account";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("applicant_account", "id", "adm");
                AdmApplicantAccountAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new ApplicantAccount();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $application_model_financial_transaction_id, $total_amount = null, $payment_status_enum = null, $create_obj_if_not_found = false)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");
                if (!$application_model_financial_transaction_id) throw new AfwRuntimeException("loadByMainIndex : application_model_financial_transaction_id is mandatory field");


                $obj = new ApplicantAccount();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                $obj->select("application_model_financial_transaction_id", $application_model_financial_transaction_id);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) {
                                if ($total_amount) $obj->set("total_amount", $total_amount);
                                if ($payment_status_enum) $obj->set("payment_status_enum", $payment_status_enum);


                                $obj->activate();
                        }
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("application_plan_id", $application_plan_id);
                        $obj->set("application_simulation_id", $application_simulation_id);
                        $obj->set("application_model_financial_transaction_id", $application_model_financial_transaction_id);
                        if ($total_amount) $obj->set("total_amount", $total_amount);
                        if ($payment_status_enum) $obj->set("payment_status_enum", $payment_status_enum);

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


        public function calcApplication_id($what = "value")
        {
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                $appObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                return AfwLoadHelper::giveWhat($appObj, $what);
        }

        public function beforeDelete($id, $id_replace)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "nauss_");

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

        protected function getPublicMethods()
        {

                $pbms = array();




                $color = 'blue';
                $title_ar = "ارسال رسوم التقديم";
                $title_en = "Send application fees to NAUSS";
                $methodName = 'sendApplicationFeesToNauss';
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                        'METHOD' => $methodName,
                        'COLOR' => $color,
                        "EXECUTE-IN-RETRIEVE-MODE" => true,
                        'LABEL_AR' => $title_ar,
                        'LABEL_EN' => $title_en,
                // 'ADMIN-ONLY' => true,
                        'PUBLIC' => true,
                        'BF-ID' => '',
                        // 'STEP' => "any"
                );



                return $pbms;
        }

        public function sendApplicationFeesToNauss()
        {
                $applicantaccount = new ApplicantAccount();
                //$applicantaccount->where("application_model_financial_transaction_id =4 and payment_status_enum=2 and (send_to_sis_ind is null or send_to_sis_ind !='Y')");
                $applicantaccount->where("id =174");
                
                $applicantaccountList = $applicantaccount->loadMany(1);
                foreach ($applicantaccountList as $applicantAccountObj) {
                        $response = $applicantAccountObj->sendToNauss();
                        if($response["status"] == 200){
                            $applicantAccountObj->set("send_to_sis_ind", "Y");
                            $applicantAccountObj->set("send_to_sis_date", date("Y-m-d H:i:s"));
                            $applicantAccountObj->commit();
                        }
                }

                return [
                    "status" => $response["status"],
                    "body" => $response["body"]
                ];
        }
        public function sendToNauss()
        {
                $applicantObj = $this->het("applicant_id");
                $applicationPlanObj = $this->het("application_plan_id");
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                $application_model_financial_transaction_id = $this->getVal("application_model_financial_transaction_id");
                $termCode = $applicationPlanObj->het("term_id")->getVal("term_code");

                $fullName = $applicantObj->getVal("first_name_ar") . " ". $applicantObj->getVal("second_name_ar")." ".$applicantObj->getVal("third_name_ar")." " . $applicantObj->getVal("last_name_ar");
                //$appObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                $applicationDesireObj = new ApplicationDesire();
                $applicationDesireObj->select("applicant_id", $applicant_id);
                $applicationDesireObj->select("application_plan_id", $application_plan_id);
                $applicationDesireObj->select("application_simulation_id", $application_simulation_id);
                $applicationDesireObj->load();
                if($applicationDesireObj){
                    $applicationPlanBranchObj = $applicationDesireObj->het('application_plan_branch_id');     
                }else{
                    $applicationPlanBranchObj = null;
                }
                if($applicationPlanBranchObj){
                        $programObj = $applicationPlanBranchObj->het('program_id');
                        $programCode = $programObj->het('sis_program_code')->getVal('lookup_code');
                        $programDesc = $programObj->getVal('program_name_ar');
                }else{
                    $programCode = "";
                        $programDesc = "";
                }
                $applicantPaymentObj = new ApplicantPayment();
                $applicantPaymentObj->select("applicant_account_id", $this->getVal("id"));
                $applicantPaymentObj->load();
                $applicationPlanObj = ApplicationPlan::loadById($application_plan_id);
                include_once(__DIR__ . "/../NaussSisApi.php");
                $naussApi = new NaussApi();
                $data = [
                        "applNo"          => "",
                        "studentSsn"      => $applicantObj->getVal("idn"),
                        "studentId"       => "",
                        "studentName"     => $fullName,
                        "programCode"     => $programCode,
                        "programDesc"     => $programDesc,
                        "electTrnsId"     => $applicantPaymentObj->getVal("id"),
                        "cardType"        => ($applicantPaymentObj->getVal("payment_type") == 'DB') ? "DEBIT" : "CREDIT",
                        "cardBrand"       => $applicantPaymentObj->getVal("card_type"),
                        "bankRno"         => $applicantPaymentObj->getVal("receipt_id"),
                        "amount"          => $this->getVal("total_amount"),
                        "transactionDate" => date("d/m/Y", strtotime($this->getVal("updated_at"))),
                        "categoryCode"    => "CADM",
                        "categoryDesc"    => "رسوم التقديم",
                        "paymentCode"     => "PADM",
                        "paymentDesc"     => "رسوم التقديم",
                        "termCode"        => $termCode,
                        "oafrCode"        => "GRADUATE_SELF",
                        "payingMethod"    => "دفع الكتروني",
                        "vatAmount"       => "",
                        "payedByName"     => "",
                        "dateFormat"      => "DD/MM/YYYY",
                ];
                //die(var_dump($data));
                $response = $naussApi->pushApplicationFees($data);
die(var_dump($response));
                return [
                    "status" => $response["status"],
                    "body" => $response["body"]
                ];
        }

}
