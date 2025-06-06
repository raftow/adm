<?php


class AdmApplicantStepRequestAfwStructure
{
	// token separator = §
	public static function initInstance(&$obj)
	{
		if ($obj instanceof ApplicantStepRequest) {
			$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
			$obj->DISPLAY_FIELD_BY_LANG = ['ar' => "name_ar", 'en' => "name_en"];

			// $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
			$obj->ORDER_BY_FIELDS = "";



			$obj->UNIQUE_KEY = array('applicant_id', 'application_plan_id', 'step_num');

			$obj->showQeditErrors = true;
			$obj->showRetrieveErrors = true;
			$obj->general_check_errors = true;

			$obj->OwnedBy = array('module' => "adm", 'afw' => "Applicant", 'afw2' => "ApplicantStep");
			// $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
			$obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'ApplicantStepRequest', "submit" => true);
		} else {
			ApplicantStepRequestArTranslator::initData();
			ApplicantStepRequestEnTranslator::initData();
		}
	}


	public static $DB_STRUCTURE =
	array(
		'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

		'applicant_id' => array(
			'SHORTNAME' => 'applicant',
			'SEARCH' => true,
			'QSEARCH' => true,
			'TEXT-SEARCHABLE-SEPARATED'=>true,
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
			'TYPE' => 'TEXT',
			/*'ANSWER' => 'applicant',
			'ANSMODULE' => 'adm',
			'RELATION' => 'OneToMany',*/
			'READONLY' => true,
			'DNA' => true,
			'CSS' => 'width_pct_50',
		),

		'application_plan_id' => array(
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
			'RELATION' => 'unkn',
			'READONLY' => false,
			'DNA' => true,
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
			'RELATION' => 'unkn',
			'READONLY' => false,
			'DNA' => true,
			'CSS' => 'width_pct_50',
		),

		'step_num' => array(
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
			'READONLY' => true,
			'CSS' => 'width_pct_50',
		),


		'api_endpoint_id' => array('SHORTNAME' => 'endpoint',  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'api_endpoint',  'ANSMODULE' => 'adm',  
				'RELATION' => 'unkn',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),




		'done' => array(
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
			'TYPE' => 'YN',
			'DEFAULT' => 'N',
			'CHECKBOX' => true,
			'READONLY' => true,
			'DNA' => true,
			'CSS' => 'width_pct_50',
		),

		'status_date' => array(
			'SEARCH' => true,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => false,
			'SIZE' => 10,
			'MAXLENGTH' => 10,
			'MIN-SIZE' => 1,
			'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
			'FORMAT' => 'HIJRI_UNIT',
			'UTF8' => false,
			'TYPE' => 'DATE',
			'READONLY' => false,
			'CSS' => 'width_pct_50',
		),

		'support_category' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 16,  'MAXLENGTH' => 16,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => true,  
				'TYPE' => 'TEXT',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),



		'error_message' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 'AREA',  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => true,  
				'TYPE' => 'TEXT',  'READONLY' => false,  'DNA' => true, 
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
		'tech_notes' 	      => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 'TOKEN_SEP' => "§", 'READONLY' => true, "NO-ERROR-CHECK" => true, 'FGROUP' => 'tech_fields'),
	);
}
    


// errors 
