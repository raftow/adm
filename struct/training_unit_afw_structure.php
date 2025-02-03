<?php 
        class AdmTrainingUnitAfwStructure
        {
            public static $MY_ATABLE_ID=13871; 
            
            // إجراء إحصائيات حول المنشآت التدريبية 
            public static $bf_tu_stats = 104672; 
            // إدارة المنشآت التدريبية 
            public static $bf_tu_qedit = 104667; 
            // إنشاء منشاة تدريبية 
            public static $bf_tu_edit = 104666; 
            // الاستعلام عن منشاة تدريبية 
            public static $bf_tu_qsearch = 104671; 
            // البحث في المنشآت التدريبية 
            public static $bf_tu_search = 104670; 
            // عرض تفاصيل منشاة تدريبية 
            public static $bf_tu_display = 104669; 
            // مسح منشاة تدريبية 
            public static $bf_tu_delete = 104668; 
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof TrainingUnit) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                                $obj->DISPLAY_FIELD = "training_unit_name_ar";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                $obj->UNIQUE_KEY = array('institution_id','training_unit_code');
                                // $obj->public_display = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 6; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                                $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'TrainingUnit',"submit"=>true);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'city_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'city',  'ANSMODULE' => 'ums',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'institution_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'institution',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        // this attribute is applicable or no depend on system config of config->amd_options->tu_college is one or many
                                        'training_unit_type_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => '::applicable',  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'training_unit_type',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	


                                        'training_unit_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,   
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '10', 'MAXLENGTH' => '10', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                
                                        
                                        
                                        'sis_unit_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '10', 'MAXLENGTH' => '10', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        
                                        'gender_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),	
                                                
                                        
                                        
                                        'training_unit_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                
                                        
                                        
                                        'training_unit_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                
                                        'maqbool_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true, 'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '6', 'MAXLENGTH' => '6', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                
                                        
                                        'description' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true, 
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '200', 'MAXLENGTH' => '200', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_75',),
                                        
                                        
                                                
                                        
                                        
                                        'map_location' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true, 
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '60', 'MAXLENGTH' => '60', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                
                                        
                                        
                                        'website' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                
                                        
                                        
                                        'adress' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true, 
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_75',),
                                                
                                        
                                        
                                        'postal_code' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,    
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '10', 'MAXLENGTH' => '10', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'national_adress' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '50', 'MAXLENGTH' => '50', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        

                                        
                                                
                                        
                                        
                                        'email' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true, 
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '64', 'MAXLENGTH' => '64', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
        
                                        
                                        
                                        
                                        'phone' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true, 
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '12', 'MAXLENGTH' => '12', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),
                                                
                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 2,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),


                                                'trainingUnitDepartmentList' => array('SHOW' => true, 'STEP' => 5,   
                                                    'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  
                                                    'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                    'EDIT' => false,  'QEDIT' => false,  
                                                    'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  
                                                    'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                    'TYPE' => 'FK', 'CATEGORY' => 'ITEMS',  'ANSWER' => 'training_unit_department',  'ANSMODULE' => 'adm',  'ITEM' => 'training_unit_id',  
                                                    'READONLY' => true,  
                                                    'CSS' => 'width_pct_100', ),

                                                // this attribute is applicable or no depend on system config of config->amd_options->tu_college is many or one   
                                                'trainingUnitCollegeList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => false,  'DELETE-ICON' => false,  'BUTTONS' => true,  
                                                    'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                    'EDIT' => false,  'QEDIT' => false, 'STEP' => 4, 
                                                    'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                    'TYPE' => 'FK',  'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  
                                                    'CATEGORY' => 'ITEMS',  'ANSWER' => 'training_unit_college',  'ANSMODULE' => 'adm',  'ITEM' => 'training_unit_id',  
                                                    'LOGICAL_DELETED_ITEMS_ALSO' => true,
                                                    'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                    'CSS' => 'width_pct_100', 
                                                ),

                                                'academicLevelOfferingList' => array('TYPE' => 'FK', 'ANSWER' => 'academic_level_offering', 
                                                        'ANSMODULE' => 'adm', 
                                                        'CATEGORY' => 'ITEMS', 'ITEM' => 'training_unit_id', 'STEP' => 3,
                                                        //'WHERE'=>'xxx = §xxx§', 'HIDE_COLS' => array(),
                                                        'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                        'ICONS'=>true, 'DELETE-ICON'=>true, 'BUTTONS'=>true, 'NO-LABEL'=>false,
                                                        'CSS' => 'width_pct_100', 
                                                ),

                                                'academicProgramOfferingList' => array('TYPE' => 'FK', 'ANSWER' => 'academic_program_offering', 'ANSMODULE' => 'adm', 
                                                        'CATEGORY' => 'ITEMS', 'ITEM' => 'training_unit_id', 'STEP' => 6,
                                                        // 'WHERE'=>'xxx = §xxx§', 'HIDE_COLS' => array(),
                                                        'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                        'ICONS'=>true, 'DELETE-ICON' => true, 
                                                        'VIEW-ICON' => false,'BUTTONS'=>true, 'NO-LABEL'=>false),


                                        
        
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

                                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', 'SHOW-ADMIN' => true, 
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>