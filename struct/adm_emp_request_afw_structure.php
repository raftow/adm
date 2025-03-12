<?php
// 28/02/2022 : rafik :
// alter table adm_emp_request add super_admin char(1) null;
// update adm_emp_request set super_admin = 'N';

class AdmAdmEmpRequestAfwStructure
{
	// token separator = §
	public static function initInstance(&$obj)
	{
		if ($obj instanceof AdmEmpRequest) {
			$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
			$obj->DISPLAY_FIELD_BY_LANG = array('ar'=>['firstname','lastname', 'email'], 'en'=>['firstname_en','lastname_en', 'email'],);
			$obj->ORDER_BY_FIELDS = "orgunit_id, employee_id, email";


			$obj->UNIQUE_KEY = array('orgunit_id', 'employee_id', 'email');

			$obj->showQeditErrors = true;
			$obj->showRetrieveErrors = true;

			$obj->OwnedBy = array('module' => "adm", 'afw' => "AdmOrgunit");
			$obj->editByStep = true;
			$obj->editNbSteps = 2;
			$obj->showQeditErrors = true;
			$obj->showRetrieveErrors = true;
			$obj->general_check_errors = true;
			$obj->after_save_edit = array("class"=>'AdmOrgunit',"formulaAttribute"=>'adm_orgunit_id', "currmod"=>'adm',"currstep"=>2);
		} else {
			AdmEmpRequestArTranslator::initData();
			AdmEmpRequestEnTranslator::initData();
		}
	}

	public static $DB_STRUCTURE = array(


		'id' => array(
			'SHOW' => true,
			'RETRIEVE' => true,
			'EDIT' => true,
			'TYPE' => 'PK',
			'CSS' => 'width_pct_25',
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),

		'orgunit_id' => array(
			'SHORTNAME' => 'orgunit',
			'SEARCH' => true,
			'QSEARCH' => true,
			'INTERNAL_QSEARCH' => true,
			'SHOW' => true,
			'RETRIEVE' => true,
			'EDIT' => true,
			'QEDIT' => false,

			'SIZE' => 40,
			'MANDATORY' => true,
			'UTF8' => false,
			'CSS' => 'width_pct_25',
			'TYPE' => 'FK',
			'ANSWER' => 'orgunit',
			'ANSMODULE' => 'hrm',
			'DEPENDENT_OFME' => ['employee_id'],
			'WHERE' => "me.id in (select orgunit_id from §DBPREFIX§adm.adm_orgunit where active='Y')",
			'RELATION' => 'ManyToOne',
			'READONLY' => true,
			/*'EDIT_IF_EMPTY' => true,*/
			'SEARCH-BY-ONE' => true,
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_50',
		),



		'adm_orgunit_id' => array(
			'SHORTNAME' => 'corgunit',
			'SIZE' => 40,
			'CSS' => 'width_pct_25',
			'TYPE' => 'FK',
			'ANSWER' => 'adm_orgunit',
			'ANSMODULE' => 'adm',
			'CATEGORY' => 'FORMULA',
			'RELATION' => 'OneToMany',
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
		),

		'employee_id' => array(
			'SHORTNAME' => 'employee',
			'SEARCH' => true,
			'QSEARCH' => false,
			'INTERNAL_QSEARCH' => true,
			'SHOW' => true,
			'RETRIEVE' => true,
			'EDIT' => true,
			'QEDIT' => false,
			'READONLY' => true,
			/* 'EDIT_IF_EMPTY' => true, */
			'CSS' => 'width_pct_25',
			'SIZE' => 40,
			'MANDATORY' => false,
			'UTF8' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'employee',
			'ANSMODULE' => 'hrm',
			'WHERE' => "id_sh_div = §orgunit_id§ or id_sh_dep = §orgunit_id§", /* and jobrole_mfk like '%,117,%'*/
			'DEPENDENCY' => 'orgunit_id',
			'RELATION' => 'ManyToOne',
			'SEARCH-BY-ONE' => false,
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_50',
		),

		'email' => array(
			'SHOW' => true,
			'EDIT' => true,
			'RETRIEVE' => true,
			'QEDIT' => false,
			'SIZE' => 64,
			'CSS' => 'width_pct_50',
			'MB_CSS' => 'width_pct_50',
			'FORMAT' => 'EMAIL',
			'UTF8' => false,
			'TYPE' => 'TEXT',
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_75',
		),

		'gender_id' => array(
			'IMPORTANT' => 'IN',
			'SEARCH' => false,
			'SHOW' => true,
			'MANDATORY' => true,
			'EDIT' => true,
			'QEDIT' => false,
			'SIZE' => 16,
			'UTF8' => false,
			'CSS' => 'width_pct_25',
			'TYPE' => 'ENUM',
			'ANSWER' => 'FUNCTION',
			'FUNCTION_COL_NAME' => 'sex_enum',
			'DEFAUT' => 1,
			'STEP' => 2,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_50',
		),
		
		'hierarchy_level_enum' => array(
			'SEARCH' => true,
			'SHOW' => true,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => true,
			'SIZE' => 40,
			'SEARCH-ADMIN' => true,
			'SHOW-ADMIN' => true,
			'EDIT-ADMIN' => true,
			'UTF8' => false,
			'TYPE' => 'ENUM',
			'ANSWER' => 'FUNCTION',
			'DEFAUT' => 1,
			'SHORTNAME' => 'lang',
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'STEP' => 2,
			'MANDATORY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'DEFAUT' => 0,
			'CSS' => 'width_pct_50',
		),

		'firstname' => array(
			'IMPORTANT' => 'IN',
			'SEARCH' => true,
			'QSEARCH' => true,
			'SHOW' => true,
			'RETRIEVE' => true,
			'EDIT' => true,
			'MANDATORY' => true,
			'QEDIT' => true,
			'SIZE' => 32,
			'CSS' => 'width_pct_25',
			'UTF8' => true,
			'TYPE' => 'TEXT',
			'STEP' => 2,
			'SEARCH-BY-ONE' => true,
			'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_50',
		),

		'lastname' => array(
			'IMPORTANT' => 'IN',
			'SEARCH' => true,
			'QSEARCH' => true,
			'SHOW' => true,
			'RETRIEVE' => true,
			'EDIT' => true,
			'MANDATORY' => true,
			'QEDIT' => true,
			'SIZE' => 32,
			'CSS' => 'width_pct_25',
			'UTF8' => true,
			'TYPE' => 'TEXT',
			'STEP' => 2,
			'SEARCH-BY-ONE' => true,
			'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_50',
		),
		
		'lastname_en' => array(
			'TYPE' => 'TEXT',
			'EDIT' => true,
			'QEDIT' => true,
			'CATEGORY' => '',
			'SHOW' => false,
			'RETRIEVE' => false,
			'UTF8' => false,
			'SIZE' => 32,
			'MANDATORY' => true,
			'STEP' => 2,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => false,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_50',
		),

		'firstname_en' => array(
			'TYPE' => 'TEXT',
			'EDIT' => true,
			'QEDIT' => true,
			'SHOW' => false,
			'RETRIEVE' => false,
			'UTF8' => false,
			'SIZE' => 32,
			'MANDATORY' => true,
			'STEP' => 2,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => false,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_50',
		),

		'jobrole_mfk' => array(
			'SEARCH' => true,
			'QSEARCH' => false,
			'SHOW' => true,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => false,
			'SIZE' => 32,
			'MANDATORY' => true,
			'UTF8' => false,
			'TYPE' => 'MFK',
			'ANSWER' => 'jobrole',
			'DEFAUT' => '',
			'ANSMODULE' => 'ums',
			'WHERE' => "id_domain = 25", // DOMAIN_ADMISSION=25
			'READONLY' => false,
			'SEARCH-BY-ONE' => false,
			'DISPLAY' => true,
			'STEP' => 2,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
			'CSS' => 'width_pct_100',
		),

		

		'approved' => array(
			'SHOW' => true,
			'RETRIEVE' => true,
			'SEARCH' => true,
			'QSEARCH' => true,
			'EDIT' => true,
			'QEDIT' => true,
			'DEFAUT' => 'W',
			'TYPE' => 'YN',
			'SEARCH-BY-ONE' => true,
			'DISPLAY' => true,
			'STEP' => 2,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'READONLY' => true,
			'CSS' => 'width_pct_25',
		),

		'reject_reason' => array(
			'SHOW' => true,
			'EDIT' => true,
			'QEDIT' => false,
			'UTF8' => true,
			'SIZE' => '128',
			'CSS' => 'width_pct_100',
			'MB_CSS' => 'width_pct_100',
			'ROWS' => 7,
			'TYPE' => 'TEXT',
			'STEP' => 2,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			//'ERROR-CHECK' => true,
			'READONLY' => true,
			'CSS' => 'width_pct_75',
		),


		'active' => array(
			'SHOW' => true,
			'RETRIEVE' => true,
			'SEARCH' => true,
			'QSEARCH' => true,
			'EDIT' => true,
			'QEDIT' => true,
			'DEFAUT' => 'Y',
			'TYPE' => 'YN',
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),






		'created_by'         => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'TECH_FIELDS-RETRIEVE' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'auser',
			'ANSMODULE' => 'ums',
			'FGROUP' => 'tech_fields'
		),

		'created_at'            => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'TECH_FIELDS-RETRIEVE' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'TYPE' => 'GDAT',
			'FGROUP' => 'tech_fields'
		),

		'updated_by'           => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'TECH_FIELDS-RETRIEVE' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'auser',
			'ANSMODULE' => 'ums',
			'FGROUP' => 'tech_fields'
		),

		'updated_at'              => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'TECH_FIELDS-RETRIEVE' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'TYPE' => 'GDAT',
			'FGROUP' => 'tech_fields'
		),

		'validated_by'       => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'auser',
			'ANSMODULE' => 'ums',
			'FGROUP' => 'tech_fields'
		),

		'validated_at'          => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'TYPE' => 'GDAT',
			'FGROUP' => 'tech_fields'
		),

		/* 'active'                   => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),*/

		'version'                  => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'TYPE' => 'INT',
			'FGROUP' => 'tech_fields'
		),

		// 'draft'                         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
		//                                        'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),

		'update_groups_mfk'             => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'ANSWER' => 'ugroup',
			'ANSMODULE' => 'ums',
			'TYPE' => 'MFK',
			'FGROUP' => 'tech_fields'
		),

		'delete_groups_mfk'             => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'ANSWER' => 'ugroup',
			'ANSMODULE' => 'ums',
			'TYPE' => 'MFK',
			'FGROUP' => 'tech_fields'
		),

		'display_groups_mfk'            => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'ANSWER' => 'ugroup',
			'ANSMODULE' => 'ums',
			'TYPE' => 'MFK',
			'FGROUP' => 'tech_fields'
		),

		'sci_id'                        => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'SHOW' => true,
			'RETRIEVE' => false,
			'QEDIT' => false,
			'TYPE' => 'INT', /*stepnum-not-the-object*/
			'ANSMODULE' => 'ums',
			'FGROUP' => 'tech_fields'
		),

		'tech_notes' 	                => array(
			'STEP' => 99,
			'HIDE_IF_NEW' => true,
			'TYPE' => 'TEXT',
			'CATEGORY' => 'FORMULA',
			"SHOW-ADMIN" => true,
			'TOKEN_SEP' => "§",
			'READONLY' => true,
			"NO-ERROR-CHECK" => true,
			'FGROUP' => 'tech_fields'
		),
	);
}
