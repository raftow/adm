<?php 
        class AdmApiEndpointAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof ApiEndpoint) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = "api_endpoint_name_ar";
                                $obj->ORDER_BY_FIELDS = "institution_id,priority_num";
                                $obj->UNIQUE_KEY = array('institution_id','priority_num');
                                //$obj->UNIQUE_KEY = array('api_endpoint_code');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;
                                $obj->MOVE_UP_ACTION = true;
                                // $obj->editByStep = true;
                                // $obj->editNbSteps = 1; 
                                $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'ApiEndpoint',"submit"=>true);
                        }
                        else
                        {
                                ApiEndpointArTranslator::initData();
                                ApiEndpointEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'api_endpoint_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

                                        'published' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'Y', 'FORMAT' => 'icon',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'SEARCH' => true, 'QSEARCH' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'import' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'Y', 'FORMAT' => 'icon',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'SEARCH' => true, 'QSEARCH' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),                                                
                                                

                                                
                                        'api_endpoint_title' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true, 
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '128', 'MAXLENGTH' => '128', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
                                                


                                        'api_endpoint_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '96', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                


                                        'api_endpoint_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '96', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

                                        'active' => array('SHOW' => true,  'SEARCH' => true, 'QSEARCH' => true, 'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),


                                        'can_refresh' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N', 'FORMAT' => 'icon', 
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'QSEARCH' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

                                                

                                        'duration_expiry' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
                                                'TYPE' => 'INT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'UNIT' => 'يوم', 'DEFAUT' => 15, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                
                                        

                                        

                                        'adm_file_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'workflow_file',  'ANSMODULE' => 'workflow',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	
                                                


                                        'failure_text' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,   
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
                                                


                                        'api_url' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        'api_endpoint_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'MFK',  'ANSWER' => 'api_endpoint',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100', ),
                                                

                                        'application_field_mfk' => array(
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'QSEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'EDIT' => true,
                                                'QEDIT' => false,
                                                'UTF8' => false,
                                                'MANDATORY' => true,
                                                "FORMAT"=>"mobiselector",
                                                'TYPE' => 'MFK',
                                                'ANSWER' => 'application_field',
                                                'ANSMODULE' => 'adm',
                                                'DISPLAY' => true,
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_100',
                                                ),
        
                                        'priority_num' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  
                                                                        'RETRIEVE' => true,
                                                                        'READONLY' => true,
                                                                        'EDIT' => true, 'CAN_ZERO' => true,  'QEDIT' => false,  
                                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
                                                                        'TYPE' => 'INT',  'DNA' => true, 
                                                                        'CSS' => 'width_pct_50', ),

                                        'institution_id' => array('SHORTNAME' => 'institution',  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  
                                                        'AUDIT' => false,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false,  
                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'institution',  'ANSMODULE' => 'adm',  
                                                        'RELATION' => 'OneToMany',  'READONLY' => false,  'DNA' => true, 
                                                        'CSS' => 'width_pct_50', ),


	


        

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