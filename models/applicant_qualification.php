<?php
        class ApplicantQualification extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "applicant_qualification"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("applicant_qualification","id","adm");
                        AdmApplicantQualificationAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicantQualification();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
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

                        if ($fields_updated["qualification_id"] or $fields_updated["major_category_id"]) {

                                $objMajorPath = MajorPath::loadByMainIndex($this->getVal("qualification_id"),$this->getVal("major_category_id"));

                                if ($objMajorPath) {
                                        $this->set("major_path_id", $objMajorPath->id);
                                }
                        }

                        return true;
                }


                  

        }
/*
INSERT INTO `applicant_qualification` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `applicant_id`, `qualification_id`, `major_category_id`, `major_path_id`, `qualification_major_id`, `gpa`, `gpa_from`, `date`, `source`, `imported`, `import_utility_id`, `qualification_major_desc`) VALUES
(6, 0, '2024-09-01 09:15:14', 0, '2024-09-01 09:15:14', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1016067116, 49, NULL, NULL, 5, 92, 100, NULL, 'ثانوية الجفر للتعليم المستمر - مقررات', NULL, NULL, ''),
(81, 0, '2024-09-01 09:18:21', 0, '2024-09-01 09:18:21', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1037821616, 49, NULL, NULL, 5, 95, 100, NULL, 'ثانوية الأمير ماجد بن عبدالعزيز الليلية - مقررات', NULL, NULL, ''),
(94, 0, '2024-09-01 09:18:55', 0, '2024-09-01 09:18:55', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1000994556, 49, NULL, NULL, 5, 89, 100, NULL, 'ثانوية عمر بن حسن آل الشيخ الليلية - مقررات', NULL, NULL, ''),
(107, 0, '2024-09-01 09:25:29', 0, '2024-09-01 09:25:29', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1022973240, 49, NULL, NULL, 5, 85, 100, NULL, 'ثانوية موسى بن نصير الليلية- مقررات', NULL, NULL, ''),
(111, 0, '2024-09-01 09:25:39', 0, '2024-09-01 09:25:39', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1003035910, 49, NULL, NULL, 5, 88, 100, NULL, 'ثانوية مجمع الامير محمد بن فهد التعليمي الليلية - مقررات', NULL, NULL, ''),
(121, 0, '2024-09-01 09:26:03', 0, '2024-09-01 09:26:03', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1018199719, 49, NULL, NULL, 1, 67, 100, NULL, 'ثانوية ابن المنذر - نظام المقررات', NULL, NULL, ''),
(131, 0, '2024-09-01 09:26:36', 0, '2024-09-01 09:26:36', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1010066577, 49, NULL, NULL, 5, 92, 100, NULL, 'ابن خزيمة الليلية الثانوية - مقررات', NULL, NULL, ''),
(136, 0, '2024-09-01 09:26:59', 0, '2024-09-01 09:26:59', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1029397112, 49, NULL, NULL, 2, 96, 100, NULL, 'مقررات ثانوية الملك عبد العزيز', NULL, NULL, ''),
(158, 0, '2024-09-01 09:28:55', 0, '2024-09-01 09:28:55', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1016417568, 49, NULL, NULL, 5, 94, 100, NULL, 'ثانوية الأمير ماجد بن عبدالعزيز الليلية - مقررات', NULL, NULL, ''),
(159, 0, '2024-09-01 09:29:00', 0, '2024-09-01 09:29:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1033406602, 49, NULL, NULL, 5, 87, 100, NULL, 'ثانوية الثقبة الليلية - مقررات', NULL, NULL, ''),
(165, 0, '2024-09-01 09:29:28', 0, '2024-09-01 09:29:28', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1015850520, 49, NULL, NULL, 1, 88, 100, NULL, 'طليطلة الثانوية - مقررات', NULL, NULL, ''),
(170, 0, '2024-09-01 09:29:53', 0, '2024-09-01 09:29:53', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1030910358, 49, NULL, NULL, 2, 78, 100, NULL, 'القدس مقررات', NULL, NULL, ''),
(178, 0, '2024-09-01 09:30:40', 0, '2024-09-01 09:30:40', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1003311162, 49, NULL, NULL, 5, 76, 100, NULL, 'ثانوية هارون الرشيد الليلية', NULL, NULL, ''),
(187, 0, '2024-09-01 09:31:23', 0, '2024-09-01 09:31:23', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1014361404, 49, NULL, NULL, 5, 82, 100, NULL, 'ثانوية بلال بن رباح للتعليم المستمر - مقررات', NULL, NULL, ''),
(194, 0, '2024-09-01 09:31:58', 0, '2024-09-01 09:31:58', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1015295155, 49, NULL, NULL, 5, 92, 100, NULL, 'ثانوية خلاد بن السائب للتعليم المستمر - مقررات', NULL, NULL, ''),
(204, 0, '2024-09-01 09:33:03', 0, '2024-09-01 09:33:03', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1011896691, 49, NULL, NULL, 1, 66, 100, NULL, 'ثانوية القرين - مقررات', NULL, NULL, ''),
(206, 0, '2024-09-01 09:33:13', 0, '2024-09-01 09:33:13', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1024509604, 49, NULL, NULL, 5, 79, 100, NULL, 'ثانوية الهفوف للتعليم المستمر- مقررات', NULL, NULL, ''),
(209, 0, '2024-09-01 09:33:29', 0, '2024-09-01 09:33:29', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1036110953, 49, NULL, NULL, 1, 93, 100, NULL, 'ثانوية صقر قريش - مقررات', NULL, NULL, ''),
(218, 0, '2024-09-01 09:34:11', 0, '2024-09-01 09:34:11', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, 1035236890, 49, NULL, NULL, 5, 93, 100, NULL, 'ثانوية الجهاد الليلية - مقررات', NULL, NULL, '');
*/
