<?php
class EducationalZone extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "educational_zone";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("educational_zone", "id", "adm");
                AdmEducationalZoneAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new EducationalZone();

                if ($obj->load($id)) {
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
                                // adm.applicant_qualification-المنطقة التعليمية	educational_zone_id  حقل يفلتر به (required field)
                                // require_once "../adm/applicant_qualification.php";
                                $obj = new ApplicantQualification();
                                $obj->where("educational_zone_id = '$id' and active='Y' ");
                                $nbRecords = $obj->count();
                                // check if there's no record that block the delete operation
                                if ($nbRecords > 0) {
                                        $this->deleteNotAllowedReason = "Used in some Applicant qualifications(s) as educational_zone_id";
                                        return false;
                                }
                                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                                if (!$simul) $obj->deleteWhere("educational_zone_id = '$id' and active='N'");



                                // FK part of me - deletable 


                                // FK not part of me - replaceable 



                                // MFK

                        } else {
                                // FK on me 


                                // adm.applicant_qualification-المنطقة التعليمية	educational_zone_id  حقل يفلتر به (required field)
                                if (!$simul) {
                                        // require_once "../adm/applicant_qualification.php";
                                        ApplicantQualification::updateWhere(array('educational_zone_id' => $id_replace), "educational_zone_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.applicant_qualification set educational_zone_id='$id_replace' where educational_zone_id='$id' ");

                                }




                                // MFK


                        }
                        return true;
                }
        }
}
