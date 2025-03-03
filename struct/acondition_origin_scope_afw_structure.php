<?php 
        class AdmAconditionOriginScopeAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof AconditionOriginScope) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                // $obj->DISPLAY_FIELD = "acondition_origin_scope_name_ar";
                                $obj->ORDER_BY_FIELDS = "acondition_origin_id,application_model_id,training_unit_id,department_id,application_model_branch_id";
                                $obj->UNIQUE_KEY = array('acondition_origin_id','application_model_id','training_unit_id','department_id','application_model_branch_id');
                                
                                // temp for demo amjad @todo : to remove and make previleges
                                $obj->public_display = true;
                                // $obj->IS_LOOKUP = true;

                                $obj->editByStep = true;
                                $obj->editNbSteps = 2; 
                                $obj->after_save_edit = array("class"=>'AconditionOrigin',"attribute"=>'acondition_origin_id', "currmod"=>'adm',"currstep"=>2);
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

                                        'acondition_origin_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'acondition_origin',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 'READONLY'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	

                                                'application_model_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => false,  'RETRIEVE' => false,  
                                                        'EDIT' => false,  'QEDIT' => false,  'UTF8' => false, 'CATEGORY' => 'SHORTCUT',  'SHORTCUT' => 'acondition_origin_id.application_model_mfk',
                                                        'TYPE' => 'MFK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',   
                                                        'WHERE' => 'id < 10 ',
                                                     
                                                        'DISPLAY' => true,  'STEP' => 99,  
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_100',),

                                                'program_track_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => false,  'RETRIEVE' => false,  
                                                        'EDIT' => false,  'QEDIT' => false,  'UTF8' => false, 'CATEGORY' => 'SHORTCUT',  'SHORTCUT' => 'acondition_origin_id.program_track_mfk',
                                                        'TYPE' => 'MFK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',   
                                                        'WHERE' => 'id < 10 ',
                                                     
                                                        'DISPLAY' => true,  'STEP' => 99,  
                                                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                        'CSS' => 'width_pct_100',),
                                                        

                                        'application_model_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model',  'ANSMODULE' => 'adm',  
                                                'WHERE' => "active = 'Y' and §application_model_mfk§ like concat('%,',id,',%')",
                                                'DEPENDENT_OFME' => array("training_unit_id", 'department_id', "application_model_branch_id"),
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => true, 
                                                'READONLY'=>false, 'READONLY-AFTER-INSERT'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        'training_unit_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'training_unit',  'ANSMODULE' => 'adm',  
                                                'WHERE' => "id in (select distinct apo.training_unit_id from §DBPREFIX§adm.academic_program_offering apo 
                                                                        inner join §DBPREFIX§adm.application_model_branch amb on amb.program_offering_id = apo.id
                                                                   where amb.application_model_id = §application_model_id§
                                                                     and apo.active = 'Y'
                                                                     and amb.active = 'Y')",
                                                'DEPENDENCIES' => ['application_model_id',],
                                                'DEPENDENT_OFME' => ['department_id', 'application_model_branch_id'],
                                                'SIZE' => 40,  
                                                'DEFAUT' => 0, 
                                                'MANDATORY' => false, 'READONLY'=>false, 'READONLY-AFTER-INSERT'=>true,    
                                                'AUTOCOMPLETE' => false, 'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'EMPTY_IS_ALL' => true,
                                                'CSS' => 'width_pct_50', ),	


                                        'department_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'department',  'ANSMODULE' => 'adm',  'SIZE' => 40,  
                                                'DEFAUT' => 0,    
                                                'WHERE' => "id in (select distinct apo.department_id from §DBPREFIX§adm.academic_program_offering apo 
                                                                        inner join §DBPREFIX§adm.application_model_branch amb on amb.program_offering_id = apo.id
                                                                   where amb.application_model_id = §application_model_id§
                                                                     and apo.active = 'Y'
                                                                     and amb.active = 'Y')
                                                            and id in (select distinct ud.department_id from §DBPREFIX§adm.training_unit_department ud where ud.training_unit_id = §training_unit_id§)       
                                                             ",
                                                'DEPENDENCIES' => ['application_model_id','training_unit_id',],
                                                'DEPENDENT_OFME' => ['application_model_branch_id',],
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 'EMPTY_IS_ALL' => true,
                                                'MANDATORY' => false, 'READONLY'=>false, 'READONLY-AFTER-INSERT'=>true, 'AUTOCOMPLETE' => false,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	


                                        'application_model_branch_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'application_model_branch',  'ANSMODULE' => 'adm',  'SIZE' => 40,  
                                                'DEFAUT' => 0,    
                                                'DEPENDENCIES' => ['application_model_id',],
                                                'WHERE' => 'application_model_id = §application_model_id§
                                                           and ((§training_unit_id§ = 0) or (training_unit_id = §training_unit_id§))          
                                                           and ((§department_id§ = 0) or (department_id = §department_id§))',
                                                'DEPENDENCIES' => ['application_model_id','training_unit_id','department_id'],
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne', 
                                                'MANDATORY' => false, 'READONLY'=>false, 'READONLY-AFTER-INSERT'=>true, 
                                                'AUTOCOMPLETE' => false, 'AUTOCOMPLETE-SEARCH' => true,'EMPTY_IS_ALL' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),	

                                        'program_track_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => true,  
                                                'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                                                'TYPE' => 'FK',  'ANSWER' => 'program_track',  'ANSMODULE' => 'adm',  
                                                'WHERE' => "active = 'Y' and §program_track_mfk§ like concat('%,',id,',%')",
                                                // 'DEPENDENT_OFME' => array("xxxx"),
                                                'SIZE' => 40,  'DEFAUT' => 0,    
                                                'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => false, 
                                                'READONLY'=>false, 'READONLY-AFTER-INSERT'=>true, 'AUTOCOMPLETE' => false,'EMPTY_IS_ALL' => true,
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_50', ),

                                        'active' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true, 'QEDIT' => true, 'DEFAUT' => 'Y',  
                                                'TYPE' => 'YN',    'FORMAT' => 'icon',  'STEP' => 2,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_100',),

                                        'applicationModelBranchList' => array('TYPE' => 'FK', 'ANSWER' => 'application_model_branch', 'ANSMODULE' => 'adm', 
                                                'CATEGORY' => 'ITEMS', 'ITEM' => '', 'STEP' => 2,
                                                'WHERE'=>'application_model_id = §application_model_id§
                                                        and ((§training_unit_id§ = 0) or (training_unit_id = §training_unit_id§))          
                                                        and ((§department_id§ = 0) or (department_id = §department_id§))          
                                                        and ((§application_model_branch_id§ = 0) or (id = §application_model_branch_id§))', 
                                                'HIDE_COLS' => array(),
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                'ICONS'=>false, 'DELETE-ICON'=>false,'VIEW-ICON'=>false,                                                
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
                                                                        'TOKEN_SEP'=>'§', 'READONLY'=>true, 'NO-ERROR-CHECK'=>true, 'FGROUP' => 'tech_fields'),				


                                ); 
        } 
?>