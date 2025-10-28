<?php 
        class AdmAcademicTermAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof AcademicTerm) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD_BY_LANG = ['ar'=>"term_name_ar", 'en'=>"term_name_en",];
                                $obj->ORDER_BY_FIELDS = "term_code";
                                $obj->UNIQUE_KEY = array('academic_year_id', 'term_code');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 3; 
                                $obj->after_save_edit = array("class"=>'AcademicYear',"attribute"=>'academic_year_id', "currmod"=>'adm',"currstep"=>2);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'academic_year_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'academic_year',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'READONLY' => false,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	

                                        'term_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        
                                        'academic_level_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'UTF8' => false, 'MANDATORY' => true,  
                                                'TYPE' => 'MFK',  'ANSWER' => 'academic_level',  'ANSMODULE' => 'adm',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

    
                                        'current_active_term' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'MANDATORY' => false, 'QSEARCH' => false, 
                                                'FORMAT' => 'icon',  'STEP' => 1,  'CHECKBOX' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        

                                        
                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 1,  'CHECKBOX' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'term_mode_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        'term_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),


                                        
                                                


                                        'term_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

                                        
    
    
    
                                        'start_date' => [
                                                    'IMPORTANT' => 'IN',
                                                    'SEARCH' => true,
                                                    'SHOW' => true,
                                                    'RETRIEVE' => true,
                                                    'EDIT' => true,
                                                    'QEDIT' => true,
                                                    'SEARCH-ADMIN' => true,
                                                    'SHOW-ADMIN' => true,
                                                    'EDIT-ADMIN' => true,
                                                    'UTF8' => false,
                                                    'TYPE' => 'GDAT',
                                                    
                                                    'STEP' => 2,
                                                    'DISPLAY-UGROUPS' => '',
                                                    'EDIT-UGROUPS' => '',
                                                    
                                                    'CSS' => 'width_pct_25',
                                                ],
    
    
                                        'end_date' => [
                                                    'IMPORTANT' => 'IN',
                                                    'SEARCH' => true,
                                                    'SHOW' => true,
                                                    'RETRIEVE' => true,
                                                    'EDIT' => true,
                                                    'QEDIT' => true,
                                                    'SEARCH-ADMIN' => true,
                                                    'SHOW-ADMIN' => true,
                                                    'EDIT-ADMIN' => true,
                                                    'UTF8' => false,
                                                    'TYPE' => 'GDAT',
                                                    'STEP' => 2,
                                                    'DISPLAY-UGROUPS' => '',
                                                    'EDIT-UGROUPS' => '',
                                                    
                                                    'CSS' => 'width_pct_25',
                                                ],
                                                

                                        

                                        'application_start_date' => [
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'EDIT' => true,
                                                'QEDIT' => true,
                                                'SEARCH-ADMIN' => true,
                                                'SHOW-ADMIN' => true,
                                                'EDIT-ADMIN' => true,
                                                'UTF8' => false,
                                                'TYPE' => 'GDAT',
                                                'DISPLAY' => true,
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],

                                        'application_start_time' => [
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'EDIT' => true,
                                                 
                                                'UTF8' => false,
                                                'TYPE' => 'TIME',
                                                'FORMAT' => 'CLOCK', "SEPARATOR" =>":",
                                                'ANSWER_LIST' => '6/10/22',
                                                // 'ANSWER_METHOD'=>'getXXXTimeList', 'FORMAT' => 'OBJECT',
                                                'DISPLAY' => true,
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',
                                            ],
                                        
                                        
                                        


                                        'application_end_date' => [
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'EDIT' => true,
                                                'QEDIT' => true,
                                                'SEARCH-ADMIN' => true,
                                                'SHOW-ADMIN' => true,
                                                'EDIT-ADMIN' => true,
                                                'UTF8' => false,
                                                'TYPE' => 'GDAT',
                                                'DISPLAY' => true,
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],

                                        'application_end_time' => [
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'EDIT' => true,                                                
                                                'UTF8' => false,
                                                'TYPE' => 'TIME',
                                                'FORMAT' => 'CLOCK', "SEPARATOR" =>":",
                                                'ANSWER_LIST' => '6/10/22',
                                                // 'ANSWER_METHOD'=>'getXXXTimeList', 'FORMAT' => 'OBJECT', 
                                                'DISPLAY' => true,
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',
                                            ],
                                        
                                                


                                        'sorting_start_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],

                                        'sorting_end_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],
                                        
                                                


                                        'admission_start_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],


                                        'admission_end_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],


                                        'direct_adm_start_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],


                                        'direct_adm_end_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],


                                        'seats_update_start_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],


                                        'seats_update_end_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],


                                        'migration_start_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],


                                        'migration_end_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],

                                            'Results_Announcement_date' => [
                                                'IMPORTANT' => 'IN',
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
                                                
                                                'STEP' => 2, 'FGROUP' => 'miladi',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],

                                        'maqbool_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  
                                            'EDIT' => true,  'QEDIT' => true,  'SIZE' => '8', 'MAXLENGTH' => '8', 'UTF8' => true,  
                                            'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'FGROUP' => 'miladi', 'MANDATORY' => false,  
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                            'CSS' => 'width_pct_25',),


                                    
                                            


                                    

                                        'hijri_start_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                            'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                            'CSS' => 'width_pct_25',),


                                        'hijri_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                            'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                            'CSS' => 'width_pct_25',),


                                        'hijri_application_start_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_application_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_admission_start_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_admission_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_direct_adm_start_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '8', 'MAXLENGTH' => '8', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'FGROUP' => 'hijri', 'MANDATORY' => false, 'READONLY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'hijri_direct_adm_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_seats_update_start_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_seats_update_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_migration_start_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_migration_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),

                                        'hijri_Results_Announcement_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),

                                        'hijri_sorting_start_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),
                            
                            
                                        'hijri_sorting_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 2, 'FGROUP' => 'hijri',    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                                                        'CSS' => 'width_pct_25',),
                            
                'academicPeriodList' => array('TYPE' => 'FK', 'ANSWER' => 'academic_period', 'ANSMODULE' => 'adm', 
                                                'CATEGORY' => 'ITEMS', 'ITEM' => 'academic_term_id', 
                                                'STEP' => 3, 'PILLAR' => true, 
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => false, 
                                                'ICONS'=>true, 'DELETE-ICON'=>true, 'BUTTONS'=>true, 'NO-LABEL'=>false,  'CAN-BE-SETTED' => true),
        
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