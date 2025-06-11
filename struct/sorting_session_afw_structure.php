<?php


class AdmSortingSessionAfwStructure
{
        // token separator = §

        public static function pageCode($uri_items)
        {
                return "manage_sorting_session";
        }

        public static function initInstance(&$obj)
        {
                if ($obj instanceof SortingSession) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                        $obj->DISPLAY_FIELD_BY_LANG = ['ar' => "name_ar", 'en' => "name_en"];

                        // $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                        $obj->ORDER_BY_FIELDS = "name_ar";



                        $obj->UNIQUE_KEY = array('application_plan_id', 'session_num');

                        $obj->showQeditErrors = true;
                        $obj->showRetrieveErrors = true;
                        $obj->general_check_errors = true;
                        $obj->editByStep = true;
                        $obj->editNbSteps = 5;

                        $obj->after_save_edit = array("class" => 'ApplicationPlan', "attribute" => 'application_plan_id', "currmod" => 'adm', "currstep" => 3);
                        // $obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'SortingSession', "submit" => true);
                } else {
                        SortingSessionArTranslator::initData();
                        SortingSessionEnTranslator::initData();
                }
        }


        public static $DB_STRUCTURE =
        array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

                'application_plan_id' => array(
                        'STEP' => 1,
                        'SHORTNAME' => 'plan',
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
                        'ANSWER' => 'application_plan',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'OneToMany',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                ),

                'application_simulation_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => false,  'RETRIEVE' => false,  
                        'EDIT' => false,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                        'TYPE' => 'FK',  'ANSWER' => 'application_simulation',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 2,    
                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                        'CSS' => 'width_pct_25', ),

                'session_num' => array(
                        'STEP' => 1,
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
                        'TYPE' => 'INT',
                        'READONLY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_25',
                ),

                'name_ar' => array(
                        'STEP' => 1,
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE-AR' => true,
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
                        'STEP' => 1,
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE-EN' => true,
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

                'start_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'STEP' => 1,
                        'MANDATORY' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'DISPLAY' => true,
                        'CSS' => 'width_pct_25',
                ],


                'end_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'STEP' => 1,
                        'MANDATORY' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'DISPLAY' => true,
                        'CSS' => 'width_pct_25',
                ],

                'started_ind' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => false,  'STEP' => 1, 
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  
                                'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
				'TYPE' => 'YN',  'CHECKBOX' => true,  'READONLY' => true,  'DNA' => true, 
				'CSS' => 'width_pct_25', ),


                'application_ongoing' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
                                                'EDIT' => true,  'READONLY' => true, 
                                                'TYPE' => 'YN',  'STEP' => 3, 'READONLY'=>true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),   

                
                'desires_nb' => array('SHOW' => true, 
                                        'EDIT' => true,  'READONLY' => true, 
                                        'TYPE' => 'INT',  'STEP' => 3, 'READONLY'=>true,
                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                        'CSS' => 'width_pct_25',),                                

                'applicants_nb' => array('SHOW' => true, 
                                        'EDIT' => true,  'READONLY' => true, 
                                        'TYPE' => 'INT',  'STEP' => 3, 'READONLY'=>true,
                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                        'CSS' => 'width_pct_25',),                                        

                'errors_nb' => array('SHOW' => true, 
                                        'EDIT' => true,  'READONLY' => true, 
                                        'TYPE' => 'INT',  'STEP' => 3, 'READONLY'=>true,
                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                        'CSS' => 'width_pct_25',),  
                                        
                /*'errors_wp' => array('SHOW' => true, 
                                        'EDIT' => true,  'READONLY' => true, 
                                        'TYPE' => 'INT',  'STEP' => 3, 'READONLY'=>true,
                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                        'CSS' => 'width_pct_25',), */


                'data_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'FORMAT' => 'DATETIME',
                        'DISPLAY' => true,
                        'STEP' => 3,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'READONLY' => true,
                        'CSS' => 'width_pct_25',
                ],

                'stats_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'FORMAT' => 'DATETIME',
                        'DISPLAY' => true,
                        'STEP' => 3,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'READONLY' => true,
                        'CSS' => 'width_pct_25',
                ],

                


                'sorting_ready' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
                                'EDIT' => true,  'READONLY' => true,
                                'TYPE' => 'YN',  'STEP' => 3, 'READONLY'=>true,
                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                'CSS' => 'width_pct_25',),

                'sorting_ready_details' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
                                'EDIT' => true,  'READONLY' => true,
                                'TYPE' => 'TEXT',  'STEP' => 3, 'READONLY'=>true,
                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                'CSS' => 'width_pct_100',),

                'task_pct' => array('STEP' => 97,
                        'SHOW' => true,
                        'EDIT' => true,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'PCTG',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),

                'task_html' => array(
                        'STEP' => 3,
                        'CATEGORY' => "FORMULA",
                        'TYPE' => 'TEXT',
                        'SHOW' => true,
                        'EDIT' => true,
                        'READONLY' => true,
                        "CAN-BE-SETTED" => false,
                        'SIZE' => 255,
                        "NO-LABEL" => true,
                        'CSS' => 'width_pct_100',
                        'INPUT_WIDE' => true
                ),


                                        'sorting_step_id' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
                                                                'EDIT' => true,  'READONLY' => true,
                                                                'TYPE' => 'INT',  'STEP' => 99, 'READONLY'=>true,
                                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                                'CSS' => 'width_pct_25',),

                                        'applicationDesireList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  
                                                'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  
                                                'AUDIT' => false,  'RETRIEVE' => false, 'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
                                                'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'STEP' => 99,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'application_desire',  'ANSMODULE' => 'adm',  
                                                'WHERE' => 'application_plan_id = §application_plan_id§ and application_simulation_id = §application_simulation_id§ and application_step_id=§sorting_step_id§ and active=\'Y\'',  
                                                'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_50', ),

                                        'applicationList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  
                                                'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  
                                                'AUDIT' => false,  'RETRIEVE' => false, 'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
                                                'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'STEP' => 99,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'application',  'ANSMODULE' => 'adm',  
                                                'WHERE' => 'application_plan_id = §application_plan_id§ and application_simulation_id = §application_simulation_id§ and application_status_enum = 2 and active=\'Y\'',  
                                                'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_50', ),

                                                             


                'applicant_id' => array('STEP' => 2, 'SEARCH' => true,  'QSEARCH' => false,  
                                'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'TEXT', 'READONLY' => false,
				'CSS' => 'width_pct_25', ),


	                                              


                'nb_desires' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'INT',  'STEP' => 99, 'READONLY'=>true,
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
								'CSS' => 'width_pct_25',),

                                'sortingGroupList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  
                                                'ICONS' => false,  'DELETE-ICON' => false,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  
                                                'AUDIT' => false,  'RETRIEVE' => false, 'EDIT' => true,  'SHOW' => true,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
                                                'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'STEP' => 99,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'sorting_group',  'ANSMODULE' => 'adm',  
                                                'WHERE' => 'id in (select distinct sorting_group_id from §DBPREFIX§adm.application_plan_branch where application_plan_id = §application_plan_id§ and active=\'Y\')',  
                                                'READONLY' => true,  
                                                'CSS' => 'width_pct_100', ),

                'statsPanel' => array(
					'STEP' => 3,
					'TYPE' => 'TEXT',
					'CATEGORY' => 'FORMULA',
					'SHOW' => true,
					'EDIT' => true,
					'READONLY' => true,
					"CAN-BE-SETTED" => false,
					'SIZE' => 255,
					"NO-LABEL" => true,
					'CSS' => 'width_pct_100',
					'INPUT_WIDE' => true
			), 

                'settings' => array(
			'STEP' => 2,
			'SEARCH' => true,
			'QSEARCH' => true,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => false,
			'SIZE' => 'AREA',
			'MAXLENGTH' => 5000,
			'MIN-SIZE' => 1,
			'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
			'UTF8' => false,
			'ROWS' => 22,
			'TYPE' => 'TEXT',
			'TEXT-ALIGN' => 'left',
			'DIR' => 'ltr',			
			'READONLY' => false,
			'CSS' => 'width_pct_100',
		),                        

                /*
                'controlPanel' => array(
					'STEP' => 2,
					'TYPE' => 'TEXT',
					'CATEGORY' => 'FORMULA',
					'SHOW' => true,
					'EDIT' => true,
					'READONLY' => true,
					"CAN-BE-SETTED" => false,
					'SIZE' => 255,
					"NO-LABEL" => true,
					'CSS' => 'width_pct_100',
					'INPUT_WIDE' => true
			),  */   
                        
                'colors_legend' => array(
					'STEP' => 4,
					'TYPE' => 'TEXT',
					'CATEGORY' => 'FORMULA',
					'SHOW' => true,
					'EDIT' => true,
					'READONLY' => true,
					"CAN-BE-SETTED" => false,
					'SIZE' => 255,
					"NO-LABEL" => true,
					'CSS' => 'width_pct_100',
					'INPUT_WIDE' => true
			),        
                        
                'statList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  
                                                'ICONS' => true,  'DE'.'LETE-ICON' => false, 'EDIT-ICON' => false,   
                                                'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  
                                                'AUDIT' => false,  'RETRIEVE' => false, 'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
                                                'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'STEP' => 4,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'sorting_session_stat',  'ANSMODULE' => 'adm',  
                                                'DO-NOT-RETRIEVE-COLS' => '::notRetrieve',
                                                'DISABLE_DATA_TABLE' => true,
                                                'RETRIEVE-POPUP-EDITOR' => ['cond_weighted_percentage','capacity',],
                                                'WHERE' => 'application_plan_id = §application_plan_id§ and application_simulation_id = §application_simulation_id§ and session_num=§session_num§ and active=\'Y\'',  
                                                'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_100', ),                        

                 

                'validate_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'DISPLAY' => true,
                        'STEP' => 5,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'READONLY' => true,
                        'CSS' => 'width_pct_33',
                ], 

                
                'publish_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'DISPLAY' => true,
                        'STEP' => 5,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'READONLY' => true,
                        'CSS' => 'width_pct_33',
                ],
                
                'last_approve_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'DISPLAY' => true,
                        'STEP' => 5,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_33',
                ], 

                'validated' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                        'TYPE' => 'YN',  'FORMAT' => 'icon',  'READONLY' => true,  'STEP' => 5, 
                        'MANDATORY' => false, 'QSEARCH' => false, 
                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                        'CSS' => 'width_pct_33',),

                'published' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                        'TYPE' => 'YN',  'FORMAT' => 'icon',  'READONLY' => true,  'STEP' => 5, 
                        'MANDATORY' => false, 'QSEARCH' => false, 
                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                        'CSS' => 'width_pct_33',),
                
                'upgraded' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                        'TYPE' => 'YN',  'FORMAT' => 'icon',  'READONLY' => true,  'STEP' => 5, 
                        'MANDATORY' => false, 'QSEARCH' => false, 
                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                        'CSS' => 'width_pct_33',),




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
