<?php 
        class AdmApplicationModelAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof ApplicationModel) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = "application_model_name_ar";
                                $obj->ORDER_BY_FIELDS = "academic_level_id, gender_enum, training_period_enum";
                                $obj->UNIQUE_KEY = array('academic_level_id','gender_enum','training_period_enum');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 5; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'academic_level_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'academic_level',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),
                                                
                                                        

                                        'gender_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'training_period_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	

                                        'training_mode_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),

                                        'language_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                                'level_degree_mfk' => array('IMPORTANT' => 'IN',  'NO-COTE' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                        'CATEGORY' => 'SHORTCUT', 'SHORTCUT' => 'academic_level_id.degree_mfk',
                                                        'MFK-SHOW-SEPARATOR' => ' / ',
                                                        'EDIT' => true,  'QEDIT' => false,  'UTF8' => false, 'MANDATORY' => false,  
                                                        'TYPE' => 'MFK',  'ANSWER' => 'degree',  'ANSMODULE' => 'adm',    'READONLY' => true,  'STEP' => 1,  
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        ),





                                        'application_fees_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

                                        'application_fees_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                

                                        'training_hours' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'UNIT' => 'ساعة',
                                                'CSS' => 'width_pct_50',),

                                        /*        
                                        'degree_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'UTF8' => false, 'MANDATORY' => true,  
                                                'TYPE' => 'MFK',  'ANSWER' => 'degree',  'ANSMODULE' => 'adm',    'DISPLAY' => true,  'STEP' => 2,  
                                                'WHERE' => 'id in (0§level_degree_mfk§0)',
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),*/

                                        


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



                                        'application_model_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,    
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                


                                        'application_model_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                




                                        'upload_files' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  'QEDIT' => false, 
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),



                                        

                                        'active' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 2,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),



                                        'min_training_unit' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),



                                        'max_training_unit' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),



                                        'min_desire' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),



                                        'max_desire' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),


                                        'tuituin_fees_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '60', 'MAXLENGTH' => '60', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'tuituin_fees_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '60', 'MAXLENGTH' => '60', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),


                                        'training_nb_term_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '80', 'MAXLENGTH' => '80', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'training_nb_term_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '80', 'MAXLENGTH' => '80', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),


                                        'application_picture' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
                                                'TYPE' => 'FK', 'ANSWER' => 'afile',  'ANSMODULE' => 'pag', 'WHERE' => 'doc_type_id = 555',
                                                'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),



                                        'allow_direct_adm' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N', 'QEDIT' => false,  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),



                                        

                                        'print_application_doc' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N', 'QEDIT' => false,   
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),



                                        'print_admission_doc' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N', 'QEDIT' => false,   
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),


                                        

                                        'allow_admission_upgrade' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N', 'QEDIT' => false,  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                

                                        'allow_add_qualification' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N','QEDIT' => false,   
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),



                                        'print_application_notification' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N', 'QEDIT' => false,  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),




                                        'print_admission_agreement' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N', 'QEDIT' => false,  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3,  'FORMAT' => 'icon', 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),


                                        
                                        'applicationModelBranchList' => array('TYPE' => 'FK', 'ANSWER' => 'application_model_branch', 'ANSMODULE' => 'adm','QEDIT' => false,  
                                                'CATEGORY' => 'ITEMS', 'ITEM' => 'application_model_id', 'STEP' => 4,
                                                // 'WHERE'=>'xxx = §xxx§', 'HIDE_COLS' => array(),
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                'ICONS'=>true, 'DELETE-ICON'=>true,
                                                'VIEW-ICON'=>false,
                                                'BUTTONS'=>true, 'NO-LABEL'=>false),


                                        'applicationPlanList' => array('TYPE' => 'FK', 'ANSWER' => 'application_plan', 'ANSMODULE' => 'adm', 'QEDIT' => false, 
                                                'CATEGORY' => 'ITEMS', 'ITEM' => 'application_model_id', 'STEP' => 5,
                                                // 'WHERE'=>'xxx = §xxx§', 'HIDE_COLS' => array(),
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                'ICONS'=>true, 'DELETE-ICON'=>true, 'BUTTONS'=>true, 'NO-LABEL'=>false),



                                        
        
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
                                                                        'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'pag', 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>