<?php 
        class AdmApplicationFieldAfwStructure
        {

			public static function initInstance(&$obj)
                {
                        if ($obj instanceof ApplicationField) 
                        {
                            $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
							$obj->CORRECT_IF_ERRORS = true;
							$obj->DISPLAY_FIELD = "titre_short";
							$obj->ORDER_BY_FIELDS = "application_table_id, field_order, id";
							$obj->UNIQUE_KEY = array("application_table_id","field_name");
							$obj->editByStep = true;
							$obj->editNbSteps = 8;
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

                        
			'id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'PK',  'FGROUP' => 'general_props',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_name' => array('IMPORTANT' => 'IN',  'SHORTNAME' => 'name',  'SHOW' => true,  'SEARCH' => true,  'RETRIEVE' => true,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 25,  'STYLE' => 'width:150px',  'FGROUP' => 'general_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  'ALL_FGROUP' => true,  'ALL-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'shortname' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'UTF8' => true,  'FGROUP' => 'general_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SEARCH' => true,  'RETRIEVE_FGROUP' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 15,  'GENERAL_PROPS-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),


			'application_table_id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'ALL-RETRIEVE' => false,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',
				/*'ANSWER' => 'application_table',  'ANSMODULE' => 'adm', */
				'SIZE' => 40,  'DEFAUT' => 0,  'SHORTNAME' => 'table',  'FGROUP' => 'general_props',  'AUTOCOMPLETE' => true,  
				'WHERE' => "", 
				 
				'RELATION' => 'OneToMany',  'CONTEXT-ANSWER' => 'getContextTables',  'SEARCH' => true,  'SEARCH-BY-ONE' => true,  'QSEARCH' => true,  'AUTOCOMPLETE-SEARCH' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'application_field_type_id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 
				/*'ANSWER' => 'application_field_type',  'ANSMODULE' => 'adm', */ 
				'SIZE' => 40,  'DEFAUT' => 0,  'STYLE' => 'width:150px',  'SHORTNAME' => 'ftype',  'FGROUP' => 'general_props',  'NO_KEEP_VAL' => true,  'LOAD_ALL' => true,  'NO-COTE' => true,  'SEARCH' => true,  'SEARCH-BY-ONE' => true,  'QSEARCH' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		

			'field_title_ar' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH-AR' => true,  'RETRIEVE-AR' => true,  
				'QEDIT' => false,  'EDIT' => true,  'UTF8' => true,  'SIZE' => 64,  
				'TYPE' => 'TEXT',  'FGROUP' => 'step_group',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_title_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH-EN' => true,  'RETRIEVE-EN' => true,  
				'QEDIT' => false,  'EDIT' => true,  'SIZE' => 64,  
				'TYPE' => 'TEXT',  'FGROUP' => 'step_group',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'reel' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH' => true,  'QSEARCH' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',  'FGROUP' => 'step_group',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'additional' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'generation',  'STEP' => 8,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'unit' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'SIZE' => 25,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'unit_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,  'SIZE' => 25,  'FGROUP' => 'other_props',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_order' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  
				'TYPE' => 'INT',  'FGROUP' => 'advanced_props',  'MANDATORY' => true,  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'field_num' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  
				'TYPE' => 'INT',  'FGROUP' => 'advanced_props',  'MANDATORY' => true,  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'field_size' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE_FGROUP' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'INT',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'field_rules',  'STEP' => 7,  'FIELD_RULES-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'help_text' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'SIZE' => 'AEREA',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'help_text_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => false,  'QEDIT_FGROUP' => true,  
				'SIZE' => 'AEREA',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'question_text' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'SIZE' => 'AEREA',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'question_text_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => false,  'QEDIT_FGROUP' => true,  
				'SIZE' => 'AEREA',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),


                        
                ); 
        } 
?>