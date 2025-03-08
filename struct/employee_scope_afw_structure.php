<?php


class AdmEmployeeScopeAfwStructure
{
        // token separator = §
        public static function initInstance(&$obj)
        {
                if ($obj instanceof EmployeeScope) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                        $obj->DISPLAY_FIELD = "";

                        // $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                        $obj->ORDER_BY_FIELDS = "start_date, end_date";



                        $obj->UNIQUE_KEY = array('start_date', 'end_date');
                        $obj->OwnedBy = array('module' => "adm", 'afw' => "AdmEmployee");
                        $obj->showQeditErrors = true;
                        $obj->showRetrieveErrors = true;
                        $obj->general_check_errors = true;
                        $obj->after_save_edit = array("class"=>'AdmEmployee',"attribute"=>'adm_employee_id', "currmod"=>'adm',"currstep"=>2);
                        // $obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'EmployeeScope', "submit" => true);
                } else {
                        EmployeeScopeArTranslator::initData();
                        EmployeeScopeEnTranslator::initData();
                }
        }


        public static $DB_STRUCTURE =
        array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

                'adm_employee_id' => array(
                        'SHORTNAME' => 'employee',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'adm_employee',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'OneToMany',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'start_date' => array(
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 10,
                        'MAXLENGTH' => 10,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'FORMAT' => 'LONG',
                        'UTF8' => false,
                        'TYPE' => 'DATE',
                        'CSS' => 'width_pct_25',
                ),

                'end_date' => array(
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 10,
                        'MAXLENGTH' => 10,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'FORMAT' => 'LONG',
                        'UTF8' => false,
                        'TYPE' => 'DATE',
                        'CSS' => 'width_pct_25',
                ),

                'academic_level_id' => array(
                        'SHORTNAME' => 'level',
                        'SEARCH' => true,
                        'QSEARCH' => true,
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
                        'ANSWER' => 'academic_level',
                        'ANSMODULE' => 'adm',
                        'DEPENDENT_OFME' => array("application_model_id"),
                        'RELATION' => 'ManyToOne',
                        'EMPTY_IS_ALL' => true,
                        'READONLY' => false,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'application_model_id' => array(
                        'SHORTNAME' => 'model',
                        'SEARCH' => true,
                        'QSEARCH' => true,
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
                        'ANSWER' => 'application_model',
                        'ANSMODULE' => 'adm',
                        'WHERE' => "academic_level_id = §academic_level_id§",
                        'DEPENDENCIES' => ['academic_level_id'],
                        'RELATION' => 'ManyToOne',
                        'EMPTY_IS_ALL' => true,
                        'READONLY' => false,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'gender_enum' => array(
                        'SHORTNAME' => 'gender',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => false,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'ENUM',
                        'ANSWER' => 'LOOKUP_TABLE',
                        'READONLY' => true,
                        'EMPTY_IS_ALL' => true,
                        'CSS' => 'width_pct_50',
                ),

                'training_unit_type_id' => array(
                        'SHORTNAME' => 'unit_type',
                        'SEARCH' => true,
                        'QSEARCH' => true,
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
                        'ANSWER' => 'training_unit_type',
                        'ANSMODULE' => 'adm',
                        'DEPENDENT_OFME' => array("training_unit_id"),
                        'RELATION' => 'ManyToOne',
                        'EMPTY_IS_ALL' => true,
                        'READONLY' => false,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'training_unit_id' => array(
                        'SHORTNAME' => 'unit',
                        'SEARCH' => false,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'training_unit',
                        'ANSMODULE' => 'adm',
                        'WHERE' => "(§training_unit_type_id§ = 0 or id in (select tuc.training_unit_id from §DBPREFIX§adm.training_unit_college tuc where tuc.college_id = §training_unit_type_id§ and tuc.active='Y'))",
                        'DEPENDENCIES' => ['training_unit_type_id'],
                        'RELATION' => 'ManyToOne',
                        'EMPTY_IS_ALL' => true,
                        'READONLY' => false,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                

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
                'sci_id'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'tech_notes'               => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 'TOKEN_SEP' => "§", 'READONLY' => true, "NO-ERROR-CHECK" => true, 'FGROUP' => 'tech_fields'),
        );
}
    


// errors 
