<?php 
        class AdmInstitutionAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof Institution) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = "institution_name_ar";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                $obj->UNIQUE_KEY = array('institution_code');
                                $obj->public_display = true;
                                $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 4; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                        else
                        {
                                InstitutionArTranslator::initData();
                                InstitutionEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => false,
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),

                                        'institution_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_50',),
        
                                        'country_id' => array(
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'QSEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'EDIT' => true,
                                                'QEDIT' => true,
                                                'SHOW-ADMIN' => true,
                                                'EDIT-ADMIN' => true,
                                                'UTF8' => false,
                                                'TYPE' => 'FK',
                                                'ANSWER' => 'country',
                                                'ANSMODULE' => 'ums',
                                                'SIZE' => 40,
                                                'DEFAUT' => 0,
                                                'DISPLAY' => true,
                                                'STEP' => 1,
                                                'RELATION' => 'ManyToOne',
                                                'MANDATORY' => true,
                                                'READONLY' => false,
                                                'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_50',
                                        ),

                                        'institution_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_50',),
                                                


                                        'institution_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => false,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_50',),
                                                


                                        
                                                


                                        'map_location' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_75',),
                                                


                                        'website' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_100',),
                                                


                                        'logo_file_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,
                                                'TYPE' => 'FK',  'ANSWER' => 'workflow_file',  'ANSMODULE' => 'workflow',  'SIZE' => 40,  'DEFAUT' => 0,   
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        'background_file_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,
                                                'TYPE' => 'FK',  'ANSWER' => 'workflow_file',  'ANSMODULE' => 'workflow',  'SIZE' => 40,  'DEFAUT' => 0,
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_50', ),	

                                        'adress' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_75',),
                                        'adress_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_75',),
                                                
                                        
                                        'postal_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '10', 'MAXLENGTH' => '10', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',), 


                                        'orgunit_id' => array(
                                                'SHORTNAME' => 'orgunit',
                                                'SEARCH' => true,
                                                'QSEARCH' => true,
                                                'INTERNAL_QSEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'EDIT' => true,
                                                'QEDIT' => false,
                                                'EDIT_IF_EMPTY' => true,
                                                'SIZE' => 40,
                                                'MANDATORY' => false,
                                                'UTF8' => false,
                                                'CSS' => 'width_pct_25',
                                                'TYPE' => 'FK',
                                                'ANSWER' => 'orgunit',
                                                'ANSMODULE' => 'hrm',
                                                'RELATION' => 'OneToOne',
                                                'READONLY' => true,
                                                'SEARCH-BY-ONE' => true,
                                                'DISPLAY' => true,
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'ERROR-CHECK' => true,
                                        ),   
                                        
                                                'adm_orgunit_id' => array(
                                                        'SHOW' => true,
                                                        'EDIT' => true,
                                                        'QEDIT' => false,
                                                        'SIZE' => 40,
                                                        'MANDATORY' => false,
                                                        'UTF8' => false,
                                                        'CSS' => 'width_pct_75',
                                                        'TYPE' => 'FK',
                                                        'ANSWER' => 'adm_orgunit',
                                                        'ANSMODULE' => 'adm',
                                                        'CATEGORY' => 'FORMULA',
                                                        'RELATION' => 'OneToOneU',
                                                        'OTM-NO-LABEL' => true,
                                                        'READONLY' => true,
                                                        'SEARCH-BY-ONE' => true,
                                                        'DISPLAY' => true,
                                                        'STEP' => 1,
                                                        'DISPLAY-UGROUPS' => '',
                                                        'EDIT-UGROUPS' => '',
                                                        'ERROR-CHECK' => true,
                                                ),
                                        'Institution_description_ar' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false,  
                                                'SIZE' => "area",   'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'TEXT',  'READONLY' => false,  'DNA' => true, 
                                                'CSS' => 'width_pct_50', ),
                                        'Institution_description_en' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false,  
                                                'SIZE' => "area",    'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'TEXT',  'READONLY' => false,  'DNA' => true, 
                                                'CSS' => 'width_pct_50', ),

                                        'facebook_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '250', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
                                                


                                        'linkedin_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '250', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
                                                


                                        'youtube_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '250', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
                                                


                                        'snapchat_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
                                                


                                        'twitter_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '250', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
                                                


                                        'instagram_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '250', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),
        

                                               

                                        'application_model_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 3,  'RELATION' => 'OneToMany', 'MANDATORY' => false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'DEPENDENT_OFME' => array("application_plan_id"), 
                                                'CSS' => 'width_pct_50', ),  

                                        'application_plan_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  
                                                'WHERE' => "application_model_id = §application_model_id§",
                                                'DEPENDENCIES' => ['application_model_id'],
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 3,  'RELATION' => 'OneToMany', 'MANDATORY' => false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	
                                        
                                        'simulation_applicants_ids' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => 'AEREA', 'UTF8' => true, 'ROWS' => 4, 
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 3, 'MANDATORY' => false,   
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',), 


                                        'application_simulation_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_simulation',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 1,    
                                                'DISPLAY' => true,  'STEP' => 3,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        'apiEndpointList' => array('SHORTNAME' => 'apiEndpoints',  'SHOW' => true,  'FORMAT' => 'retrieve',  
                                                                        'ICONS' => true,  'D'.'ELETE-ICON' => true, 'MOVE_UP-ICON' => true,  'BUTTONS' => true,  
                                                                        'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                                        'EDIT' => false,  'QEDIT' => false,  
                                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                                        'TYPE' => 'FK', 'STEP' => 4,  
                                                                        'CATEGORY' => 'ITEMS',  'ANSWER' => 'api_endpoint',  'ANSMODULE' => 'adm',  'ITEM' => 'institution_id',  'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                                        'CSS' => 'width_pct_100', ),                                                

                                        
                                         'main_color1' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '10', 'MAXLENGTH' => '10', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),
                                         'main_color2' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '10', 'MAXLENGTH' => '10', 'UTF8' => true,
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),
                                         'horizontal_logo_file_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => false,
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,
                                                'TYPE' => 'FK',  'ANSWER' => 'workflow_file',  'ANSMODULE' => 'workflow',  'SIZE' => 40,  'DEFAUT' => 0,   
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),          

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
                                                                        'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>