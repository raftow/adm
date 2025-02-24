<?php 
        class AdmAdmOrgunitAfwStructure
        {
                public static $DB_STRUCTURE = array(

                        
			'id' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'PK',  'TECH_FIELDS-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'orgunit_id' => array('SHORTNAME' => 'orgunit',  'SEARCH' => true,  'QSEARCH' => false,  
			    'INTERNAL_QSEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => false, 
				'TECH_FIELDS-RETRIEVE' => true,  'SIZE' => 40, 'CSS' => 'width_pct_75',   'MANDATORY' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  
				'WHERE' => 'id not in (
					 			select orgunit_id 
								from §DBPREFIX§adm.adm_orgunit 
					            where orgunit_id != §orgunit_id§
								) 
					        and id in (
							         select id_sh_org from §DBPREFIX§hrm.employee where active=\'Y\' and id_sh_org is not null
						              union 
								     select id_sh_dep from §DBPREFIX§hrm.employee where active=\'Y\' and id_sh_dep is not null
								      union
								     select id_sh_div from §DBPREFIX§hrm.employee where active=\'Y\' and id_sh_div is not null
									)',
				'RELATION' => 'OneToMany',  'READONLY' => false,  'SEARCH-BY-ONE' => false, 
				'DISPLAY' => true, 'AUTOCOMPLETE' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),
					/*
					'new_requests_count' => array('SHOW' => true,  
							'CSS' => 'width_pct_25',  
							'CATEGORY' => 'FORMULA',  
							'TYPE' => 'INT',  'EDIT' => true,  'READONLY' => true,  'HIDE_IF_NEW' => true,
							'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),				

					'requests_count' => array('SHOW' => true,  
							'CSS' => 'width_pct_25',  
							'CATEGORY' => 'FORMULA',  
							'TYPE' => 'INT',  'EDIT' => true,  'READONLY' => true,  'HIDE_IF_NEW' => true,  
							'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),

			'requests_nb' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32, 'CSS' => 'width_pct_25', 
				'MANDATORY' => true,  'UTF8' => false,  
				'TYPE' => 'INT',  'READONLY' => false,  'SEARCH-BY-ONE' => false,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'service_category_mfk' => array('SHORTNAME' => 'categorys',  'SEARCH' => true,  'QSEARCH' => true,  
				'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  
				'MANDATORY' => true,  'UTF8' => false, 'DEFAULT' => ',1,',  
				'TYPE' => 'MFK',  'ANSWER' => 'service_category',  'ANSMODULE' => 'adm',  'READONLY' => false,  
				'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'service_mfk' => array('SHORTNAME' => 'services',  'SEARCH' => true,  'QSEARCH' => true,  
				'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  
				'MANDATORY' => true,  'UTF8' => false, 'DEFAULT' => ',1,',  
				'TYPE' => 'MFK',  'ANSWER' => 'service',  'ANSMODULE' => 'adm',  'READONLY' => false,  
				'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),*/

					'allEmployeeList' => array('STEP' => 3, 'FGROUP' => 'allEmployeeList',  
							'TYPE' => 'FK',  'ANSWER' => 'adm_employee',  'ANSMODULE' => 'adm',  
							'CATEGORY' => 'ITEMS',  'ITEM' => '',  
							'WHERE' => "orgunit_id = §orgunit_id§", 
							'HIDE_COLS' => ["orgunit_id"],
							'FORCE_COLS' => ["inbox_count"],
							'FORMAT' => 'retrieve',  'SHOW' => true, 'RETRIEVE' => false,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
							),

					'allEmployeeRequestList' => array('STEP' => 2, 'FGROUP' => 'allEmployeeList',  
							'TYPE' => 'FK',  'ANSWER' => 'adm_emp_request',  'ANSMODULE' => 'adm',  
							'CATEGORY' => 'ITEMS',  'ITEM' => '',  
							'WHERE' => "orgunit_id = §orgunit_id§", 
							'HIDE_COLS' => ["orgunit_id"],
							// 'FORCE_COLS' => ["inbox_count"],
							'FORMAT' => 'retrieve',  'SHOW' => true, 'RETRIEVE' => false,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  			
						),

					/*	'currentRequests' => array('STEP' => 3,  
							'TYPE' => 'FK',  'ANSWER' => 'request',  'ANSMODULE' => 'adm',  
							'CATEGORY' => 'ITEMS',  'ITEM' => '', 'DO-NOT-RETRIEVE-COLS' => ['man','service_satisfied'],
							'WHERE' => "request_date >= §archive_date§ and supervisor_id > 0 and orgunit_id > 0 and orgunit_id = §orgunit_id§ and status_id in (2, 4, 201)", 
							'FORMAT' => 'retrieve',  'SHOW' => true,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
							),

						
					'unAssignedRequests' => array('STEP' => 3,  
							'TYPE' => 'FK',  'ANSWER' => 'request',  'ANSMODULE' => 'adm',  
							'CATEGORY' => 'ITEMS',  'ITEM' => '',  
							'WHERE' => "request_date >= §archive_date§ and ((orgunit_id = 0 and supervisor_id = 0) or (orgunit_id = §orgunit_id§ and employee_id = 0))",
							'FORMAT' => 'retrieve',  'SHOW' => true,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
							),	*/			


			'active' => array('SHOW-ADMIN' => true,  'RETRIEVE' => true,  'EDIT' => false,  'QEDIT' => false,  'DEFAUT' => 'Y',  
				'TYPE' => 'YN',  'SEARCH-BY-ONE' => '',  'DISPLAY' => '',  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

                        'created_by'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'created_at'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        'updated_by'           => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'updated_at'              => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        'validated_by'       => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'validated_at'          => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        /* 'active'                   => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),*/

                        'version'                  => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),

                        // 'draft'                         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
                        //                                        'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),

                        'update_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'delete_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'display_groups_mfk'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'sci_id'                        => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),

                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 
                                                                'TOKEN_SEP'=>"§", 'READONLY'=>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
                ); 
        } 
?>