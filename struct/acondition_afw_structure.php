<?php 
        class AdmAconditionAfwStructure
        {
			public static function initInstance(&$obj)
			{
				if ($obj instanceof Acondition) {
					$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
					$obj->DISPLAY_FIELD = "acondition_name_ar";
					$obj->UNIQUE_KEY = array('acondition_origin_id','acondition_name_ar');
					$obj->editByStep = true;
					$obj->editNbSteps = 3;

					$obj->ORDER_BY_FIELDS = "acondition_origin_id,acondition_name_ar";

					$obj->after_save_edit = array("class"=>'AconditionOrigin',"attribute"=>'acondition_origin_id', "currmod"=>'adm',"currstep"=>3);
					$obj->public_display = true;
				}
				else 
				{
						AconditionArTranslator::initData();
						AconditionEnTranslator::initData();
				}
			}
			
                public static $DB_STRUCTURE = array(

                        
		'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
				'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

				

		'general' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  
		        'DEFAULT' => 'W',  'READONLY' => false, // قد يكون الشرط يطبق في المراحل الخاصة وهو شرط عام على جميع فروع التقديم
				'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 'W-IS-VALUE' => true, 
				/* 'DISABLE-READONLY-ADMIN' => true,*/
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),
		
		
		'acondition_type_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'UTF8' => false,  
				'READONLY' => true, 'DISABLE-READONLY-ADMIN' => true,
				'TYPE' => 'FK',  'ANSWER' => 'acondition_type',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAULT' => 1,    
				'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true,
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50', ),	
		
		'acondition_origin_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'acondition_origin',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
				'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY' => true, 'DISABLE-READONLY-ADMIN' => true,
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50', ),					
		
		
				
		'active' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'DEFAUT' => 'Y',  
				'TYPE' => 'YN',    'DISPLAY' => '',  'STEP' => 1, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),


		
		'acondition_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-AR' => true,  
				'EDIT' => true,  'QEDIT' => true,  'SIZE' => '', 'MAXLENGTH' => '128', 'UTF8' => true,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),
				
		
		
		'acondition_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-EN' => true,  
				'EDIT' => true,  'QEDIT' => true,  'SIZE' => '', 'MAXLENGTH' => '128', 'UTF8' => false,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),
		
		

		'acondition_desc_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => true,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),        
		
		'acondition_desc_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => false,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),        

		'radical' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
				'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),
		
		'composed' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
				'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 'W-IS-VALUE' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),
		
				
		
		'condition_1_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'acondition',  'RELATION' => 'OneToMany', 
				'WHERE' => "acondition_origin_id=§acondition_origin_id§ and acondition_type_id=3",
				'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
				'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_75', ),	
		
		
		'operator_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
				'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25', ),	
		
		
		'condition_2_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'acondition',  'RELATION' => 'OneToMany',
				'WHERE' => "acondition_origin_id=§acondition_origin_id§ and acondition_type_id=3",
				'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
				'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_75', ),	

				'application_table_id' => array(
					'TYPE' => 'TEXT', 'NO-COTE' => true,   
					'CATEGORY' => 'FORMULA',  'SEARCH-BY-ONE' => '',  'DISPLAY' => '', 
					'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
					),	
				
					
		'afield_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'application_field',  'ANSMODULE' => 'adm', 
				'WHERE' => "usable_in_conditions='Y' and application_table_id in (§application_table_id§)", 
				'SIZE' => 40,  'DEFAUT' => 0, 'AUTOCOMPLETE' => true,   
				'DEPENDENT_OFME' => ['aparameter_id', ],
				'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50', ),	
				
						'afield_type_id' => array('CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'afield_id.application_field_type_id', 	
								'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 'FUNCTION_COL_NAME' => 'afield_type_enum',
								// 'SHOW' => true, 'STEP' => 2, 'EDIT' => true, 
								'STEP' => 99,
						),	
		
		
		'compare_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'UTF8' => false,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
				'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25', ),	
		
		
		'aparameter_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'aparameter',  'ANSMODULE' => 'adm',  
				// 'WHERE' => "afield_type_id = §afield_type_id§",
				// I remove this above because 5 shoud be in (5,6) not = 6
				// @to-review
				'DEPENDENCIES' => ['afield_id', ],
				'SIZE' => 40,  'DEFAUT' => 0,    
				'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 'DNA' => true,
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25', ),	
		
		
		'excuse_text_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => true,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),        
		
		
		
		'excuse_text_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => false,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),   
				
		
		
		
		
		'priority' => array(
				'IMPORTANT' => 'IN',
				'SHOW' => true,
				'RETRIEVE' => false,
				'QEDIT' => true,
				'EDIT' => true,
				'TYPE' => 'INT',
				'STEP' => 3,
				'DISPLAY-UGROUPS' => '',
				'EDIT-UGROUPS' => '',
				'CSS' => 'width_pct_25',),
		
		
		
		'unique_apply' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
				'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),
		
		
		
		'known_already' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
				'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),
		
		
		
		'show_fe' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAULT' => 'Y',  
				'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3, 'FORMAT' => 'icon', 
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),
		
		
		/*
		'bfunction_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'screen_model',  'ANSMODULE' => 'adm', 
				'WHERE' => "1=0",
				'SIZE' => 40,  'DEFAUT' => 0,    
				'DISPLAY' => true,  'STEP' => 99,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25', ), */
		
				
												'created_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  
														'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
														'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
														'CSS' => 'width_pct_100',),
		
												'created_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  
														'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
														'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
														'CSS' => 'width_pct_100',),
		
												'updated_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  
														'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
														'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
														'CSS' => 'width_pct_100',),
		
												'updated_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  
														'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
														'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
														'CSS' => 'width_pct_100',),
		
												'validated_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  
														'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
														'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
														'CSS' => 'width_pct_100',),
		
												'validated_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  
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
																				'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
		
												'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true, 
																				'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),	
                        
                ); 
        } 
?>