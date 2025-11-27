<?php 
        class AdmServiceRequestAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof ServiceRequest) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                 $obj->DISPLAY_FIELD = "service_request_name_ar";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                //  $obj->UNIQUE_KEY = array('');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 1; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                                $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'ServiceRequest',"submit"=>true);
                        }
                        else 
                        {
                                ServiceRequestArTranslator::initData();
                                ServiceRequestEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'idn' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '15', 'MAXLENGTH' => '15', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 'READONLY', 'READONLY'=>true,  'TEXT-SEARCHABLE-SEPARATED' => true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'first_name' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE-AR' => true,'RETRIEVE' => true,   
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'last_name' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE-AR' => true,  'RETRIEVE' => true, 
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'mobile' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => false,  'RETRIEVE' => false, 
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '15', 'MAXLENGTH' => '15', 'UTF8' => true,'TEXT-SEARCHABLE-SEPARATED' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'email' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => false,  'RETRIEVE' => false, 
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => true,  'TEXT-SEARCHABLE-SEPARATED' => true,
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'service_category_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'FK',  'ANSWER' => 'service_category',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),	


'service_item_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'FK',  'ANSWER' => 'service_item',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),	


'subject' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => false,  'RETRIEVE-AR' => false,  'RETRIEVE' => false, 
        'EDIT' => false,  'QEDIT' => false,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => false,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        

'applicant_file_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'FK',  'ANSWER' => 'applicant_file',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),	

'application_plan_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),

'applicant_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'FK',  'ANSWER' => 'applicant',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => true,'AUTOCOMPLETE-SEARCH'=>true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_50', ),
'applicantFileIdLink' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'TEXT',"CATEGORY"=>"FORMULA",  'ANSWER' => 'applicant_file',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),	

'applicantIdLink' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'TEXT', "CATEGORY"=>"FORMULA", 'ANSWER' => 'applicant',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => true,'AUTOCOMPLETE-SEARCH'=>true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_50', ),

'description' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => 'AEREA', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_100',),        




'request_status_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'FK',  'ANSWER' => 'request_status',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),
/*'request_type_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => false,  'RETRIEVE' => false,  
        'EDIT' => false,  'QEDIT' => false, 'SHOW-ADMIN' => false,  'EDIT-ADMIN' => false,  'UTF8' => false,  
        'TYPE' => 'FK',  'ANSWER' => 'request_type',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
        'DISPLAY' => false,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),*/
'status_comment' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,  
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
        'TYPE' => 'TEXT',   'SIZE' => "AREA",  
        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25', ),
'status_date' => [
                    'IMPORTANT' => 'IN',
                    'SEARCH' => false,
                    'SHOW' => false,
                    'RETRIEVE' => false,
                    'EDIT' => true,
                    'QEDIT' => true,
                    'SEARCH-ADMIN' => true,
                    'SHOW-ADMIN' => true,
                    'EDIT-ADMIN' => true,
                    'UTF8' => false,
                    'TYPE' => 'GDAT',
                    'FORMAT' => 'LONG',
                    'STEP' => 1,
                    'DISPLAY-UGROUPS' => '',
                    'EDIT-UGROUPS' => '',
                    'CSS' => 'width_pct_25',
                    'READONLY'=>false,
                ],

                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
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
                                                                        'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>