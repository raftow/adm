<?php
        class ServiceRequest extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "service_request"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("service_request","id","adm");
                        AdmServiceRequestAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ServiceRequest();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }
                protected function getPublicMethods()
                {

                        $pbms = array();




                        $color = 'blue';
                        $title_ar = "ارسال رسالة للمتقدم";
                        $title_en = "Send message to applicant";
                        $methodName = 'sendCommentToApplicant';
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

                public function getDisplay($lang = 'ar')
                {
                        return $this->getDefaultDisplay($lang);
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

                public function beforeMaj($id, $fields_updated)
                {
                        if($fields_updated["request_status_id"])      
                        {
                                $this->set("status_date", "now()");
                               
                        }
                        

                        return true;
                }

                public function calcApplicantIdLink($what = "value")
                {
                        $app_id = $this->getVal("applicant_id");
                        
                        if($app_id)
                        {
                                return "<a href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&id=".$app_id."'>المتقدم</a>";
                        }else{
                                return "بدون حساب".$app_id;
                        }
                }
                public function calcapplicantFileIdLink($what = "value")
                {
                        if($this->getVal("applicant_file_id"))
                        {
                                //$obj = ApplicantFile::loadById($this->getVal("applicant_file_id"));
                                $obj = $this->get("applicant_file_id");
                                return "<a href='".$obj->getVal("name_en")."' target='_blank'>".$obj->getVal("name_ar")." الملف المرفق</a>";
                        
                        }else{
                                return "لا مرفقات";
                        }
                       
                }
                public function sendCommentToApplicant($lang)
                {
                        $id = $this->getId();
                        $applicant_id = $this->getVal("applicant_id");
                        if (!$applicant_id)
                                $error_mg = $this->tm("no applicant for this  request");
                                return [$error_mg, ''];
                        $comment = $this->getVal("status_comment");
                        if (!$comment)
                                $error_mg = "لا يوجد ملاحظة لإرسالها لهذا الطلب";
                                return [$error_mg, ''];

                        $result = self::sendMessge($applicant_id, $comment, $lang);
                        if ($result["status"] == 200)
                                return ['', 'done'];
                        return [$result["response"] ?? 'send failed', ''];
                }
                public static function sendMessge($applicant_id,$body,  $lang)
                {
                        $applicantObj = Applicant::loadById($applicant_id);
                        if (!$applicantObj)
                                return ["status" => 0, "response" => "applicant not found"];

                        $mobile = $applicantObj->getVal("mobile");
                        $email  = $applicantObj->getVal("email");

                        if (!$mobile && !$email)
                                return ["status" => 0, "response" => "no mobile or email for applicant $applicant_id"];

                        
                        $payload = ["body" => $body];
                        if ($mobile) $payload["mobile"] = $mobile;
                        if ($email)  $payload["email"]  = $email;
                        $subject = $lang == "ar" ? "تحديث على طلبكم رقم " : "Update on your request No. ";
                        $subject = $subject . $this->getVal("id");
                        $payload["subject"] = $subject;
                        $base_url = AfwSession::config("api_base_url", "https://api.bmeholding.com/api");
                        $token    = AfwSession::config("api_token", "XXXXYYY");

                        $ch = curl_init("$base_url/message/send");
                        curl_setopt_array($ch, [
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_POST           => true,
                                CURLOPT_POSTFIELDS     => json_encode($payload),
                                CURLOPT_HTTPHEADER     => [
                                        "Authorization: Bearer $token",
                                        "Content-Type: application/json",
                                        "Accept: application/json",
                                ],
                        ]);

                        $response = curl_exec($ch);
                        $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);
                        return ["status" => $status, "response" => json_decode($response, true)];
                }

        }
?>