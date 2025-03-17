<?php


class AdmApplicationSimulationAfwStructure
{
	// token separator = §
	public static function initInstance(&$obj)
	{
		if ($obj instanceof ApplicationSimulation) {
			$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
			$obj->DISPLAY_FIELD = "name_ar";

			// $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
			$obj->ORDER_BY_FIELDS = "name_ar";

			$obj->editByStep = true;
			$obj->editNbSteps = 3; 

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
			'STEP' => 2,
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
			'MAXLENGTH' => 32,
			'MIN-SIZE' => 1,
			'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
			'UTF8' => false,
			'TYPE' => 'TEXT',
			'READONLY' => false,
			'CSS' => 'width_pct_100',
		),



		'log' => array(
			'STEP' => 3,
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
			'READONLY' => true,
			'CSS' => 'width_pct_100',
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
		'tech_notes' 	      => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 'TOKEN_SEP' => "§", 'READONLY' => true, "NO-ERROR-CHECK" => true, 'FGROUP' => 'tech_fields'),
	);
}
    


// errors 
