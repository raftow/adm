<?php 
        /*
        update `prog_offri` set al1 = 1 WHERE al1='دبلوم';
        update `prog_offri` set al1 = 6 WHERE al1='دبلوم الثانوي الصناعي';
        update `prog_offri` set al1 = 10 WHERE al1='برامج المعاهد الصناعية';

        truncate table academic_program_offering;

        insert into academic_program_offering(training_unit_id, gender_enum,department_id, major_id, academic_program_id, academic_level_id, degree_id) 
        SELECT training_unit_id, 0, department_id, major_id, program_id, al1, degree_id FROM `prog_offri` WHERE 1;


        update academic_program_offering set active='Y', version=0,created_by=1,created_at='2024-04-15';

        update `academic_program_offering` po set po.`gender_enum` = (select gender_enum from training_unit t where t.id = po.training_unit_id);
        */
        class AdmAcademicProgramOfferingAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof AcademicProgramOffering) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD = "program_name_ar";
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                $obj->UNIQUE_KEY = array('academic_program_id','training_unit_id');
                                // $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;
                                $obj->OwnedBy = array('module' => "adm", 'afw' => "AcademicProgram", 'afw2' => "TrainingUnit");
                                $obj->editByStep = true;
                                $obj->editNbSteps = 3; 
                                $obj->after_save_edit = array("class"=>'TrainingUnit',"attribute"=>'training_unit_id', "currmod"=>'adm',"currstep"=>6);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'training_unit_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'training_unit',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => '1',  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_75', ),	

                                                // initialization of gender_enum
                                                // update `academic_program_offering` po set po.`gender_enum` = (select gender_enum from training_unit t where t.id = po.training_unit_id);
                                                'gender_enum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true, 'READONLY' => false,
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_25', ),

                                        'department_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,    'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'department',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'WHERE'=>"id in (select department_id from §DBPREFIX§adm.academic_program where genders_enum in (3,§gender_enum§) and active = 'Y')",                                                        
                                                        'DEPENDENT_OFME' => array("major_id", "academic_program_id", ),
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>false,
                                                        'CSS' => 'width_pct_50', ),	


                                        'major_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,    'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'major',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'WHERE'=>"id in (select major_id from §DBPREFIX§adm.academic_program where department_id = §department_id§ and genders_enum in (3,§gender_enum§) and active = 'Y')",
                                                        'DEPENDENCIES' => ['department_id', 'gender_enum',],
                                                        'DEPENDENT_OFME' => array("academic_program_id"), 
                                                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>false,
                                                        'CSS' => 'width_pct_50', ),	


                                        'academic_program_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => false, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true,    'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'academic_program',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,   
                                                'WHERE'=>"(academic_level_id in (select academic_level_id from §DBPREFIX§adm.academic_level_offering where training_unit_id = §training_unit_id§)) and (department_id = §department_id§ or §department_id§=0) and (major_id = §major_id§ or §major_id§ = 0) and genders_enum in (3,§gender_enum§)",
                                                'DEPENDENCIES' => array("major_id", "department_id", 'academic_level_id', 'gender_enum',),
                                                'DEPENDENT_OFME' => array("training_unit_id", ), 
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	

                                        
                                                'academic_level_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                        'EDIT' => true,  'QEDIT' => true,    'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'academic_level',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>true,
                                                        'CSS' => 'width_pct_50', ),	

                                                        
                                                        
                                                'degree_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                                                        'EDIT' => true,  'QEDIT' => true,    'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                        'TYPE' => 'FK',  'ANSWER' => 'degree',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                        'DISPLAY' => true,  'STEP' => 2,  'RELATION' => 'ManyToOne', 'MANDATORY' => false, 
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'READONLY'=>true,
                                                        'CSS' => 'width_pct_50', ),	


                                        /*
                                        'training_period_menum' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'QSEARCH' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'MENUM',  'ANSWER' => 'FUNCTION',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false, 'CHECKBOX' => true, 'SIZE_CSS_CLASS'=>'width_pct_33',
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_75', ),*/
                                                
                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 1, 'CHECKBOX' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'program_name_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '128', 'UTF8' => true,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                                

                                        'program_name_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => false,  
                                                'EDIT' => true,  'QEDIT' => true,  'SIZE' => '50', 'MAXLENGTH' => '128', 'UTF8' => false,  
                                                'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 2, 'MANDATORY' => true,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50',),
                                        
                                                /*
                                        'seats_capacity_1' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),

                                        'seats_capacity_2' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),

                                        'seats_capacity_3' => array(
                                                'IMPORTANT' => 'IN',
                                                'SHOW' => true,
                                                'RETRIEVE' => false,
                                                'QEDIT' => true,
                                                'EDIT' => true,
                                                'TYPE' => 'INT', 'MANDATORY' => false, 
                                                'STEP' => 2,
                                                'DISPLAY-UGROUPS' => '',
                                                'EDIT-UGROUPS' => '',
                                                'CSS' => 'width_pct_25',),

                                        */

                                        'applicationModelBranchList' => array('TYPE' => 'FK', 'ANSWER' => 'application_model_branch', 'ANSMODULE' => 'adm', 
                                                'CATEGORY' => 'ITEMS', 'ITEM' => 'program_offering_id', 'STEP' => 3,
                                                // 'WHERE'=>'xxx = §xxx§', 'HIDE_COLS' => array(),
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                'ICONS'=>true, 'DELETE-ICON'=>true,
                                                'VIEW-ICON'=>false,
                                                'BUTTONS'=>true, 'NO-LABEL'=>false),


                                        
        
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
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>false, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>