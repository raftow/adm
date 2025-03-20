<?php 
        class AdmApplicationPlanAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof ApplicationPlan) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = "application_model_name_ar";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                $obj->UNIQUE_KEY = array('application_model_id','term_id');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 6; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'application_model_id' => array('IMPORTANT' => 'IN', 'FGROUP' => 'application_model_id', 'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 
                                                'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	

                                                'academic_level_id' => array('IMPORTANT' => 'IN', 'FGROUP' => 'application_model_id', 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'application_model_id.academic_level_id', 'SHOW' => true,  
                                                        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false, 'NO-COTE' =>true,
                                                        'TYPE' => 'FK',  'ANSWER' => 'academic_level',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),	

                                                                

                                                'gender_enum' => array('IMPORTANT' => 'IN', 'FGROUP' => 'application_model_id', 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'application_model_id.gender_enum', 'SHOW' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),	


                                                'training_period_enum' => array('IMPORTANT' => 'IN', 'FGROUP' => 'application_model_id', 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'application_model_id.training_period_enum', 'SHOW' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),	

                                                'language_enum' => array('IMPORTANT' => 'IN', 'FGROUP' => 'application_model_id', 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'application_model_id.language_enum', 'SHOW' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),

                                        'term_id' => array('IMPORTANT' => 'IN', 'FGROUP' => 'term_id',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'academic_term',  'ANSMODULE' => 'adm',  
                                                'WHERE' => "academic_level_mfk like '%,§academic_level_id§,%' and id not in (select term_id from §DBPREFIX§adm.application_plan where application_model_id = §application_model_id§ and term_id is not null and term_id != §term_id§)",
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true,
                                                'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),

                                                        'academic_year_id' => array('IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.academic_year_id', 
                                                            'SHOW' => true,  'RETRIEVE' => false,  
                                                            'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                            'TYPE' => 'FK',  'ANSWER' => 'academic_year',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                            'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => false, 
                                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                            'CSS' => 'width_pct_25', ),                                                        

                                        'instructions_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => true,  
                                                        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,   
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_100',),   

                                        'instructions_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => true,  
                                                        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,   
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_100',),


                                        	



                                                        'start_date' => [
                                                            'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.start_date', 
                                                            'SEARCH' => true,
                                                            'SHOW' => true,
                                                            'RETRIEVE' => false,
                                                            'EDIT' => true,
                                                            'QEDIT' => true,
                                                            'SEARCH-ADMIN' => true,
                                                            'SHOW-ADMIN' => true,
                                                            'EDIT-ADMIN' => true,
                                                            'UTF8' => false,
                                                            'TYPE' => 'GDAT',
                                                            'FORMAT' => 'LONG',
                                                            'STEP' => 2,
                                                            'DISPLAY-UGROUPS' => '',
                                                            'EDIT-UGROUPS' => '',
                                                            
                                                            'CSS' => 'width_pct_25',
                                                        ],
            
            
                                                        'end_date' => [
                                                                    'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.end_date', 
                                                                    'SEARCH' => true,
                                                                    'SHOW' => true,
                                                                    'RETRIEVE' => false,
                                                                    'EDIT' => true,
                                                                    'QEDIT' => true,
                                                                    'SEARCH-ADMIN' => true,
                                                                    'SHOW-ADMIN' => true,
                                                                    'EDIT-ADMIN' => true,
                                                                    'UTF8' => false,
                                                                    'TYPE' => 'GDAT',
                                                                    'FORMAT' => 'LONG',
                                                                    'STEP' => 2,
                                                                    'DISPLAY-UGROUPS' => '',
                                                                    'EDIT-UGROUPS' => '',
                                                                    
                                                                    'CSS' => 'width_pct_25',
                                                                ],
                                                                
                
                                                        
                
                                                        'application_start_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.application_start_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                                                        'application_start_time' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.application_start_time', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                
                                                                'UTF8' => false,
                                                                'TYPE' => 'TIME',
                                                                'FORMAT' => 'CLOCK',
                                                                'ANSWER_LIST' => '6/10/22',
                                                                // 'ANSWER_METHOD'=>'getXXXTimeList', 'FORMAT' => 'OBJECT',
                                                                'DISPLAY' => true,
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                'CSS' => 'width_pct_25',
                                                            ],
                                                        
                                                        
                                                        
                
                
                                                        'application_end_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.application_end_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                                                        'application_end_time' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.application_end_time', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,                                                
                                                                'UTF8' => false,
                                                                'TYPE' => 'TIME',
                                                                'FORMAT' => 'CLOCK',
                                                                'ANSWER_LIST' => '6/10/22',
                                                                // 'ANSWER_METHOD'=>'getXXXTimeList', 'FORMAT' => 'OBJECT', 
                                                                'DISPLAY' => true,
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                'CSS' => 'width_pct_25',
                                                            ],
                                                        
                                                                
                
                
                                                        'sorting_start_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.sorting_start_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                                                        'sorting_end_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.sorting_end_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                                                        
                                                                
                
                
                                                        'admission_start_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.admission_start_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                
                                                        'admission_end_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.admission_end_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                
                                                        'direct_adm_start_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.direct_adm_start_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                
                                                        'direct_adm_end_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.direct_adm_end_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                
                                                        'seats_update_start_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.seats_update_start_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                
                                                        'seats_update_end_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.seats_update_end_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                
                                                        'migration_start_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.migration_start_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],
                
                
                                                        'migration_end_date' => [
                                                                'IMPORTANT' => 'IN', 'FGROUP' => 'term_id', 'READONLY'=>true, 'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'term_id.migration_end_date', 
                                                                'SEARCH' => true,
                                                                'SHOW' => true,
                                                                'RETRIEVE' => false,
                                                                'EDIT' => true,
                                                                'QEDIT' => true,
                                                                'SEARCH-ADMIN' => true,
                                                                'SHOW-ADMIN' => true,
                                                                'EDIT-ADMIN' => true,
                                                                'UTF8' => false,
                                                                'TYPE' => 'GDAT',
                                                                'FORMAT' => 'LONG',
                                                                'STEP' => 2,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                
                                                                'CSS' => 'width_pct_25',
                                                            ],


                                        'application_model_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 3, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                


                                        'application_model_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 3, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                





                                        'valid' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',  'FORMAT' => 'icon',  'READONLY' => true,  'STEP' => 3, 'MANDATORY' => true, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),


                                                
                                        'published' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',  'FORMAT' => 'icon',  'READONLY' => true,  'STEP' => 3, 'MANDATORY' => true, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),



                                        'closed' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN', 'FORMAT' => 'icon',   'READONLY' => true,  'STEP' => 3, 'MANDATORY' => true, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN', 'READONLY' => true,   'FORMAT' => 'icon',  'STEP' => 3,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'aparameterValueList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'STEP' => 4,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'aparameter_value',  'ANSMODULE' => 'adm',  
                                                'WHERE' => 'application_model_id = §application_model_id§ 
                                                        and application_plan_id = §id§
                                                        and training_unit_id = 0
                                                        and department_id = 0 
                                                        and application_model_branch_id = 0',  
                                                'HIDE_COLS' => array('application_model_id','application_plan_id','training_unit_id','department_id','application_model_branch_id',),
                                                'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_100', ),


                                        'applicationPlanBranchList' => array('TYPE' => 'FK', 'ANSWER' => 'application_plan_branch', 'ANSMODULE' => 'adm', 
                                                'CATEGORY' => 'ITEMS', 'ITEM' => 'application_plan_id', 'STEP' => 5,
                                                // 'WHERE'=>'xxx = §xxx§', 'HIDE_COLS' => array(),
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                'ICONS'=>true, 'DELETE-ICON'=>true, 'DISPLAY-ICON'=>false,  'BUTTONS'=>true, 'NO-LABEL'=>false),


                                        'applicationList' => array('SHORTNAME' => 'applications',  'SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                                        'EDIT' => false,  'QEDIT' => false,  
                                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                                        'TYPE' => 'FK', 'STEP' => 6, 
                                                                        'CATEGORY' => 'ITEMS',  'ANSWER' => 'application',  'ANSMODULE' => 'adm',  'ITEM' => 'application_plan_id',  
                                                                        'WHERE' => 'application_simulation_id = 2',
                                                                        'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                                        'CSS' => 'width_pct_100', ),

        
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