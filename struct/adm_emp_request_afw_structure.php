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
			$obj->DISPLAY_FIELD = "";
			$obj->ORDER_BY_FIELDS = "orgunit_id, employee_id, email";


			$obj->UNIQUE_KEY = array('orgunit_id', 'employee_id', 'email');

			$obj->showQeditErrors = true;
			$obj->showRetrieveErrors = true;

			$obj->OwnedBy = array('module' => "adm", 'afw' => "AdmOrgunit");
			$obj->editByStep = true;
			$obj->editNbSteps = 3;
			$obj->showQeditErrors = true;
			$obj->showRetrieveErrors = true;
			$obj->general_check_errors = true;
			// $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
		} else {
			AdmEmpRequestArTranslator::initData();
			//AdmEmpRequestEnTranslator::initData();
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
			'EDIT_IF_EMPTY' => true,
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
			'SEARCH-BY-ONE' => true,
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
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
			'EDIT_IF_EMPTY' => true,
			'CSS' => 'width_pct_25',
			'SIZE' => 40,
			'MANDATORY' => true,
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
		),

		'email' => array(
			'SHOW' => true,
			'EDIT' => true,
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
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'READONLY' => true,
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


		'reject_reason_ar' => array(
			'SHOW' => true,
			'EDIT' => true,
			'QEDIT' => false,
			'UTF8' => true,
			'SIZE' => 'AEREA',
			'CSS' => 'width_pct_100',
			'MB_CSS' => 'width_pct_100',
			'FORMAT' => 'EMAIL',
			'ROWS' => 7,
			'TYPE' => 'TEXT',
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			//'ERROR-CHECK' => true,
			'READONLY' => true,
		),

		'reject_reason_en' => array(
			'SHOW' => true,
			'EDIT' => true,
			'QEDIT' => false,
			'UTF8' => false,
			'SIZE' => 'AEREA',
			'CSS' => 'width_pct_100',
			'MB_CSS' => 'width_pct_100',
			'FORMAT' => 'EMAIL',
			'ROWS' => 7,
			'TYPE' => 'TEXT',
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			//'ERROR-CHECK' => true,
			'READONLY' => true,
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
