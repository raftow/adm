<?php


class AdmSortingSessionStatAfwStructure
{
        // token separator = §
        public static function initInstance(&$obj)
        {
                if ($obj instanceof SortingSessionStat) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                        $obj->DISPLAY_FIELD_BY_LANG = ['ar' => "", 'en' => ""];

                        // $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                        $obj->ORDER_BY_FIELDS = "";
                        $obj->UNIQUE_KEY = array('application_plan_id', 'session_num', 'application_simulation_id', 'application_plan_branch_id', 'track_num');

                        $obj->showQeditErrors = true;
                        $obj->showRetrieveErrors = true;
                        $obj->general_check_errors = true;
                        $obj->editByStep = true;
                        $obj->editNbSteps = 2; 
                        // $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
                        $obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'SortingSessionStat', "submit" => true);
                } else {
                        SortingSessionStatArTranslator::initData();
                        SortingSessionStatEnTranslator::initData();
                }
        }


        public static $DB_STRUCTURE =
        array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),


                'application_plan_id' => array(
                        'SHORTNAME' => 'plan',
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
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'application_plan',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'ManyToOne',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'session_num' => array(
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
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'INT',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'application_simulation_id' => array(
                        'SHORTNAME' => 'simulation',
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
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'application_simulation',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'ManyToOne',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'application_plan_branch_id' => array(
                        'SHORTNAME' => 'plan_branch',
                        'SEARCH' => true,
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
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'application_plan_branch',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'OneToMany',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'track_num' => array(
                        'SEARCH' => false,
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
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'ENUM',
                        'ANSWER' => 'INSTANCE_FUNCTION',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'capacity' => array(
                        'SEARCH' => true,
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
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'INT',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'nb_accepted' => array(
                        'SEARCH' => true,
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
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'INT',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'min_app_score1' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT',
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_app_score2' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT',
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_app_score3' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT',
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_acc_score1' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT',
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_acc_score2' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT',
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_acc_score3' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT',
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),


                'applicationDesireList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                        'EDIT' => false,  'QEDIT' => false,  
                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                        'TYPE' => 'FK', 'STEP' => 2,  
                        'CATEGORY' => 'ITEMS',  'ANSWER' => 'application_desire',  'ANSMODULE' => 'adm',  
                        'WHERE' => 'application_plan_id=§application_plan_id§ and application_simulation_id=§application_simulation_id§ and application_plan_branch_id=§application_plan_branch_id§ and applicant_id in (select applicant_id from §DBPREFIX§adm.§farz_karra_table§ where application_plan_branch_id=§application_plan_branch_id§)', 
                        'SHOW_MAX_DATA'=>200, 
                        'READONLY' => true,  'CAN-BE-SETTED' => true, 
                        'CSS' => 'width_pct_100', ),


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
