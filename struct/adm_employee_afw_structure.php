<?php
// 28/02/2022 : rafik :
// alter table adm_employee add super_admin char(1) null;
// update adm_employee set super_admin = 'N';



class AdmAdmEmployeeAfwStructure
{
	// token separator = §
	public static function initInstance(&$obj)
	{
		if ($obj instanceof AdmEmployee) {
			$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
			$obj->DISPLAY_FIELD_BY_LANG = array('ar' => ['firstname', 'lastname'],
                                                'en' => ['firstname_en', 'lastname_en']);
            // $obj->FORMULA_DISPLAY_FIELD  = "concat(IF(ISNULL(firstname), '', firstname) , ' ' , IF(ISNULL(last_name), '', last_name))";
                        
			$obj->ORDER_BY_FIELDS = "orgunit_id, employee_id";
			// $obj->IS_LOOKUP = true;
			// $obj->IS_SMALL_LOOKUP = true;

			$obj->UNIQUE_KEY = array('orgunit_id', 'employee_id');

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
			AdmEmployeeArTranslator::initData();
			AdmEmployeeEnTranslator::initData();
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
			'EDIT_IF_EMPTY' => true,
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
					'READONLY' => true,
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
						'STEP' => 1,
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
						'STEP' => 1,
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
						'STEP' => 1,
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
						'STEP' => 1,
						'SEARCH-BY-ONE' => '',
						'DISPLAY' => false,
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
			'READONLY' => true,
			'SIZE' => 64,
			'CSS' => 'width_pct_50',
			'MB_CSS' => 'width_pct_50',
			'FORMAT' => 'EMAIL',
			'UTF8' => false,
			'TYPE' => 'TEXT',
			'CATEGORY' => 'SHORTCUT',
			'SHORTCUT' => 'employee_id.email',
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
		),

		'employeeScopeList' => array('STEP' => 2, 'EDIT' => true,  'QEDIT' => false, 
				'SHORTNAME' => 'employeeScopes',  'SHOW' => true,  
				'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  
				'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  				
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
				'MANDATORY' => false,  'UTF8' => false,  
				'TYPE' => 'FK',  
				'CATEGORY' => 'ITEMS',  'ANSWER' => 'employee_scope',  'ANSMODULE' => 'adm',  'ITEM' => 'adm_employee_id',  
				'READONLY' => true,  'CAN-BE-SETTED' => false, 
				'CSS' => 'width_pct_100', ),
/*
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
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
		),

		'hierarchy_level_enum' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 40,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',   'DEFAUT' => 1,  'SHORTNAME' => 'lang',  
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  'MANDATORY' => true,
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 1, 
				),

		'requests_nb' => array(
			'SEARCH' => true,
			'QSEARCH' => false,
			'SHOW' => true,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => false,
			'CSS' => 'width_pct_25',
			'SIZE' => 32,
			'MANDATORY' => true,
			'UTF8' => false,
			'TYPE' => 'INT',
			'DEFAUT' => 15,
			'READONLY' => false,
			'SEARCH-BY-ONE' => false,
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'ERROR-CHECK' => true,
		),*/

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

		/*
		'appointment' => array(
			'SHOW' => true,
			'RETRIEVE' => true,
			'SEARCH' => true,
			'QSEARCH' => true,
			'EDIT' => true,
			'QEDIT' => true,
			'DEFAUT' => 'N',
			'TYPE' => 'YN',
			'SEARCH-BY-ONE' => true,
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),

		
		'files' => array(
			'SHOW' => true,
			'RETRIEVE' => true,
			'SEARCH' => true,
			'QSEARCH' => true,
			'EDIT' => true,
			'QEDIT' => true,
			'DEFAUT' => 'N',
			'TYPE' => 'YN',
			'SEARCH-BY-ONE' => true,
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),

		'super_admin' => array(
			'SHOW' => true,
			'RETRIEVE' => true,
			'SEARCH' => true,
			'QSEARCH' => true,
			'EDIT' => true,
			'QEDIT' => true,
			'DEFAUT' => 'N',
			'TYPE' => 'YN',
			'SEARCH-BY-ONE' => true,
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),


		'requests_count' => array(
			'SHOW' => true,
			'CSS' => 'width_pct_25',
			'CATEGORY' => 'FORMULA',
			'TYPE' => 'INT',
			'EDIT' => true,
			'READONLY' => true,
			'RETRIEVE' => false,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),


		'done_requests_count' => array(
			'SHOW' => true,
			'CSS' => 'width_pct_25',
			'CATEGORY' => 'FORMULA',
			'TYPE' => 'INT',
			'EDIT' => true,
			'READONLY' => true,
			'RETRIEVE' => false,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),

		'ongoing_requests_count' => array(
			'SHOW' => true,
			'CSS' => 'width_pct_25',
			'CATEGORY' => 'FORMULA',
			'TYPE' => 'INT',
			'EDIT' => true,
			'READONLY' => true,
			'RETRIEVE' => false,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),

		'inbox_count' => array(
			'SHOW' => true,
			'CSS' => 'width_pct_25',
			'CATEGORY' => 'FORMULA',
			'TYPE' => 'INT',
			'EDIT' => true,
			'READONLY' => true,
			'RETRIEVE' => false,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),


		'statif_pct' => array(
			'SHOW' => true,
			'CSS' => 'width_pct_25',
			'CATEGORY' => 'FORMULA',
			'TYPE' => 'PCTG',
			'UNIT' => '%',
			'EDIT' => true,
			'READONLY' => true,
			'RETRIEVE' => true,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'STEP' => 1,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),

		'archive_date' => array('CATEGORY' => 'FORMULA', 'TYPE' => "DATE",),

		'currentRequests' => array(
			'STEP' => 2,
			'TYPE' => 'FK',
			'ANSWER' => 'request',
			'ANSMODULE' => 'adm',
			'CATEGORY' => 'ITEMS',
			'ITEM' => '', //'HIDE_COLS' => ['employee_id','orgunit_id'],
			'WHERE' => "((orgunit_id = §orgunit_id§ and employee_id = §employee_id§) or (§orgunit_id§ = '70' and supervisor_id = §employee_id§)) and status_id not in (5,6,7,8,9)",
			'FORMAT' => 'retrieve',
			'SHOW' => true,
			'EDIT' => false,
			'ICONS' => true,
			'DELETE-ICON' => false,
			'BUTTONS' => true,
			'NO-LABEL' => false,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),

		'finishedRequests' => array(
			'STEP' => 2,
			'TYPE' => 'FK',
			'ANSWER' => 'request',
			'ANSMODULE' => 'adm',
			'CATEGORY' => 'ITEMS',
			'ITEM' => '',
			'WHERE' => "((orgunit_id = §orgunit_id§ and employee_id = §employee_id§) or (§orgunit_id§ = '70' and supervisor_id = §employee_id§)) and status_id in (5,6,7,8,9) and request_date >= §archive_date§",
			'FORMAT' => 'retrieve',
			'SHOW' => true,
			'EDIT' => false,
			'ICONS' => true,
			'DELETE-ICON' => false,
			'BUTTONS' => true,
			'NO-LABEL' => false,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),

		'allOrgunitList' => array(
			'STEP' => 3,
			'TYPE' => 'FK',
			'ANSWER' => 'adm_employee',
			'ANSMODULE' => 'adm',
			'CATEGORY' => 'ITEMS',
			'ITEM' => '',
			'WHERE' => "employee_id = §employee_id§",
			'HIDE_COLS' => ["employee_id"],
			'FORMAT' => 'retrieve',
			'SHOW' => true,
			'EDIT' => false,
			'ICONS' => true,
			'DELETE-ICON' => false,
			'BUTTONS' => true,
			'NO-LABEL' => false,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),*/

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
