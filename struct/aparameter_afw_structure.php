<?php 
        class AdmAparameterAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof Aparameter) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = "aparameter_name_ar";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                // $obj->UNIQUE_KEY = array('xxxx','yyyy');
                                // $obj->public_display = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 3; 
                                $obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'Aparameter', "submit" => true);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        'aparameter_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '', 'MAXLENGTH' => '64', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
                                                
                                                

                                        'aparameter_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '', 'MAXLENGTH' => '64', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),


                                        'aparam_use_scope_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100', ),                                                
                                                


                                        'customizable' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),



                                        'afield_type_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 'FUNCTION_COL_NAME' => 'afield_type_enum',
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        'answer_table_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne', 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        'measurement_unit_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '', 'MAXLENGTH' => '32', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                


                                        'measurement_unit_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '', 'MAXLENGTH' => '32', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

                                        'active' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'DISPLAY' => '',  'STEP' => 2,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),


                                        'aparameterValueList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  
                                                'ICONS' => true,  'EDIT-ICON' => 2, /* means goto directly step 2 */
                                                'DELETE-ICON' => true,  'BUTTONS' => true,  
                                                'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'STEP' => 3,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'aparameter_value',  'ANSMODULE' => 'adm',  'ITEM' => 'aparameter_id',  'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_100', ),



                                        /*
                                                


                                        'branch_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                'TYPE' => 'MFK',  'ANSWER' => 'application_model_branch',  'ANSMODULE' => 'adm',  
                                                'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),



                                        	


                                        'readonly' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        */
        
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
                                                                        'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>