<?php


class AdmSortingSessionStatAfwStructure
{
        // token separator = §
        public static function initInstance(&$obj)
        {
                if ($obj instanceof SortingSessionStat) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                        
                        // $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                        $obj->ORDER_BY_FIELDS = "application_plan_id, session_num, application_simulation_id, branch_order";
                        $obj->UNIQUE_KEY = array('application_plan_id', 'session_num', 'application_simulation_id', 'application_plan_branch_id', 'track_num');

                        $obj->showQeditErrors = true;
                        $obj->showRetrieveErrors = true;
                        $obj->general_check_errors = true;
                        $obj->editByStep = true;
                        $obj->editNbSteps = 2; 
                        $obj->after_save_edit = array("class"=>'SortingSession',"formulaAttribute"=>'sorting_session_id', "currmod"=>'adm',"currstep"=>2);
                        // $obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'SortingSessionStat', "submit" => true);
                } else {
                        SortingSessionStatArTranslator::initData();
                        SortingSessionStatEnTranslator::initData();
                }
        }


        public static $DB_STRUCTURE =
        array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),


                'application_plan_id' => array(
                        'FGROUP' => 'farz-branch',
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
                        'FGROUP' => 'farz-branch',
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
                        'CSS' => 'width_pct_25',
                ),

                        'sorting_session_id' => array(
                                'FGROUP' => 'farz-branch',
                                'CATEGORY' => 'FORMULA', 
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
                                'ANSWER' => 'sorting_session',
                                'ANSMODULE' => 'adm',
                                'RELATION' => 'OneToMany',
                                'READONLY' => true,
                                'DNA' => true,
                                'CSS' => 'width_pct_25',
                        ),

                'application_simulation_id' => array(
                        'FGROUP' => 'farz-branch',
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

                'branch_order' => array('IMPORTANT' => 'IN',  'SHOW' => true, 'EXCEL' => false, 'RETRIEVE' => true, 
                                                'EDIT' => true,  'QEDIT' => true,  
                                                'TYPE' => 'INT',  'STEP' => 1, 'DISPLAY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                'CSS' => 'width_pct_25',
                                                ),

                'application_plan_branch_id' => array(
                        'FGROUP' => 'farz-branch',
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

                'branch_code' => array(
                        'FGROUP' => 'farz-branch',
			'SIZE' => 40,
			'TYPE' => 'INT',
			'CATEGORY' => 'FORMULA',
                        'SHOW' => true,
                        'EDIT' => true,
                        'RETRIEVE' => true,
                        'READONLY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
                        'CSS' => 'width_pct_50',
		),

                'track_num' => array(
                        'FGROUP' => 'farz-branch',
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

                'min_weighted_percentage' => array(
                        'FGROUP' => 'farz-branch',
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),


                'min_app_score1' => array(
                        'FGROUP' => 'farz-branch',
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_app_score2' => array(
                        'FGROUP' => 'farz-branch',
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_app_score3' => array(
                        'FGROUP' => 'farz-branch',
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'original_capacity' => array(
                        'FGROUP' => 'farz-branch',
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
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
                
                'capacity' => array(
                        'FGROUP' => 'farz-branch',
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

                'capacity_history' => array(
                        'FGROUP' => 'scores',
			'SIZE' => 40,
			'CSS' => 'width_pct_25',
			'TYPE' => 'TEXT',
			'CATEGORY' => 'FORMULA',
                        'SHOW' => true,
                        'EDIT' => true,
                        'RETRIEVE' => true,
                        'READONLY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
		),

                'nb_accepted' => array(
                        'FGROUP' => 'scores',
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

                'free' => array(
                        'FGROUP' => 'scores',
			'SIZE' => 40,
			'CSS' => 'width_pct_25',
			'TYPE' => 'INT',
			'CATEGORY' => 'FORMULA',
                        'SHOW' => true,
                        'EDIT' => true,
                        'RETRIEVE' => true,
                        'READONLY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
		),

                'execo' => array(
                        'FGROUP' => 'scores',
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'READONLY' => true,
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

                'execo_action' => array(
                        'FGROUP' => 'scores',
			'SIZE' => 40,
			'CSS' => 'width_pct_25',
			'TYPE' => 'TEXT',
			'CATEGORY' => 'FORMULA',
                        'SHOW' => false,
                        'EDIT' => false,
                        'STEP' => 99,
                        'RETRIEVE' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
                        'CSS' => 'width_pct_50',
		),

                'correct' => array(
                        'FGROUP' => 'scores',
			'SIZE' => 40,
			'CSS' => 'width_pct_25',
			'TYPE' => 'YN',
			'CATEGORY' => 'FORMULA',
                        'SHOW' => false,
                        'EDIT' => false,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
		),


                'waiting' => array(
                        'FGROUP' => 'scores',
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'READONLY' => true,
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

                'wp_recommended' => array(
                        'FGROUP' => 'scores',
			'SIZE' => 40,
			'CSS' => 'width_pct_25',
			'TYPE' => 'TEXT',
			'CATEGORY' => 'FORMULA',
                        'SHOW' => false,
                        'EDIT' => false,
                        'STEP' => 99,
                        'RETRIEVE' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
                        'CSS' => 'width_pct_50',
		),

                'cond_weighted_percentage' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_acc_score1' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_acc_score2' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'min_acc_score3' => array(
                        'FGROUP' => 'scores',
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'farz_karra_table' => array(
                        'TYPE' => 'TEXT',  'NO-COTE' => true,  
                        'CATEGORY' => 'FORMULA',  'SEARCH-BY-ONE' => '',  'DISPLAY' => '', 
                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                        ),

                'min_show_score' => array('STEP' => 1, 'FGROUP' => 'show_score', 
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => false,
                        'NO-COTE' => true,
                        "DEFAULT" => 0.0,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),

                'max_show_score' => array('STEP' => 1, 'FGROUP' => 'show_score',  
                        'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => false,
                        'NO-COTE' => true,
                        "DEFAULT" => 100.0,
                        'SIZE' => 255,
                        'CSS' => 'width_pct_25',
                ),


                'applicationDesireList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                        'EDIT' => false,  'QEDIT' => false,  
                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                        'TYPE' => 'FK', 'STEP' => 2,  
                        'CATEGORY' => 'ITEMS',  'ANSWER' => 'application_desire',  'ANSMODULE' => 'adm',  
                        'WHERE' => 'me.application_plan_id=§application_plan_id§ and me.application_simulation_id=§application_simulation_id§ and me.application_plan_branch_id=§application_plan_branch_id§ and me.applicant_id in (select applicant_id from §DBPREFIX§adm.§farz_karra_table§ farz where farz.application_plan_branch_id=§application_plan_branch_id§ and sorting_value_1 between §min_show_score§ and §max_show_score§)', 
                        'ORDER_BY' => 'sorting_value_1 desc, sorting_value_2 desc, sorting_value_3 desc',
                        'SHOW_MAX_DATA'=>900, 
                        'DO-NOT-RETRIEVE-COLS' => ['applicant_id', 'comments','step_num','application_step_id','application_plan_branch_id', 'track_num', 'desire_status_enum'],
                        'FORCE-RETRIEVE-COLS' => ['idn', 'sorting_value_1'],
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
