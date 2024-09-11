<?php 
        class AdmAconditionOriginAfwStructure
        {
                
			public static function initInstance(&$obj)
			{
				if ($obj instanceof AconditionOrigin) 
				{
					$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
					$obj->DISPLAY_FIELD = "acondition_origin_name_ar";
					$obj->ORDER_BY_FIELDS = "acondition_origin_type_id,acondition_origin_order";
					$obj->UNIQUE_KEY = array('acondition_origin_type_id','acondition_origin_order');
					$obj->public_display = true;

					$obj->editByStep = true;
					$obj->editNbSteps = 3; 
					$obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
				}
			}
			
			
			public static $DB_STRUCTURE = array(

                        
			'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
				'TYPE' => 'PK',    'DISPLAY' => false,  'STEP' => 1,  'QSEARCH' => true,
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),

			'hijri_current' => array(
					'TYPE' => 'DATE',  
					'CATEGORY' => 'FORMULA',  'SEARCH-BY-ONE' => '',  'DISPLAY' => '', 
					'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
					),	

			'acondition_origin_type_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'acondition_origin_type',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25', ),			
				
			'acondition_origin_order' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'INT',    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),	
				
			'general' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
				'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),

			'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'DEFAUT' => 'Y',  
				'TYPE' => 'YN',  'FORMAT' => 'icon',  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),

			'acondition_origin_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-AR' => true,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'UTF8' => true,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),

			'acondition_origin_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-EN' => true,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'UTF8' => false,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_50',),

			'afile_id' => array('SHORTNAME' => 'file',  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'INPUT_WIDE' => true,  'QEDIT' => true,  'SIZE' => 255,  
				'TYPE' => 'FK',  'ANSWER' => 'adm_file',  'ANSMODULE' => 'adm',  
				'WHERE' => "doc_type_id = 555", 'UTF8' => false,  
				 
				'RELATION' => 'ManyToOne',  'SEARCH-BY-ONE' => false,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'MANDATORY' => false,  'ERROR-CHECK' => true, 
				'CSS' => 'width_pct_33',
				),

			'valid_from_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
				'TYPE' => 'DATE',  'STEP' => 1,    'DISPLAY' => true, 'MANDATORY' => true, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_33',),

			'valid_to_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
				'TYPE' => 'DATE',  'STEP' => 1,    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_33',),
				
			'cvalid' => array('SHOW-ADMIN' => true, 'SEARCH' => true, 'QSEARCH' => true, 'RETRIEVE' => false, 'SHOW' => false, 'EDIT' => false, 'READONLY' => true,  'DEFAUT' => 'N',  
				'TYPE' => 'YN',    'CATEGORY' => 'FORMULA',  "FIELD-FORMULA"=> "IF(§hijri_current§ between valid_from_date and valid_to_date, 'Y', 'N')",
				'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_25',),				

			'acondition_origin_desc_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA',  'UTF8' => true,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

			'acondition_origin_desc_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA',  'UTF8' => true,  
				'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				'CSS' => 'width_pct_100',),

			'application_model_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'UTF8' => false, 'MANDATORY' => false,  
                                                'TYPE' => 'MFK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',   
                                                'WHERE' => 'id < 10 ',
                                                // 'DEPENDENT_OFME' => array("zzz", ),
                                                // 'DEPENDENCIES' => ['qualification_id',],
                                                'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),				

			'academic_program_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'UTF8' => false, 'MANDATORY' => false,  
                                                'TYPE' => 'MFK',  'ANSWER' => 'academic_program',  'ANSMODULE' => 'adm',   
                                                'WHERE' => 'id < 550',
                                                // 'DEPENDENT_OFME' => array("zzz", ),
                                                // 'DEPENDENCIES' => ['qualification_id',],
                                                'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

			'aconditionOriginScopeList' => array('TYPE' => 'FK', 'ANSWER' => 'acondition_origin_scope', 'ANSMODULE' => 'adm', 
												'CATEGORY' => 'ITEMS', 'ITEM' => 'acondition_origin_id', 'STEP' => 2, 
												// 'WHERE'=>'xxx = §xxx§', 'HIDE_COLS' => array(),
												'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
												'ICONS'=>true, 'DELETE-ICON'=>true, 'BUTTONS'=>true, 'NO-LABEL'=>false),
												
			'aconditionList' => array(
					'TYPE' => 'FK',  'ANSWER' => 'acondition',  'ANSMODULE' => 'adm', 'STEP' => 3,    
					'CATEGORY' => 'ITEMS',  'ITEM' => 'acondition_origin_id',  
					'WHERE' => "", 
					'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  
					'DELETE-ICON' => false,  'BUTTONS' => true,    'DISPLAY' => true, 
					'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
					'CSS' => 'width_pct_100',),

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
							'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'pag', 'FGROUP' => 'tech_fields'),

			'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 
							'TOKEN_SEP'=>"§", 'READONLY'=>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),				





                        
                ); 
        } 
?>