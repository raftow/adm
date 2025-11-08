<?php 
        class AdmApplicationAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof Application) 
                        {
                                $multiple_key_cols = "applicant_id,application_plan_id,application_simulation_id";
                                $part_cols = "applicant_id";
                                $context_cols = "";
                                $obj->PK_MULTIPLE = "|";
                                $obj->PK_MULTIPLE_ARR = explode(",",$multiple_key_cols);

                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = array('applicant_id','application_plan_id', 'application_simulation_id');
                                $obj->ORDER_BY_FIELDS = "applicant_id, application_plan_id, application_simulation_id";
                                $obj->UNIQUE_KEY = array('applicant_id','application_plan_id','application_simulation_id');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 6; 
                                $obj->setContextAndPartitionCols($part_cols, $context_cols);
                                $obj->setMultiplePK($multiple_key_cols,$obj->PK_MULTIPLE); 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                        else 
                        {
                                ApplicationArTranslator::initData();
                                ApplicationEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'applicant_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'applicant',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'AUTOCOMPLETE' => true,'AUTOCOMPLETE-SEARCH' => true,
                                                'QSEARCH' => false, 'OTM-NO-LABEL' => true,
                                                'CSS' => 'width_pct_25', 'NO-REVERSE' => true,),	

                                                'gender_enum' => array(
                                                        'CATEGORY' => 'SHORTCUT',
                                                        'SHORTCUT' => 'applicant_id.gender_enum',
                                                        'SHOW' => true,
                                                        'EDIT' => true,
                                                        'TYPE' => 'ENUM',
                                                        'ANSWER' => 'FUNCTION',
                                                        'SIZE' => 40,
                                                        'DEFAUT' => 0,
                                                        'DISPLAY' => true,
                                                        'STEP' => 99,
                                                        'DISPLAY-UGROUPS' => '',
                                                        'EDIT-UGROUPS' => '',
                                                        'CSS' => 'width_pct_25',
                                                ),

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
                                                'NO-REVERSE' => true,
                                                'READONLY' => true,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'TEXT-SEARCHABLE-SEPARATED' => true,
                                                'FORMAT' => 'ALPHA-NUMERIC',
                                                'CSS' => 'width_pct_50'
                                        ),



                                        'application_plan_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'NO-REVERSE' => true,
                                                'CSS' => 'width_pct_25', ),	


                                        'application_model_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'NO-REVERSE' => true,
                                                'CSS' => 'width_pct_25', ),	

                                                'allow_add_qualification' => array('CATEGORY' => 'SHORTCUT', 'SHORTCUT'=>'application_model_id.allow_add_qualification', 'RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N','QEDIT' => false,   
                                                        'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 99,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25',),
                                        	


                                        'application_simulation_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_simulation',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 1,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'NO-REVERSE' => true,
                                                'CSS' => 'width_pct_25', ),	

                                        /* obsolete this field program_id here because the academic_program is selected with the desire not the application (contain major etc...)
                                        'program_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'academic_program',  'ANSMODULE' => 'adm',  
                                                        'WHERE'=>"id in (select program_id from §DBPREFIX§adm.application_plan_branch where active='Y' and application_plan_id = §application_plan_id§)",
                                                        'SIZE' => 40,  'DEFAUT' => 0,     
                                                        'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),*/


                                        'applicant_qualification_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'applicant_qualification',  'ANSMODULE' => 'adm',  
                                                        'WHERE'=> "applicant_id = §applicant_id§ and (imported='Y' or §allow_add_qualification§='Y')",
                                                        'SIZE' => 40,  'DEFAUT' => 0, 'NO-REVERSE' => true,   
                                                        'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>false,                                                 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),

                                                        'qualification_mfk' => array(
                                                                'STEP' => 99,
                                                                'CATEGORY' => 'FORMULA',
                                                                'TYPE' => 'MFK',
                                                                'ANSWER' => 'qualification',
                                                                'ANSMODULE' => 'adm',
                                                                'SHOW' => true,
                                                                'NO-COTE' => true,
                                                                'EDIT' => true,
                                                                'READONLY' => true,
                                                                'NO-REVERSE' => true,
                                                                "CAN-BE-SETTED" => false,
                                                                'SIZE' => 255,
                                                                'CSS' => 'width_pct_100',
                                                        ),


                                                        'applicationQualificationList' => array(
                                                                'STEP' => 99,
                                                                'TYPE' => 'FK',
                                                                'CATEGORY' => 'ITEMS',
                                                                'ANSWER' => 'applicant_qualification',
                                                                'WHERE'=> "applicant_id = §applicant_id§ and (imported='Y' or §allow_add_qualification§='Y') and qualification_id in (0§qualification_mfk§0)",
                                                                'ANSMODULE' => 'adm',
                                                                'SHOW' => true,
                                                                'EDIT' => true,
                                                                'READONLY' => true,
                                                                'CAN-BE-SETTED' => true,
                                                                'CSS' => 'width_pct_100',
                                                        ),


                                                        

                                                                                              
                                                
                                       'weighted_percentage' => array(
                                                'FGROUP' => 'weighted_percentage',
                                                'STEP' => 5,
                                                'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                                                'CATEGORY' => 'FORMULA',
                                                'SHOW' => true,
                                                'EDIT' => true,
                                                'READONLY' => true,
                                                "CAN-BE-SETTED" => false,
                                                'SIZE' => 255,
                                                'CSS' => 'width_pct_25',
                                        ),

                                        

                                        'weighted_pctg' => array(
                                                'FGROUP' => 'weighted_percentage',
                                                'STEP' => 5,
                                                'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                                                'DEFAULT' => 0.1,
                                                'SHOW' => true,
                                                'EDIT' => true,
                                                'READONLY' => true,
                                                "CAN-BE-SETTED" => false,
                                                'NO-COTE' => true,
                                                'SIZE' => 255,
                                                'CSS' => 'width_pct_25',
                                        ),

                                        'weighted_percentage_details' => array(
                                                'FGROUP' => 'weighted_percentage',
                                                'STEP' => 5,
                                                'TYPE' => 'TEXT',
                                                'CATEGORY' => 'FORMULA',
                                                'SHOW' => true,
                                                'EDIT' => true,
                                                'READONLY' => true,
                                                'NO-REVERSE' => true,
                                                "CAN-BE-SETTED" => false,
                                                'SIZE' => 255,
                                                'CSS' => 'width_pct_75',
                                        ),         
                                               

                                        'application_status_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'READONLY'=>true,    
                                                'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 'DEFAULT' => 1,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'NO-REVERSE' => true,
                                                'CSS' => 'width_pct_25', ),

                                        'comments' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '128', 'MAXLENGTH' => '128', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false, 'READONLY'=>true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'NO-REVERSE' => true,
                                                'CSS' => 'width_pct_75',),  

                                        'assignedDesire' => array(
                                                        'STEP' => 6,
                                                        'CATEGORY' => 'FORMULA',
                                                        'TYPE' => 'FK',
                                                        'ANSWER' => 'application_desire',
                                                        'ANSMODULE' => 'adm',
                                                        'SHOW' => true,
                                                        'NO-COTE' => true,
                                                        'EDIT' => true,
                                                        'READONLY' => true,
                                                        'NO-REVERSE' => true,
                                                        "CAN-BE-SETTED" => false,
                                                        'SIZE' => 255,
                                                        'CSS' => 'width_pct_75',
                                                ),                                                
                                                
                                        'applicant_decision_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'READONLY' => true,    
                                                'DISPLAY' => true,  'STEP' => 6, 'DEFAULT' => 4,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),                                                

                                                                                        


                                        'qualification_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'qualification',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 5,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'major_category_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'major_category',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 5,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),


                                        

                                        
                                        'application_fees_paid' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'YN',  'FORMAT' => 'icon',  'STEP' => 99, 
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
								'CSS' => 'width_pct_25',),


                                        'sis_fields_available' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'YN',  'FORMAT' => 'icon',  'STEP' => 2, 
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
								'CSS' => 'width_pct_25',),

                                        'sis_fields_not_available' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'TEXT',  'STEP' => 2, 'READONLY'=>true, 'NO-REVERSE' => true,
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
								'CSS' => 'width_pct_75',),   

                                                        'program_offering_mfk' => array(
                                                                'STEP' => 98,
                                                                'TYPE' => 'MFK',
                                                                'ANSWER' => 'academic_program_offering',  'ANSMODULE' => 'adm',
                                                                'CATEGORY' => 'FORMULA',
                                                                'SHOW' => true,
                                                                'EDIT' => true,
                                                                'READONLY' => true,
                                                                'NO-REVERSE' => true,
                                                                'NO-COTE' => true,
                                                                "CAN-BE-SETTED" => false,
                                                                'SIZE' => 255,
                                                                'CSS' => 'width_pct_100',
                                                        ),                                                                  


                                        'training_period_enum' => array('IMPORTANT' => 'IN',  
                                                        'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true, 'QEDIT' => false,  'QSEARCH' => true,  
                                                        'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 'FUNCTION_COL_NAME' => 'unique_training_period_enum', 'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_100', ),                                                        

                                        'application_plan_branch_mfk' => array('STEP' => 3, 'SEARCH' => true,  'QSEARCH' => false,  
                                                'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false,  
                                                'IMPORTANT' => 'HEIGH', 'JSON-ANSWER' => true,
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
                                                'TYPE' => 'MFK',  'ANSWER' => 'application_plan_branch',  'ANSMODULE' => 'adm',  'READONLY' => false,  
                                                'WHERE' => "application_plan_id = §application_plan_id§ 
                                                                and gender_enum = §gender_enum§ 
                                                                and training_period_enum = §training_period_enum§
                                                                and (§consider_weighted_pctg§ != 'Y' or min_weighted_percentage <= §weighted_pctg§) 
                                                                and program_offering_id in (0§program_offering_mfk§0)",
                                                'DNA' => true, 
                                                'CSS' => 'width_pct_100', ),                                                                
                                                                
                                        'applicationDesireList' => array('STEP' => 4, 'SHOW' => true,  'FORMAT' => 'retrieve',  
                                                        'ICONS' => true,  'DE'.'LETE-ICON' => false,  'BUTTONS' => true, 'MOVE_UP-ICON' => true,  
                                                        'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                        'EDIT' => false,  'QEDIT' => false,  
                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
                                                        'MANDATORY' => false,  'UTF8' => false,  
                                                        "JSON-OPTIONS"=>[
                                                              "except-applicant_id" => true,
                                                              "except-application_plan_id" => true,
                                                              "except-application_simulation_id" => true,
                                                              "except-application_model_branch_id" => true,
                                                        ],
                                                        'DO-NOT-RETRIEVE-COLS' => ['applicant_id', ],
                                                        'IMPORTANT' => 'HEIGH', 'TYPE' => 'FK',  
                                                        'CATEGORY' => 'ITEMS',  'ANSWER' => 'application_desire',  'ANSMODULE' => 'adm',  
                                                        'ITEM' => '', 
                                                        'WHERE' => 'applicant_id = §applicant_id§ and application_plan_id = §application_plan_id§ and application_simulation_id = §application_simulation_id§',
                                                        'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                        'CSS' => 'width_pct_100', ),    
                                                        
                                        'applicantSimulationList' => array('STEP' => 99, 'TYPE' => 'FK', 'ANSWER' => 'applicant_simulation', 'ANSMODULE' => 'adm', 
                                                'CATEGORY' => 'ITEMS', 'ITEM' => '', 'WHERE' => 'application_simulation_id=§application_simulation_id§ and applicant_id=§applicant_id§', 
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                'ICONS'=>true, 'DELETE-ICON'=>true, 'VIEW-ICON'=>false, 'BUTTONS'=>true, 'NO-LABEL'=>false),                                                

                                        'sortingGroupList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  
                                                'ICONS' => false,  'DELETE-ICON' => false,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  
                                                'AUDIT' => false,  'RETRIEVE' => false, 'EDIT' => true,  'SHOW' => true,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
                                                'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'STEP' => 99,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'sorting_group',  'ANSMODULE' => 'adm',  
                                                'WHERE' => 'id in (select distinct sorting_group_id from §DBPREFIX§adm.application_plan_branch where application_plan_id = §application_plan_id§ and active=\'Y\')',  
                                                'READONLY' => true,  
                                                'CSS' => 'width_pct_100', ),                                                

                                        'consider_weighted_pctg'  => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 99,  
                                                'CATEGORY' => 'SHORTCUT', 'SHORTCUT'=>'application_model_id.consider_weighted_pctg',
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),       

                                        'nb_desires' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'INT',  'STEP' => 4, 'READONLY'=>true,
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
								'CSS' => 'width_pct_25',),

                                        'needed_docs_available' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'YN',  'STEP' => 99, 'READONLY'=>true,
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
								'CSS' => 'width_pct_25',),

                                        'tafrigh_available' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'YN',  'STEP' => 99, 'READONLY'=>true,
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
								'CSS' => 'width_pct_25',),
                                                                        


                                        'application_step_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_step',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'NO-REVERSE' => true,
                                                'CSS' => 'width_pct_75',), 

                                        'step_num' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'DEFAULT'=>'1', 'READONLY'=>true,
                                                'NO-REVERSE' => true,
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),

                                        'current_fields_matrix' => array('CATEGORY' => 'FORMULA',  'SHOW' => true, 
								'EDIT' => true,  'READONLY' => true, 
								'TYPE' => 'TEXT',  'SIZE' => 'AREA', 'FORMAT' => 'HTML', 'STEP' => 2,
								'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'NO-REVERSE' => true,
								'CSS' => 'width_pct_100',),	


                                        'mandatory_fields_matrix' => array(
                                                'STEP' => 99,
                                                'TYPE' => 'TEXT',
                                                'CATEGORY' => 'FORMULA',
                                                'SHOW' => true,
                                                'EDIT' => true,
                                                'READONLY' => true,
                                                "CAN-BE-SETTED" => false,
                                                'SIZE' => 'AREA', 'NO-REVERSE' => true,
                                                'PRE' => true,
                                                'CSS' => 'width_pct_100',
                                        ),                                                                
                                                
                                        'attribute_1' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  
                                                                        'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_2' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  
                                                                        'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),

                                                
                                        'attribute_3' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),

                                        
                                        'attribute_4' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),

                                        
                                        'attribute_5' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),

                                        
                                        'attribute_6' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),

                                        'attribute_7' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),

/*

                                        'attribute_8' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_9' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_10' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_11' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_12' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),
                                
                                                */

                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 5, 'READONLY'=>true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),
        
                                        'created_by' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => true,  
                                                'STEP' => 5,  'STEP-CUSTOMIZED' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>true, 
                                                'CSS' => 'width_pct_33',),

                                        'created_at' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',  'FORMAT' => 'DATETIME',  'DISPLAY' => true,  'READONLY'=>true,   
                                                'STEP' => 5,  'STEP-CUSTOMIZED' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),

                                        'updated_by' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => true,  
                                                'STEP' => 5,  'STEP-CUSTOMIZED' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>true, 
                                                'CSS' => 'width_pct_33',),

                                        'updated_at' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',  'FORMAT' => 'DATETIME',  'DISPLAY' => true,  
                                                'STEP' => 5,  'STEP-CUSTOMIZED' => true, 'READONLY'=>true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),

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