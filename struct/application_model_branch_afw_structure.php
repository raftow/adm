<?php 
        class AdmApplicationModelBranchAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        global $_GET, $_POST;
                        if ($obj instanceof ApplicationModelBranch) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = "branch_name_ar";
                                $obj->ORDER_BY_FIELDS = "application_model_id, branch_order"; 
                                $obj->UNIQUE_KEY = array('application_model_id','program_offering_id','gender_enum','training_period_enum');
                                $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;
                                $obj->MOVE_UP_ACTION = true;
                                $obj->editByStep = true;
                                $obj->editNbSteps = 2; 
                                if(($_GET["class_parent"]=="AcademicProgramOffering") or
                                   ($_POST["class_parent"]=="AcademicProgramOffering"))
                                {
                                        $obj->after_save_edit = array("class"=>'AcademicProgramOffering',"attribute"=>'program_offering_id', "currmod"=>'adm',"currstep"=>3);
                                }
                                else
                                {
                                        // die("_GET[]=".var_export($_GET,true)." _POST[]=".var_export($_POST,true));
                                        $obj->after_save_edit = array("class"=>'ApplicationModel',"attribute"=>'application_model_id', "currmod"=>'adm',"currstep"=>4   );
                                }
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'application_model_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),                                                

                                        'program_offering_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 
                                                'SHOW' => false,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => false, 'UTF8' => false,  
                                                /* 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  */
                                                'TYPE' => 'FK',  'ANSWER' => 'academic_program_offering',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,                                                 
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),

                                                'sorting_group_id' => array('SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => false, 'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'sorting_group',  'ANSMODULE' => 'adm',  
                                                        'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'READONLY'=>true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),

                                                'training_unit_id' => array('IMPORTANT' => 'IN', 'SHOW' => true, 
                                                        'TYPE' => 'FK',  'ANSWER' => 'training_unit',  'ANSMODULE' => 'adm',  
                                                        'READONLY' => true,  'STEP' => 1,  
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50',
                                                         ),	

                                                'department_id' => array('IMPORTANT' => 'IN', 'STEP' => 1, 'SHOW' => true, 
                                                                'TYPE' => 'FK',  'ANSWER' => 'department',  'ANSMODULE' => 'adm',  
                                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>true, 
                                                                'CSS' => 'width_pct_50',
                                                                ),

                                                'major_id' => array('IMPORTANT' => 'IN', 'STEP' => 1, 'SHOW' => true,
                                                                'TYPE' => 'FK',  'ANSWER' => 'major',  'ANSMODULE' => 'adm',  
                                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>true,
                                                                'CSS' => 'width_pct_50',
                                                                ),

                                                'academic_program_id' => array('IMPORTANT' => 'IN', 'STEP' => 1, 
                                                                'SHOW' => true, 'EDIT' => true, 'READONLY'=>true,
                                                                'TYPE' => 'FK',  'ANSWER' => 'academic_program',  'ANSMODULE' => 'adm',  
                                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                                'CSS' => 'width_pct_50',
                                                                ),

                                                'gender_enum' => array('IMPORTANT' => 'IN',  'STEP' => 1, 
                                                        'SHOW' => true, 'EDIT' => true, 'READONLY' => true, 'RETRIEVE' => true,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  
                                                        'MANDATORY' => true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50',
                                                ),

                                                'training_period_enum' => array('IMPORTANT' => 'IN',  
                                                        'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true, 'READONLY' => true, 'QEDIT' => false,  'QSEARCH' => true,  
                                                        'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_50', ),

                                        

                                        'branch_order' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  
                                                                'TYPE' => 'INT',    'MANDATORY' => false,  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
                                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY' => true,  'ERROR-CHECK' => true, 
                                                                'CSS' => 'width_pct_50',
                                                                ),                                                

                                        'branch_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '50', 'MAXLENGTH' => '128', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 99, 'MANDATORY' => true, 'READONLY'=>true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                

                                        'branch_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
                                                'EDIT' => true,  'QEDIT' => false,  'SIZE' => '50', 'MAXLENGTH' => '128', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 99, 
                                                'MANDATORY' => false, /* shoould be true but for demo @todo */
                                                'READONLY'=>true, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),

                                                
                                                

                                        'seats_capacity' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'DISABLE_DATA_TABLE' => true,
                                                'RETRIEVE-POPUP-EDITOR' => ['branch_order','capacity',],
                                                'CSS' => 'width_pct_25',),

                                        'capacity_track1' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),                                                

                                        'capacity_track2' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),                                                                                                

                                        'capacity_track3' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),                                                                                                

                                        'capacity_track4' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'DEFAULT' => 0,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),                                                                                                
                                                                        
                                                
                                        'direct_adm_capacity' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => true,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '', 'UNIT' => 'مقعد',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),

                                        /*        
                                        'application_days' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '', 'UNIT' => 'يوم',
                                                'CSS' => 'width_pct_25',),*/



                                        'confirmation_days' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 1,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '', 'UNIT' => 'يوم',
                                                'CSS' => 'width_pct_25',),



                                        'deaf_specialty' => array('RETRIEVE' => false, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'N',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CHECKBOX'=>true, 'FORMAT' => 'icon',
                                                'CSS' => 'width_pct_25',),



                                        


                                        'is_open' => array('RETRIEVE' => true, 'SHOW' => true, 'EDIT' => true,  'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'QSEARCH' => false, 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CHECKBOX'=>true, 'FORMAT' => 'icon',
                                                'CSS' => 'width_pct_25',),

                                        
                                        'applicationPlanBranchList' => array('TYPE' => 'FK', 'ANSWER' => 'application_plan_branch', 'ANSMODULE' => 'adm', 
                                                'CATEGORY' => 'ITEMS', 'ITEM' => 'application_model_branch_id', 'STEP' => 2,                                                
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                'ICONS'=>true, 'DELETE-ICON'=>true, 'VIEW-ICON'=>false, 'BUTTONS'=>true, 'NO-LABEL'=>false),                                                



                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN', 'FORMAT' => 'icon',  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CHECKBOX'=>true,
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