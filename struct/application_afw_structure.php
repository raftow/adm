<?php 
        class AdmApplicationAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof Application) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = "application_name_ar";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                $obj->UNIQUE_KEY = array('applicant_id','application_plan_id');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 4; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'applicant_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'applicant',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => true,'AUTOCOMPLETE-SEARCH' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'application_plan_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'application_model_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'step_num' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 'DEFAULT'=>'1', 'READONLY'=>true,
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),



                                        'application_step_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_step',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	

                                        'program_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'academic_program',  'ANSMODULE' => 'adm',  
                                                        'WHERE'=>"id in (select program_id from c0adm.application_plan_branch where application_plan_id = §application_plan_id§)",
                                                        'SIZE' => 40,  'DEFAUT' => 0,     
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),


                                        'applicant_qualification_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'applicant_qualification',  'ANSMODULE' => 'adm',  
                                                'WHERE'=> "applicant_id = §applicant_id§",
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>false,                                                 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	

                                        'application_status_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'READONLY'=>true,    
                                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 'DEFAULT' => 1,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),


                                        'qualification_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => false,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'qualification',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 99,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'major_category_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => false,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'major_category',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 99,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),
                                                
                                        'attribute_1' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  
                                                                        'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_2' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  
                                                                        'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),

                                        /*        
                                        'attribute_3' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_4' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_5' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_6' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_7' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_8' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_9' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_10' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_11' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),


                                        'attribute_12' => array('FGROUP'=>'::additional', 'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  
                                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => '::additional', 'ANSWER' => '::additional',  'ANSMODULE' => '::additional',  'STEP' => '::additional',    'DISPLAY' => true, 'MANDATORY' => false,                                 
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => '::additional',
                                                                        'CSS' => '::additional', 'CATEGORY' => '::additional', 'FORMULA' => '::additional',),
                                
                                                */

                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 3, 'READONLY'=>true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),
        
                                        'created_by' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => true,  
                                                'STEP' => 3,  'STEP-CUSTOMIZED' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>true, 
                                                'CSS' => 'width_pct_33',),

                                        'created_at' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',  'FORMAT' => 'DATETIME',  'DISPLAY' => true,  'READONLY'=>true,   
                                                'STEP' => 3,  'STEP-CUSTOMIZED' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),

                                        'updated_by' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',    'DISPLAY' => true,  
                                                'STEP' => 3,  'STEP-CUSTOMIZED' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>true, 
                                                'CSS' => 'width_pct_33',),

                                        'updated_at' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true, 'QEDIT' => false,  
                                                'TYPE' => 'GDAT',  'FORMAT' => 'DATETIME',  'DISPLAY' => true,  
                                                'STEP' => 3,  'STEP-CUSTOMIZED' => true, 'READONLY'=>true,  
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
                                                                        'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>