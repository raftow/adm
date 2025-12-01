<?php


class AdmApplicantFileAfwStructure
{
        // token separator = §
        public static function initInstance(&$obj)
        {
                if ($obj instanceof ApplicantFile) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                        $obj->DISPLAY_FIELD = "name_ar";
                        $obj->ORDER_BY_FIELDS = "name_ar";
                        $obj->UNIQUE_KEY = array('applicant_id', 'workflow_file_id');

                        $obj->OwnedBy = array('module' => "adm", 'afw' => "Applicant");
                        $obj->showQeditErrors = true;
                        $obj->showRetrieveErrors = true;
                        $obj->general_check_errors = true;
                        $obj->after_save_edit = array("class"=>'Applicant',"attribute"=>'applicant_id', "currmod"=>'adm',"currstep"=>7);
                        // $obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'ApplicantFile', "submit" => true);
                } else {
                        ApplicantFileArTranslator::initData();
                        ApplicantFileEnTranslator::initData();
                }
        }


        public static $DB_STRUCTURE =
        array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

                'applicant_id' => array(
                        'IMPORTANT' => 'LOW',
                        'SHORTNAME' => 'applicant',
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'applicant',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'OneToMany',
                        'READONLY' => true,
                        'CSS' => 'width_pct_50',
                ),

                'idn' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        "CLAUSE-WHERE-COL" => 'id',
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '32',
                        'MAXLENGTH' => '32',
                        'TYPE' => 'TEXT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'REQUIRED' => true,
                        'READONLY' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'TEXT-SEARCHABLE-SEPARATED' => true,
                        'FORMAT' => 'ALPHA-NUMERIC',
                        'CSS' => 'width_pct_50'
                ),

                'workflow_file_id' => array(
                        'SHORTNAME' => 'file',
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'workflow_file',
                        'ANSMODULE' => 'workflow',
                        'RELATION' => 'OneToOneU',
                        'READONLY' => true,
                        'CSS' => 'width_pct_50',
                ),

                'name_ar' => array(
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE-AR' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 128,
                        'MAXLENGTH' => 128,
                        'MIN-SIZE' => 5,
                        'CHAR_TEMPLATE' => "ARABIC-CHARS,SPACE",
                        'MANDATORY' => true,
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),

                'name_en' => array(
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE-EN' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 128,
                        'MAXLENGTH' => 128,
                        'MIN-SIZE' => 5,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'TEXT',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),

                'desc_ar' => array(
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        
                        'EDIT' => true,
                        'QEDIT' => false,
                        'SIZE' => 'AREA',
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),

                

                'desc_en' => array(
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'SIZE' => 'AREA',
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'TEXT',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),

                

                'doc_type_id' => array(
                        'IMPORTANT' => 'HIGH',
                        'SHORTNAME' => 'type',
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'FORMAT-INPUT' => 'btn-bootstrap',
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'doc_type',
                        'WHERE' => "('§afile_ext§'='' or concat(',',valid_ext,',') like '%,§afile_ext§,%') and id in (§file_types§)",
                        'ANSMODULE' => 'ums',
                        'RELATION' => 'unkn',
                        'READONLY' => false,
                        'CSS' => 'width_pct_100',
                ),

                'document_type_id' => array(
                        'SHORTNAME' => 'type',
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => false,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        //'FORMAT-INPUT' => 'btn-bootstrap',
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'document_type',
                        'WHERE' => "",
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'unkn',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),

                'download_light' => array('STEP' => 1,  
				'TYPE' => 'TEXT',  
				'SHORTCUT_CATEGORY' => 'FORMULA', 'CATEGORY' => 'SHORTCUT', 
                                'SHORTCUT'=>"workflow_file_id.download_light", 'SHOW' => true,  
                                'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  
                                'RO_DIV_CLASS' => 'empty_div',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',),

                'afile_ext' => array('TYPE' => 'TEXT', 'CATEGORY' => 'SHORTCUT', 'SHORTCUT'=>"workflow_file_id.afile_ext","CAN-BE-SETTED"=>false,"NO-COTE"=>true,),                

                'approved'           => array('STEP' => 1, 'IMPORTANT' => 'HIGH', 'HIDE_IF_NEW' => true, 'SHOW' => true, 'QSEARCH' => true,
                                                'RETRIEVE' => true, 'EDIT' => true, 'QEDIT' => true,
                                                "DEFAULT" => 'W', 'TYPE' => 'YN','FORMAT' => 'icon','READONLY' => false,  ),

                'created_by'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false,  'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'created_at'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'updated_by'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'updated_at'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'validated_by'       => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'validated_at'       => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'active'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
                'version'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),
                'draft'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
                'update_groups_mfk' => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'delete_groups_mfk' => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'display_groups_mfk' => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'sci_id'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),
                'tech_notes'               => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 'TOKEN_SEP' => "§", 'READONLY' => true, "NO-ERROR-CHECK" => true, 'FGROUP' => 'tech_fields'),
        );
}
    


// errors 
