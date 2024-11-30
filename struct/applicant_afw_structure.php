<?php 
        class AdmApplicantAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof Applicant) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = ['first_name_ar', 'father_name_ar', 'last_name_ar'];
                                // $obj->AUTOCOMPLETE_FIELD = 'idn';
                                $obj->FORMULA_DISPLAY_FIELD  = "concat(IF(ISNULL(first_name_ar), '', first_name_ar) , ' ' , IF(ISNULL(father_name_ar), '', father_name_ar) , ' ' , IF(ISNULL(last_name_ar), '', last_name_ar))";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                $obj->UNIQUE_KEY = array('idn');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 10; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                        else 
                        {
                                ApplicantArTranslator::initData();
                                ApplicantEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('FGROUP'=>'idn-infos', 'SHOW' => false,  'RETRIEVE' => false,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25'),

                                        
                                        'country_id' => array('FGROUP'=>'idn-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 
                                                'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'country',  'ANSMODULE' => 'ums',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'READONLY-AFTER-INSERT'=>true, 
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	

                                        'idn_type_id' => array('FGROUP'=>'idn-infos', 
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true, 'SEARCH' => true, 'QSEARCH' => false,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true, 'READONLY-AFTER-INSERT'=>true, 
                                                'EDIT' => true,
                                                'TYPE' => 'FK', 'ANSWER'=>'identity_type', 'ANSMODULE'=>'adm', 
                                                'REQUIRED' => true, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25'),
                                        
                                        
                                        'idn' => array('FGROUP'=>'idn-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true, 
                                                'RETRIEVE' => true, "CLAUSE-WHERE-COL" => 'id', 
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32',
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'REQUIRED' => true, 'READONLY-AFTER-INSERT'=>true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'TEXT-SEARCHABLE-SEPARATED'=>true, 'FORMAT' => '::idnFormat', 
                                                'CSS' => 'width_pct_25'),



                                        'id_issue_place' => array('FGROUP'=>'idn-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => true,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50'),
                                                


                                        'id_issue_date' => ['FGROUP'=>'idn-infos', 
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'EDIT' => true,
                                                'QEDIT' => true,
                                                'SEARCH-ADMIN' => true,
                                                //'SHOW-ADMIN' => true,
                                                //'EDIT-ADMIN' => true,
                                                'UTF8' => false,
                                                'TYPE' => 'GDAT',
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_50',
                                            ],


                                        'id_expiry_date' => ['FGROUP'=>'idn-infos', 
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => false,
                                                'RETRIEVE' => false,
                                                'EDIT' => false,
                                                'QEDIT' => true,
                                                'SEARCH-ADMIN' => true,
                                                'SHOW-ADMIN' => true,
                                                'EDIT-ADMIN' => true,
                                                'UTF8' => false,
                                                'TYPE' => 'GDAT',
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_50',
                                            ],

                                        'mobile' => array('FGROUP'=>'idn-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 
                                            'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                            'EDIT' => true,  'QEDIT' => true,  'SIZE' => '25', 'MAXLENGTH' => '25', 'UTF8' => true, 'TEXT-SEARCHABLE-SEPARATED'=>true, 
                                            'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                            'CSS' => 'width_pct_50'),


                                        'email' => array('FGROUP'=>'idn-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                            'EDIT' => true,  'QEDIT' => true,  'SIZE' => '25', 'MAXLENGTH' => '25', 'UTF8' => true, 'TEXT-SEARCHABLE-SEPARATED'=>true, 
                                            'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                            'CSS' => 'width_pct_50'),

                                        'gender_enum' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  
                                                'RETRIEVE' => true, 'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => false,  
                                                'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	



                                        'birth_date' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  
                                                'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => true,  
                                                'TYPE' => 'DATE',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,   
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),        



                                        'birth_gdate' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => true,  
                                                'TYPE' => 'GDATE',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,   
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),        


                                        

                                        /* 'mother_saudi_ind' => array('FGROUP'=>'idn-infos', 'RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'READONLY' => false,
                                                'CSS' => 'width_pct_25',),*/

                                                
                                        'mother_idn' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'DISABLED' => '::disableOrReadonlyForInput',
                                                'CSS' => 'width_pct_25',),
                                                


                                        'mother_birth_date' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  
                                                'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => true,  
                                                'TYPE' => 'DATE',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,   
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'DISABLED' => '::disableOrReadonlyForInput', 
                                                'CSS' => 'width_pct_25',),        



                                        'marital_status_enum' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	
                                        
                                           

                                        
                                        'profile_approved' => array('FGROUP'=>'profile', 'RETRIEVE' => false, 'SHOW' => false, 'EDIT' => false,  'DEFAUT' => 'N',  
                                            'TYPE' => 'YN',    'DISPLAY' => false,  'STEP' => 2, 'MANDATORY' => false, 'QSEARCH' => false, 
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                            'CSS' => 'width_pct_25',),



                                            
                                        'first_name_ar' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'father_name_ar' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'middle_name_ar' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'last_name_ar' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                

                                                

                                        'first_name_en' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'father_name_en' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'middle_name_en' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'last_name_en' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                

                                        'religion_enum' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  
                                            'SEARCH' => false,  'SHOW' => true, 'RETRIEVE' => false,  
                                            'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => false,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                            'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                            'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                            'CSS' => 'width_pct_25', ),	




                                        'place_of_birth' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                
                                        'passeport_num' => array('FGROUP'=>'profile', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '32', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'passeport_expiry_gdate' => ['FGROUP'=>'profile', 
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
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',  ],


                                        

                                        'address_type_enum' => array('FGROUP'=>'address-infos', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => false,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'address' => array('FGROUP'=>'address-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '200', 'MAXLENGTH' => '200', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_75',),
                                                





                                        'city_id' => array('FGROUP'=>'address-infos', 'IMPORTANT' => 'IN',  'SEARCH' => false, 
                                                'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'city',  'ANSMODULE' => 'ums',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'postal_code' => array('FGROUP'=>'address-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => true,  'SIZE' => '10', 'MAXLENGTH' => '10', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                

                                        'country_code' => array('FGROUP'=>'address-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => false,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '10', 'MAXLENGTH' => '10', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'username' => array('FGROUP'=>'account-infos', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => false,  'SIZE' => '16', 'MAXLENGTH' => '16', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'password' => array('FGROUP'=>'account-infos', 'IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => false, 
                                                'RETRIEVE' => false, 'EDIT' => false,  'QEDIT' => false,  'SIZE' => '16', 'MAXLENGTH' => '16', 
                                                'TYPE' => 'TEXT',    'DISPLAY' => false,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'signup_acknowldgment' => array('FGROUP'=>'account-infos', 'RETRIEVE' => false, 'SHOW' => false, 'EDIT' => false,  'DEFAUT' => 'W',  
                                                'TYPE' => 'YN',    'DISPLAY' => false,  'STEP' => 2, 'MANDATORY' => false, 'READONLY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'has_iban' => array('FGROUP'=>'bank', 'RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', /*'CHECKBOX'=>true,*/
                                                'CSS' => 'width_pct_25',),



                                        'iban' => array('FGROUP'=>'bank', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '25', 'MAXLENGTH' => '25', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                


                                        'bank_account_pledge' => array('FGROUP'=>'bank', 'RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', /*'CHECKBOX'=>true,*/
                                                'CSS' => 'width_pct_25',),



                                        'job_status_enum' => array('FGROUP'=>'job_status', // emp_status
                                                'DEFAULT' => 2,
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'ENUM', 'MANDATORY' => false, 'ANSWER' => 'FUNCTION',
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),



                                        'employer_approval' => array('FGROUP'=>'job_status', 'RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'DISABLED' => true,
                                                'CSS' => 'width_pct_25',),



                                        'employer_enum' => array('FGROUP'=>'job_status', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => false,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'DISABLED' => true,
                                                'CSS' => 'width_pct_25', ),	


                                        'employer_approval_afile_id' => array('FGROUP'=>'job_status', 'IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'adm_file',  'ANSMODULE' => 'ums',  'SIZE' => 40,  'DEFAUT' => 0,
                                                'WHERE' => '1=0',  'WHERE-SEARCH' => '1=0',      
                                                'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'DISABLED' => true,
                                                'CSS' => 'width_pct_25', ),	


                                        'guardian_name' => array('FGROUP'=>'guardian', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '25', 'MAXLENGTH' => '25', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'guardian_phone' => array('FGROUP'=>'guardian', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '25', 'MAXLENGTH' => '25', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'relationship_enum' => array('FGROUP'=>'guardian', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => false,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	
                                                


                                        'guardian_idn' => array('FGROUP'=>'guardian', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '16 BYTE', 'MAXLENGTH' => '16 BYTE', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                


                                        'guardian_id_date' => ['FGROUP'=>'guardian', 
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => false,
                                                'QSEARCH' => false,
                                                'SHOW' => false,
                                                'RETRIEVE' => false,
                                                'EDIT' => false,
                                                'QEDIT' => false,
                                                /*'SEARCH-ADMIN' => true,
                                                'SHOW-ADMIN' => true,
                                                'EDIT-ADMIN' => true,*/
                                                'UTF8' => false,
                                                'TYPE' => 'GDAT',
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],


                                        'guardian_id_place' => array('FGROUP'=>'guardian', 'IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => false,  'SIZE' => '25', 'MAXLENGTH' => '25', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => false,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                
                                        'applicantApiRequestList' => array('STEP' => 2,'FGROUP'=>'apis', 'SHOW' => true,  'FORMAT' => 'retrieve',  
                                                                        'ICONS' => false, 
                                                                        'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                                        'EDIT' => false,  'QEDIT' => false,  
                                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                                        'TYPE' => 'FK',  
                                                                        'CATEGORY' => 'ITEMS',  'ANSWER' => 'applicant_api_request',  'ANSMODULE' => 'adm',  'ITEM' => 'applicant_id',  
                                                                        'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                                        'CSS' => 'width_pct_100', ),


                                        
                                        'applicantQualificationList' => array('STEP' => 3,'FGROUP'=>'qualif', 'SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  
                                                'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  
                                                'RETRIEVE' => false, 'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
                                                'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'CATEGORY' => 'ITEMS',  'ANSWER' => 'applicant_qualification',  'ANSMODULE' => 'adm',  'ITEM' => 'applicant_id',  
                                                'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_100', ),

                                        'applicantEvaluationList' => array('STEP' => 3,'FGROUP'=>'evaluation', 'SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  
                                                'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  
                                                'RETRIEVE' => false, 'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  
                                                'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'CATEGORY' => 'ITEMS',  'ANSWER' => 'applicant_evaluation',  'ANSMODULE' => 'adm',  'ITEM' => 'applicant_id',  
                                                'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_100', ),


                                        


                                        'attribute_1' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_2' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
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


                                        'attribute_7' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => false,  'UTF8' => false,  
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


                                        /*'attribute_10' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),*/


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


                                        'attribute_13' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_14' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_15' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_16' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_17' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_18' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_19' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_20' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        /*'attribute_21' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),*/


                                        'attribute_22' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_23' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_24' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_25' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        /*'attribute_26' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),*/


                                        'attribute_27' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_28' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_29' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_30' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_31' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_32' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_33' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_34' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_35' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_36' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_37' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),

                                        /*    
                                        'attribute_38' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_39' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_40' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_41' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_42' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_43' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_44' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_45' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_46' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_47' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_48' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_49' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_50' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_51' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_52' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_53' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_54' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_55' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_56' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_57' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_58' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_59' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_60' => array('FGROUP'=>'::additional', 'OBSOLETE'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => '::additional',  'RETRIEVE' => false,  
                                                                        'EDIT' => '::additional',  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',), */

                                        'applicationList' => array('STEP' => 5,'FGROUP'=>'appl',  'SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                                        'EDIT' => false,  'QEDIT' => false,  
                                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                                        'TYPE' => 'FK',  
                                                                        'CATEGORY' => 'ITEMS',  'ANSWER' => 'application',  'ANSMODULE' => 'adm',  'ITEM' => 'applicant_id',  'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                                        'CSS' => 'width_pct_100', ),
                        

                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
        
                                        'created_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'created_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'updated_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'updated_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'validated_by' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'validated_at' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',    'DISPLAY' => '',  'STEP' => 99,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        


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

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>