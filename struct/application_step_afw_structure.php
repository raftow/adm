<?php 
        class AdmApplicationStepAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof ApplicationStep) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD_BY_LANG = ['ar'=>"step_name_ar", 'en'=>"step_name_en",];
                                $obj->ORDER_BY_FIELDS = "application_model_id, step_num";
                                $obj->UNIQUE_KEY = array('application_model_id','step_num');
                                $obj->public_display = true;
                                $obj->MOVE_UP_ACTION = true;
                                //$obj->MOVE_DOWN_ACTION = true;
                                $obj->MOVE_QUESTION = 1;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 2; 
                                $obj->after_save_edit = array("class"=>'ApplicationModel',"attribute"=>'application_model_id', "currmod"=>'adm',"currstep"=>5);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false, 'READONLY'=>true, 
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

                                        'application_model_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100', ),	


                                        'step_num' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'READONLY' => true,
                                                'EDIT' => true, 'CAN_ZERO' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),

                                        'general' => array('RETRIEVE' => true,
                                                'QEDIT' => true,
                                                'EDIT' => true, 'SHOW' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

 
                                        'screen_model_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'screen_model',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),

                                                        'application_field_mfk' => array(
                                                                'CATEGORY' => 'SHORTCUT',
                                                                'SHORTCUT' => 'screen_model_id.application_field_mfk',
                                                                'NO-COTE' => true,
                                                                'TYPE' => 'MFK',
                                                                'ANSWER' => 'application_field',
                                                                'ANSMODULE' => 'adm',
                                                                'STEP' => 99,
                                                                'DISPLAY-UGROUPS' => '',
                                                                'EDIT-UGROUPS' => '',
                                                                'CSS' => 'width_pct_50',
                                                                ),


                                        



                                        'step_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),
                                                


                                        'step_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),

                                        'step_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '3', 'MAXLENGTH' => '3', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),                                                
                                                
                                        'FrontEnd_instructions_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AREA', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),
                                        'FrontEnd_instructions_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AREA', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),
                                        'show_in_FrondEnd' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AREA', 'UTF8' => false,  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_33',),

                                        'show_field_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'UTF8' => false, 'MANDATORY' => false,  
                                                'TYPE' => 'MFK',  'ANSWER' => 'application_field', 
                                                'WHERE' => "((§general§='Y' and application_table_id in (1,3)) or (§general§='N')) and id in (0§application_field_mfk§0)", 
                                                'LIST_SEPARATOR' => " | ",
                                                'STEP' => 2, 'ANSMODULE' => 'adm',    'DISPLAY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),


                                                /*                
                                                'api_endpoint_mfk' => array('CATEGORY' => 'FORMULA',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false, 'MANDATORY' => false,  
                                                        'TYPE' => 'MFK',  'ANSWER' => 'api_endpoint',  'ANSMODULE' => 'adm',    'DISPLAY' => true,  'STEP' => 2,  
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_100',),

                                                'api_endpoint2_mfk' => array('CATEGORY' => 'FORMULA',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,  'UTF8' => false, 'MANDATORY' => false,  
                                                        'TYPE' => 'MFK',  'ANSWER' => 'api_endpoint',  'ANSMODULE' => 'adm',    'DISPLAY' => true,  'STEP' => 2,  
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_100',),*/




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
                                                                        'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>