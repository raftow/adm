<?php 
        class AdmAcademicYearAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof AcademicYear) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
                                $obj->DISPLAY_FIELD = "academic_year_code";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                // $obj->UNIQUE_KEY = array('xxxx','yyyy');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 2; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'academic_year_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '4', 'MAXLENGTH' => '4', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                
                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        


                                        'start_date' => [
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
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
                                            ],


                                        'end_date' => [
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
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
                                            ],

                                        'term_mode_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                            'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                            'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                            'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                            'CSS' => 'width_pct_50', ),	


                                        'hijri_start_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 1,    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
                                                                        'CSS' => 'width_pct_25',),


                                        'hijri_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'DATE',  'STEP' => 1,    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true, 
                                                                        'CSS' => 'width_pct_25',),

                                                        'academicTermList' => array('TYPE' => 'FK', 'ANSWER' => 'academic_term', 'ANSMODULE' => 'adm', 
                                                                        'CATEGORY' => 'ITEMS', 'ITEM' => 'academic_year_id', 'STEP' => 2,
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
                                                                        'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true,  'QEDIT' => false, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>