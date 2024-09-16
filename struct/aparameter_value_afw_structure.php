<?php 
        class AdmAparameterValueAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof AparameterValue) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                // $obj->DISPLAY_FIELD = "aparameter_value_name_ar";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                $obj->UNIQUE_KEY = array('aparameter_id','application_model_id','application_plan_id','training_unit_id','department_id','application_model_branch_id');
                                // $obj->public_display = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 2; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),


                                        'aparameter_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'aparameter',  'ANSMODULE' => 'adm', 'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33', ),
                                                
                                        'application_model_id' => array('IMPORTANT' => 'IN', 'FGROUP' => 'application_model_id', 'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',                                                  
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100', ),

                                        'application_plan_id' => array('STEP' => 1,  'SHORTNAME' => 'plan',  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  
                                                'SIZE' => 40,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
                                                'WHERE' => 'application_model_id = §application_model_id§',
                                                'DEPENDENCIES' => ['application_model_id',],
                                                'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  
                                                'RELATION' => 'ManyToOne',  'READONLY' => false, 
                                                'CSS' => 'width_pct_50', ),        

                                        'training_unit_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'training_unit',  'ANSMODULE' => 'adm',  
                                                'WHERE' => "id in (select distinct apo.training_unit_id from §DBPREFIX§adm.academic_program_offering apo 
                                                                        inner join §DBPREFIX§adm.application_model_branch amb on amb.program_offering_id = apo.id
                                                                   where amb.application_model_id = §application_model_id§
                                                                     and apo.active = 'Y'
                                                                     and amb.active = 'Y')",
                                                'DEPENDENCIES' => ['application_model_id',],
                                                'DEPENDENT_OFME' => ['department_id', 'application_model_branch_id'],
                                                'SIZE' => 40,  'DEFAUT' => 0, 'MANDATORY' => false, 'READONLY'=>false, 'READONLY-AFTER-INSERT'=>true,    
                                                'AUTOCOMPLETE' => false, 'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'EMPTY_IS_ALL' => true,
                                                'CSS' => 'width_pct_50', ),

                                        'department_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'department',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'WHERE' => "id in (select distinct apo.department_id from §DBPREFIX§adm.academic_program_offering apo 
                                                                        inner join §DBPREFIX§adm.application_model_branch amb on amb.program_offering_id = apo.id
                                                                   where amb.application_model_id = §application_model_id§
                                                                     and apo.active = 'Y'
                                                                     and amb.active = 'Y')
                                                            and id in (select distinct ud.department_id from §DBPREFIX§adm.training_unit_department ud where ud.training_unit_id = §training_unit_id§)       
                                                             ",
                                                'DEPENDENCIES' => ['application_model_id','training_unit_id',],
                                                'DEPENDENT_OFME' => ['application_model_branch_id',],
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'EMPTY_IS_ALL' => true,
                                                'MANDATORY' => false, 'READONLY'=>false, 'READONLY-AFTER-INSERT'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        'application_model_branch_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model_branch',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DEPENDENCIES' => ['application_model_id',],
                                                'WHERE' => 'application_model_id = §application_model_id§
                                                           and ((§training_unit_id§ = 0) or (training_unit_id = §training_unit_id§))          
                                                           and ((§department_id§ = 0) or (department_id = §department_id§))',
                                                'DEPENDENCIES' => ['application_model_id','training_unit_id','department_id'],
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'MANDATORY' => false, 'READONLY'=>false, 'READONLY-AFTER-INSERT'=>true, 
                                                'AUTOCOMPLETE' => false, 'AUTOCOMPLETE-SEARCH' => true,'EMPTY_IS_ALL' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),



                                        'value' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '255', 'MAXLENGTH' => '255', 'UTF8' => true,  
                                                'TYPE' => '::dynamic', 'ANSWER' => '::dynamic',  'ANSMODULE' => '::dynamic', 'FUNCTION_COL_NAME' => '::dynamic',  
                                                'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                


                                        

                                        'active' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'DISPLAY' => '',  'STEP' => 2,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),



                                        
        
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

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>