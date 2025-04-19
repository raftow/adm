<?php 
        class AdmApplicationDesireAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof ApplicationDesire) 
                        {
                                $multiple_key_cols = "applicant_id,application_plan_id,application_simulation_id,desire_num";
                                $part_cols = "applicant_id";
                                $context_cols = "";
                                $obj->PK_MULTIPLE = "|";
                                $obj->PK_MULTIPLE_ARR = explode(",",$multiple_key_cols);

                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = ["desire_num", "application_plan_branch_id"];
                                $obj->DISPLAY_SEPARATOR = "-";
                                $obj->ORDER_BY_FIELDS = "applicant_id, application_plan_id, application_simulation_id, desire_num";
                                // $obj->UNIQUE_KEY = array('applicant_id','application_plan_id', 'application_simulation_id','application_plan_branch_id'); big one
                                $obj->UNIQUE_KEY = array('applicant_id','application_plan_id', 'application_simulation_id', 'desire_num');
                                $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;
                                $obj->MOVE_UP_ACTION = true;
                                $obj->editByStep = true;
                                $obj->editNbSteps = 4;
                                $obj->setContextAndPartitionCols($part_cols, $context_cols);
                                $obj->setMultiplePK($multiple_key_cols,$obj->PK_MULTIPLE); 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                        else 
                        {
                                ApplicationDesireArTranslator::initData();
                                ApplicationDesireEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'gender_enum' => array(
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => false,
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'EDIT' => true,
                                                'QEDIT' => true,
                                                'QSEARCH' => false,
                                                'REQUIRED' => true,
                                                'UTF8' => false,
                                                'TYPE' => 'ENUM',
                                                'ANSWER' => 'FUNCTION',
                                                'SIZE' => 40,
                                                'DEFAUT' => 0,
                                                'DISPLAY' => true,
                                                'STEP' => 1,
                                                'READONLY' => true,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',
                                        ),

                                        'applicant_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'applicant',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),
                                                
                                        'idn' => array(
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'QSEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'EDIT' => true,
                                                'QEDIT' => true,
                                                'SIZE' => '32',
                                                'MAXLENGTH' => '32',
                                                'TYPE' => 'TEXT',
                                                'DISPLAY' => true,
                                                'STEP' => 1,
                                                'REQUIRED' => true,
                                                'READONLY' => true,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'TEXT-SEARCHABLE-SEPARATED' => true,
                                                'FORMAT' => 'ALPHA-NUMERIC',
                                                'CSS' => 'width_pct_50'
                                        ),


                                        'application_plan_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),

                                        'application_simulation_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_simulation',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 1,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),        
                                                
                                        'application_model_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),

                                        'academic_level_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'academic_level',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 
                                                'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),

                                        'desire_num' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'QEDIT' => true,
                                                'EDIT' => true, 'READONLY'=>true,
                                                'TYPE' => 'INT', 'MANDATORY' => true, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),


                                        'application_plan_branch_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_plan_branch',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),

                                        'application_model_branch_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model_branch',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),                                                
                                        
                                        // 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'application_plan_branch_id.training_unit_id',                                                

                                        'training_unit_id' => array('SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'training_unit',  'ANSMODULE' => 'adm',  
                                                        'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'READONLY'=>true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),

                                        'training_unit_type_id' => array('SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'training_unit_type',  'ANSMODULE' => 'adm',  
                                                        'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'READONLY'=>true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),  
                                                        
                                        'sorting_group_id' => array('SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'sorting_group',  'ANSMODULE' => 'adm',  
                                                        'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'READONLY'=>true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),


                                        'application_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),
                                                
                                        

                                        
                                                
                                        'applicant_qualification_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => true, 'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'applicant_qualification',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => true,'AUTOCOMPLETE-SEARCH'=> true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'qualification_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'qualification',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'major_category_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'major_category',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'weighted_percentage' => array(
                                                                'FGROUP' => 'weighted_percentage',
                                                                'STEP' => 2,
                                                                'TYPE' => 'FLOAT',
                                                                'CATEGORY' => 'FORMULA',
                                                                'SHOW' => true,
                                                                'EDIT' => true,
                                                                'READONLY' => true,
                                                                "CAN-BE-SETTED" => false,
                                                                'SIZE' => 255,
                                                                'CSS' => 'width_pct_25',
                                                        ),

                                        'weighted_percentage_details' => array(
                                                'FGROUP' => 'weighted_percentage',
                                                'STEP' => 2,
                                                'TYPE' => 'TEXT',
                                                'CATEGORY' => 'FORMULA',
                                                'SHOW' => true,
                                                'EDIT' => true,
                                                'READONLY' => true,
                                                "CAN-BE-SETTED" => false,
                                                'SIZE' => 255,
                                                'CSS' => 'width_pct_75',
                                        ), 

                                        'health_ind' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 2,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),     

                                        
                                        'current_fields_matrix' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'TEXT',  'SIZE' => 'AREA', 'FORMAT' => 'HTML', 'STEP' => 2,
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
								'CSS' => 'width_pct_100',),

                                        'step_num' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'QEDIT' => true, 'READONLY'=>true,
                                                'EDIT' => true, 
                                                'TYPE' => 'INT', 'MANDATORY' => true, 
                                                'STEP' => 3,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_50',),
                                                
                                        'application_step_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_step',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 3,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	

                                        'desire_status_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 3, 'MANDATORY' => true, 'READONLY'=>true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	

                                        'comments' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '128', 'MAXLENGTH' => '128', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 3, 'MANDATORY' => false, 'READONLY'=>true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_75',),                                                                

                                        'applicationConditionExecList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                                'EDIT' => false,  'QEDIT' => false, 'STEP' => 4, 
                                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                                'TYPE' => 'FK',  
                                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'application_condition_exec',  'ANSMODULE' => 'adm',  'ITEM' => 'adesire_id',  'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                                'CSS' => 'width_pct_100', ),



                                        'active' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
        
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
                                                                        'TYPE' => 'INT', /*stepnum-not-the-object*/ 'ANSMODULE' => 'pag', 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>