<?php 
        class AdmApplicationFieldAfwStructure
        {

			public static function initInstance(&$obj)
                {
                        if ($obj instanceof ApplicationField) 
                        {
                            $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
							$obj->CORRECT_IF_ERRORS = true;
							$obj->DISPLAY_FIELD_BY_LANG = ['ar'=>["field_title_ar", "additional"], 'en'=>["field_title_en", "additional"]];
							$obj->AUTOCOMPLETE_FIELD = "field_title_ar";
							$obj->ORDER_BY_FIELDS = "application_table_id, field_order, id";
							$obj->UNIQUE_KEY = array("application_table_id","field_name");
							$obj->editByStep = true;
							$obj->IS_LOOKUP = true;
							$obj->editNbSteps = 4;
							$obj->showQeditErrors = true;
							$obj->showRetrieveErrors = true;
							$obj->nbQeditLinksByRow = 5;
							$obj->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
							$obj->OBJECT_CODE = "field_name";
							//$obj->qedit_minibox = true;    
                            // $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
                        }
                }

                public static $DB_STRUCTURE = array(

                        
			'id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  
				'EXCEL' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'PK',    'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
				'CSS' => 'width_pct_25',
				),

			'field_name' => array('SHOW' => true,  'SEARCH' => true, 'QSEARCH' => true, 'RETRIEVE' => false,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 25,  'STYLE' => 'width:150px', 'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 'CSS' => 'width_pct_25',
				),

				


			'application_table_id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 'READONLY' => true, 'DISABLE-READONLY-ADMIN'=> true,
				/*'ANSWER' => 'application_table',  'ANSMODULE' => 'adm', */
				'SIZE' => 40,  'DEFAUT' => 0,   
				'WHERE' => "", 'CSS' => 'width_pct_25',				 
				'RELATION' => 'OneToMany',  'CONTEXT-ANSWER' => 'getContextTables',  
				'SEARCH' => true, 'SEARCH-BY-ONE' => true,  'QSEARCH' => true,  'AUTOCOMPLETE-SEARCH' => true,  
				'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'application_field_type_id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 'FUNCTION_COL_NAME' => 'afield_type_enum',
				/*'ANSWER' => 'application_field_type',  'ANSMODULE' => 'adm', */ 
				'SIZE' => 40,  'DEFAUT' => 0,  'STYLE' => 'width:150px',  'SHORTNAME' => 'ftype',    'NO_KEEP_VAL' => true, 
				'LOAD_ALL' => true,  'NO-COTE' => true,  'SEARCH' => true,  'SEARCH-BY-ONE' => true,  'QSEARCH' => true,  
				'DISPLAY' => true,  'STEP' => 1, 'CSS' => 'width_pct_25', 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
				),

		

			'field_title_ar' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH-AR' => true,  'RETRIEVE-AR' => false,  
				'QEDIT' => false,  'EDIT' => true,  'UTF8' => true,  'SIZE' => 64,  
				'TYPE' => 'TEXT',    'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1, 'CSS' => 'width_pct_50', 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 'DISABLE-READONLY-ADMIN'=> true,
				),

			'field_title_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH-EN' => true,  'RETRIEVE-EN' => false,  
				'QEDIT' => false,  'EDIT' => true,  'SIZE' => 64, 'CSS' => 'width_pct_50', 
				'TYPE' => 'TEXT',    'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 'DISABLE-READONLY-ADMIN'=> true,
				),

			
			/*	
			'shortname' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false, 
				'UTF8' => true,    'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SEARCH' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 15,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 'CSS' => 'width_pct_25',
				),*/

				
			'reel' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH' => true,  'QSEARCH' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',    'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'STEP' => 2,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 'CSS' => 'width_pct_25',
				),


				

			'additional' => array('IMPORTANT' => 'IN',  'SHOW' => true, 'SEARCH' => true,  'QSEARCH' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',    'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 'CSS' => 'width_pct_25',
				),


				'html_description' => array(
							'STEP' => 99,
							'TYPE' => 'TEXT',
							'CATEGORY' => 'FORMULA',
							'SHOW' => true,
							'EDIT' => true,
							'RETRIEVE' => true, 
							'READONLY' => true,
							"CAN-BE-SETTED" => false,
							'SIZE' => 255,
							"NO-LABEL" => true,
							'CSS' => 'width_pct_100',
							'INPUT_WIDE' => true
					),

			'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
				'TYPE' => 'YN', 'FORMAT' => 'icon',  'STEP' => 4,  
				'READONLY' => true, 
				'CSS' => 'width_pct_25',),

			'usable_in_conditions' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH' => true,  'QSEARCH' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => false,  
				'QEDIT_FGROUP' => true,  'SEARCH-BY-ONE' => true,  'EDIT_FGROUP' => true, 
				'STEP' => 2, 'TYPE' => 'YN',  'DEFAUT' => 'Y', 'DISPLAY' => true,   
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_25',
				),	

			'unit' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'SIZE' => 25,    'EDIT_FGROUP' => true,  
				'QEDIT_FGROUP' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
				),

			'unit_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,  'SIZE' => 25,    'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
				),

			'field_order' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  
				'TYPE' => 'INT',    'MANDATORY' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,  'ERROR-CHECK' => true, 
				),

			'field_num' => array('SHOW' => true,  'RETRIEVE' => false,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  
				'TYPE' => 'INT',    'MANDATORY' => false,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,  'ERROR-CHECK' => true, 
				),

			'field_size' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE_FGROUP' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'INT',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,    
				'STEP' => 2,  'FIELD_RULES-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
				),

			


				'formula_field_1_id' => array('STEP' => 3, 
                        'SHORTNAME' => 'field_1',
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
                        'REQUIRED' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'application_field',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'ManyToOne',
                        'READONLY' => false,
                        'DNA' => true,
                        'AUTOCOMPLETE' => true,
                        'CSS' => 'width_pct_33',
                ),

                'formula_field_2_id' => array('STEP' => 3, 
                        'SHORTNAME' => 'field_2',
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
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'application_field',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'ManyToOne',
                        'READONLY' => false,
                        'DNA' => true,
                        'AUTOCOMPLETE' => true,
                        'CSS' => 'width_pct_33',
                ),

                'formula_field_3_id' => array('STEP' => 3, 
                        'SHORTNAME' => 'field_3',
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
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'application_field',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'ManyToOne',
                        'READONLY' => false,
                        'DNA' => true,
                        'AUTOCOMPLETE' => true,
                        'CSS' => 'width_pct_33',
                ),

				'qsearch' => array('FGROUP' => 'modes', 'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
									'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 3,  
									'READONLY' => "::af_manager", 
									'CSS' => 'width_pct_25',),
				'retrieve' => array('FGROUP' => 'modes', 'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
									'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 3,  
									'READONLY' => "::af_manager", 
									'CSS' => 'width_pct_25',),
				'edit' => array('FGROUP' => 'modes', 'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
									'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 3,  
									'READONLY' => "::af_manager", 
									'CSS' => 'width_pct_25',),
				'qedit' => array('FGROUP' => 'modes', 'SHOW' => true,  'RETRIEVE' => true, 
				 					'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
									'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 3,  
									'READONLY' => "::af_manager", 
									'CSS' => 'width_pct_25',),

				'readonly' => array('FGROUP' => 'modes', 'SHOW' => true,  'RETRIEVE' => true,  
									'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
									'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 3,  
									'READONLY' => "::af_manager", 
									'CSS' => 'width_pct_25',),

				'mandatory' => array('FGROUP' => 'modes', 'SHOW' => true,  'RETRIEVE' => true,  
									'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
									'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 3,  
									'READONLY' => "::af_manager", 
									'CSS' => 'width_pct_25',),

				'step' => array('FGROUP' => 'modes', 'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
									'TYPE' => 'INT', 'STEP' => 3,  
									'READONLY' => "::af_manager", 
									'CSS' => 'width_pct_25',),

				'width_pct' => array('FGROUP' => 'modes', 'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
									'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'STEP' => 3,  
									'READONLY' => "::af_manager", 
									'CSS' => 'width_pct_25',),

													


        					
 					

				/*
			'help_text' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,    'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'SIZE' => 'AEREA',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
				),

			'help_text_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,    'EDIT_FGROUP' => false,  'QEDIT_FGROUP' => true,  
				'SIZE' => 'AEREA',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
				),

			'question_text' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,    'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'SIZE' => 'AEREA',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
				),

			'question_text_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,    'EDIT_FGROUP' => false,  'QEDIT_FGROUP' => true,  
				'SIZE' => 'AEREA',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
				),*/

			
		

		'usagePanel' => array(
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

		'created_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

		'created_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
				'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

		'updated_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

		'updated_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
				'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

		'validated_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

		'validated_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
				'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

		


		'version'                  => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
										'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),

		'update_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
										'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

		'delete_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
										'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

		'display_groups_mfk'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
										'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

		'sci_id'                        => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
										'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),

		'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
										'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				




                        
                ); 
        } 
?>