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
                                // $obj->UNIQUE_KEY = array('institution_code','institution_name_ar','institution_name_en');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 2; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
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
        'CSS' => 'width_pct_25',),
        


'institution_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_50',),
        


'institution_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '30', 'MAXLENGTH' => '30', 'UTF8' => false,
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_50',),
        


'sci_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_25',),
        


'country_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_25',),
        


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
        


'logo_file_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,
        'TYPE' => 'FK',  'ANSWER' => 'adm_file',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,   
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_50', ),	


'background_file_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,
        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,
        'TYPE' => 'FK',  'ANSWER' => 'adm_file',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,
        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_50', ),	


'facebook_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'linkedin_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'youtube_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'snapchat_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'twitter_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        


'instagram_profile_link' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_25',),
        



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
                                                                        'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'pag', 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>