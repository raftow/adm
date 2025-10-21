<?php 
        class AdmApplicationPlanBranchAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof ApplicationPlanBranch) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD_BY_LANG = ['ar'=>"name_ar", 'en'=>"name_en"];
                                $obj->ORDER_BY_FIELDS = "application_plan_id, branch_order";
                                $obj->UNIQUE_KEY = array('application_plan_id','program_offering_id','gender_enum','training_period_enum');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;
                                $obj->MOVE_UP_ACTION = true;
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

                                        'application_plan_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25', ),
                                                
                                                'gender_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => false,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 'READONLY'=>true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),	

                                                'training_period_enum' => array('IMPORTANT' => 'IN',  
                                                        'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true, 'READONLY' => true, 'QEDIT' => false,  'QSEARCH' => true,  
                                                        'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),

                                                
                                                'academic_level_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'academic_level',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),

                                                'term_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'academic_term',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>true,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),
                                                        	
        
        

                                'department_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'department',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'WHERE'=>"id in (select department_id from §DBPREFIX§adm.academic_program where academic_level_id = §academic_level_id§ and genders_enum in (3,§gender_enum§) and active = 'Y')",
                                                        'DEPENDENCIES' => ['academic_level_id', 'gender_enum',],
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                        'MANDATORY' => false, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'DEPENDENT_OFME' => array("major_id", "program_id", "training_unit_id",),
                                                        'CSS' => 'width_pct_50', ),	
        
                                'major_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'major',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        // 'WHERE'=>"id in (select major_id from §DBPREFIX§adm.academic_program where department_id = §department_id§ and academic_level_id = §academic_level_id§ and genders_enum in (3,§gender_enum§) and active = 'Y')",
                                                        // id in (select major_id from §DBPREFIX§adm.major_department where department_id = §department_id§ and active = 'Y') and 
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne',                                                         
                                                        'READONLY'=>true, 'AUTOCOMPLETE' => false, 'MANDATORY' => false,
                                                        'DEPENDENCIES' => ['department_id','academic_level_id', 'gender_enum',],
                                                        'DEPENDENT_OFME' => array("program_id", "training_unit_id", ),
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),

                                'program_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'academic_program',  'ANSMODULE' => 'adm',  
                                                        // 'WHERE'=>"academic_level_id = §academic_level_id§ and department_id = §department_id§ and major_id = §major_id§ and genders_enum in (3,§gender_enum§)",
                                                        'DEPENDENCIES' => array("major_id", "department_id", 'academic_level_id', 'gender_enum',),
                                                        'DEPENDENT_OFME' => array("training_unit_id", ),
                                                        'SIZE' => 40,  'DEFAUT' => 0,     
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                        'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),
        
                                                        
                                'training_unit_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'training_unit',  'ANSMODULE' => 'adm',  
                                                'WHERE'=>"id in (select training_unit_id from §DBPREFIX§adm.academic_program_offering where academic_level_id = §academic_level_id§ and department_id = §department_id§ and major_id = §major_id§ and gender_enum=§gender_enum§ and academic_program_id = §program_id§ and active = 'Y') and gender_enum=§gender_enum§",
                                                'DEPENDENCIES' => array("major_id", "department_id", 'academic_level_id', 'gender_enum', 'program_id',),
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	

                                                'program_offering_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => false,  'RETRIEVE' => false,  
                                                        'EDIT' => false,  'QEDIT' => false, 'UTF8' => false,  
                                                        /* 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  */
                                                        'TYPE' => 'FK',  'ANSWER' => 'academic_program_offering',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0, 
                                                        // 'WHERE' => "academic_level_id = §academic_level_id§ and gender_enum in (3, §gender_enum§)",
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => true,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),
                                                        
                                                'application_model_branch_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => false,  'RETRIEVE' => false,  
                                                        'EDIT' => false,  'QEDIT' => false, 'UTF8' => false,  
                                                        /* 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  */
                                                        'TYPE' => 'FK',  'ANSWER' => 'application_model_branch',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0, 
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => true,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),


                                                                                                 
                                        'branch_order' => array('IMPORTANT' => 'IN',  'SHOW' => true, 'RETRIEVE' => true,  'EXCEL' => false,  
                                                                'EDIT' => true,  'QEDIT' => true,  'EDIT_FGROUP' => true,  
                                                                'DISABLE-READONLY-ADMIN' => true,
                                                                // 'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  
                                                                'TYPE' => 'INT',    'MANDATORY' => true,  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
                                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,  'ERROR-CHECK' => true, 
                                                                'CSS' => 'width_pct_50',
                                                                ),




                                        	



                                        'name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '200', 'MAXLENGTH' => '200', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                


                                        'name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '200', 'MAXLENGTH' => '200', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                


                                        



                                       



                                        'confirmation_days' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),



                                        'deaf_specialty' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => false, 
                                                'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),



                                        'application_end_date' => [
                                                'IMPORTANT' => 'IN',
                                                'SEARCH' => true,
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'EDIT' => true,
                                                'QEDIT' => false,
                                                'SEARCH-ADMIN' => true,
                                                'SHOW-ADMIN' => true,
                                                'EDIT-ADMIN' => true,
                                                'UTF8' => false,
                                                'TYPE' => 'GDAT',
                                                'FORMAT' => 'LONG',
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                
                                                'CSS' => 'width_pct_25',
                                            ],

                                        'hijri_application_end_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  
                                            'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'UTF8' => false,  
                                            'TYPE' => 'DATE',  'STEP' => 2,    'DISPLAY' => true, 'MANDATORY' => false, /* 'FORMAT' => 'CONVERT_NASRANI_2LINES',*/
                                            'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,
                                            'CSS' => 'width_pct_25',),



                                        'min_weighted_percentage' => array('STEP' => 2,  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
                                                                        'EDIT' => true,  'QEDIT' => true,  
                                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'PCTG',  /*'UNIT' => '%', */ 'READONLY' => false,  'DNA' => true, 
                                                                        'CSS' => 'width_pct_25', ),

                                        'cond_weighted_percentage' => array('STEP' => 2,  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
                                                                        'EDIT' => true,  'QEDIT' => true,  
                                                                        'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => true,  'UTF8' => false,  
                                                                        'TYPE' => 'PCTG',  /*'UNIT' => '%', */ 'READONLY' => false,  'DNA' => true, 
                                                                        'CSS' => 'width_pct_25', ),


                                                                       

                                        'min_app_score1' => array('STEP' => 2,
                                                'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                                                'RETRIEVE' => false,
                                                'SHOW' => true,
                                                'EDIT' => true,
                                                'READONLY' => true,
                                                'SIZE' => 255,
                                                'CSS' => 'width_pct_25',
                                        ),

                                        'min_app_score2' => array('STEP' => 2,
                                                'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                                                'SHOW' => true,
                                                'EDIT' => true,
                                                'READONLY' => true,
                                                'SIZE' => 255,
                                                'CSS' => 'width_pct_25',
                                        ),

                                        'min_app_score3' => array('STEP' => 2,
                                                'TYPE' => 'FLOAT', 'FORMAT' => '*.2', 
                                                'SHOW' => true,
                                                'EDIT' => true,
                                                'READONLY' => true,
                                                'SIZE' => 255,
                                                'CSS' => 'width_pct_25',
                                        ),
                                                

                                        'is_open' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3, 'MANDATORY' => false, 
                                                'QSEARCH' => false, 'QEDIT' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),


                                        'seats_capacity' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 3, 'UNIT' => 'مقعد',
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),        

                                        'allow_direct_adm' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 3, 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'direct_adm_capacity' => array(
                                                        'IMPORTANT' => 'IN',
                                                        'SHOW' => true,
                                                        'RETRIEVE' => false,
                                                        'EDIT' => true,
                                                        'TYPE' => 'INT', 'MANDATORY' => false, 
                                                        'STEP' => 3, 'UNIT' => 'مقعد',
                                                        'DISPLAY-UGROUPS' => '',
                                                        'EDIT-UGROUPS' => '',
                                                        'CSS' => 'width_pct_25',),

                                                        
                                        'capacity_track1' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 3,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),                                                

                                        'capacity_track2' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 3,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),                                                                                                

                                        'capacity_track3' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 3,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),                                                                                                

                                        'capacity_track4' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => false,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 3,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),   
                                                
                                        'sorting_group_id' => array('SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'sorting_group',  'ANSMODULE' => 'adm',  
                                                        'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 3,  'RELATION' => 'ManyToOne', 'READONLY'=>true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),                                                       

                                        /*        
                                        'sortingBranchList' => array('SHORTNAME' => 'sortingBranchs',  'SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'STEP' => 3,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'sorting_branch',  'ANSMODULE' => 'adm',  'ITEM' => 'application_plan_branch_id',  'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_100', ),*/


                                        'applicationDesireList' => array('SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH' => false,  'QSEARCH' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
                                                'EDIT' => false,  'QEDIT' => false,  
                                                'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => false,  'UTF8' => false,  
                                                'TYPE' => 'FK', 'STEP' => 4,  
                                                'CATEGORY' => 'ITEMS',  'ANSWER' => 'application_desire',  'ANSMODULE' => 'adm',  'ITEM' => 'application_plan_branch_id', 'SHOW_MAX_DATA'=>100, 
                                                'READONLY' => true,  'CAN-BE-SETTED' => true, 
                                                'CSS' => 'width_pct_100', ),

                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => false, 'DEFAUT' => 'Y',  
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