<?php


class AdmApplicationSimulationAfwStructure
{
	public static function pageCode($uri_items)
	{
			return "edit_application_simulation_adm";
	}
	
	// token separator = §
	public static function initInstance(&$obj)
	{
		if ($obj instanceof ApplicationSimulation) {
			$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
			$obj->DISPLAY_FIELD = "name_ar";

			// $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
			$obj->ORDER_BY_FIELDS = "name_ar";

			$obj->editByStep = true;
			$obj->editNbSteps = 6; 

			// $obj->UNIQUE_KEY = array('XXX', 'YYY');

			$obj->showQeditErrors = true;
			$obj->showRetrieveErrors = true;
			$obj->general_check_errors = true;
			// $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
			$obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'ApplicationSimulation', "submit" => true);
		} else {
			ApplicationSimulationArTranslator::initData();
			ApplicationSimulationEnTranslator::initData();
		}
	}


	public static $DB_STRUCTURE =
	array(
		'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),


		'name_ar' => array(
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



		'application_model_id' => array(
			'SHORTNAME' => 'model',
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
			'ANSWER' => 'application_model',
			'ANSMODULE' => 'adm',
			'RELATION' => 'ManyToOne',
			'DEPENDENT_OFME' => ['application_model_branch_mfk',],
			'READONLY' => false,
			'DNA' => true,
			'CSS' => 'width_pct_50',
		),

		'applicant_group_id' => array(
			'SHORTNAME' => 'group',
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
			'ANSWER' => 'applicant_group',
			'ANSMODULE' => 'adm',
			'RELATION' => 'unkn',
			'READONLY' => false,
			'DNA' => true,
			'CSS' => 'width_pct_50',
		),

		'simul_method_enum' => array(
			'SEARCH' => true,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => false,
			'DEFAUT' => 1,
			'SIZE' => 32,
			'MAXLENGTH' => 32,
			'MIN-SIZE' => 1,
			'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
			'UTF8' => false,
			'TYPE' => 'ENUM',
			'ANSWER' => 'FUNCTION', 'FUNCTION_COL_NAME' => 'apply_simul_method_enum',
			'READONLY' => false,
			'DNA' => true,
			'MANDATORY' => true,
			'CSS' => 'width_pct_50',
		),

		'nb_desires' => array(
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
			'UTF8' => false,
			'TYPE' => 'INT',
			'MANDATORY' => false,
			'CSS' => 'width_pct_50',
		),

		'application_model_branch_mfk' => array(
			'STEP' => 1,
			'SHORTNAME' => 'model_branchs',
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
			'UTF8' => false,
			'TYPE' => 'MFK',
			'ANSWER' => 'application_model_branch',
			'WHERE' => 'application_model_id = §application_model_id§',
			'DEPENDENCIES' => ['application_model_id',],
			'ANSMODULE' => 'adm',
			'READONLY' => false,
			'DNA' => true,
			'CSS' => 'width_pct_100',
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


		'controlPanel' => array(
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

		'logPanel' => array(
					'STEP' => 5,
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

		'log' => array(
			'STEP' => 5,
			'SEARCH' => true,
			'QSEARCH' => true,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => false,
			'SIZE' => 'AREA',
			'NO-INPUT' => true,
			'MIN-SIZE' => 1,
			'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
			'UTF8' => false,
			'TYPE' => 'TEXT',
			'READONLY' => true,
			'CSS' => 'width_pct_100',
			'PRE' => true,
			'DIR' => 'BYLANG',	
			'TEXT-ALIGN' => 'BYLANG',
		),

		'progress_task' => array('STEP' => 5,  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 32,  'MAXLENGTH' => 255,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => true,  
				'TYPE' => 'TEXT',  'READONLY' => true,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),

		'progress_value' => array('STEP' => 5,  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'PCTG',  'UNIT' => '%',  'READONLY' => true,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),





		'application_plan_id' => array('STEP' => 3,
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
			'RELATION' => 'ManyToOne',
			'READONLY' => true,
			'DNA' => true,
			'CSS' => 'width_pct_100',
		),

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


						'applicant_ids' => array('STEP' => 99,
							'SIZE' => 255,
							'CSS' => 'width_pct_100',
							'TYPE' => 'TEXT',
							'CATEGORY' => 'FORMULA',
							'DISPLAY-UGROUPS' => '',
							'EDIT-UGROUPS' => '',
							'NO-COTE' => true,
						),

		'applicationList' => array('STEP' => 3,
			'SHORTNAME' => 'applications',  'SHOW' => true,  'FORMAT' => 'retrieve',  
			'ICONS' => true, 'VIEW-ICON' =>false, 'DELETE-ICON' => true,
			'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
			'EDIT' => false,  'QEDIT' => false,  
			'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
			'TYPE' => 'FK', 'DO-NOT-RETRIEVE-COLS' => ['active','application_plan_id'], 
			'CATEGORY' => 'ITEMS',  'ANSWER' => 'application',  
			'ANSMODULE' => 'adm',  'ITEM' => 'application_simulation_id',  
			'WHERE' => 'application_plan_id = §application_plan_id§ and applicant_id in (§applicant_ids§)',
			'READONLY' => true,  'CAN-BE-SETTED' => true, 
			'CSS' => 'width_pct_100', ),

		'applicationDesireList' => array('STEP' => 3,
			'SHORTNAME' => 'desires',  'SHOW' => true,  'FORMAT' => 'retrieve',  
			'ICONS' => true, 'MOVE_UP-ICON' =>false, 'VIEW-ICON' =>false, 'DELETE-ICON' => false, 
			'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
			'EDIT' => false,  'QEDIT' => false,  
			'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
			'TYPE' => 'FK', 
			'CATEGORY' => 'ITEMS',  'ANSWER' => 'application_desire',  
			'ANSMODULE' => 'adm',  'ITEM' => 'application_simulation_id',  
			'WHERE' => 'application_plan_id = §application_plan_id§ and applicant_id in (§applicant_ids§)',
			'READONLY' => true,  'CAN-BE-SETTED' => true, 
			'CSS' => 'width_pct_100', ),


		'blocked_applicants_mfk' => array('STEP' => 99,  'SHORTNAME' => 'applicantss',  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'MFK',  'ANSWER' => 'applicant',  'ANSMODULE' => 'adm',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),
			


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
		'tech_notes' 	      => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 'TOKEN_SEP' => "§", 'READONLY' => true, "NO-ERROR-CHECK" => true, 'FGROUP' => 'tech_fields'),
	);
}
    


// errors 
