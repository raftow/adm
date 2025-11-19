<?php 
        class AdmGradingScaleAfwStructure
        {
        
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof GradingScale) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                                $obj->DISPLAY_FIELD_BY_LANG = ['ar'=>"value_ar", 'en'=>"value_en", ];
                                // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                                $obj->UNIQUE_KEY = array('mark_min','mark_max');
                                // $obj->public_display = true;
                                $obj->IS_LOOKUP = true;

                                $obj->editByStep = false;
                                //$obj->editNbSteps = 1; 
                                // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                                $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'GradingScale',"submit"=>true);
                        }
                        else 
                        {
                                GradingScaleArTranslator::initData();
                                GradingScaleEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE = array(
                                        'id' => array('SHOW' => false,  'RETRIEVE' => true,  'EDIT' => false,  
                                                'TYPE' => 'PK',    'DISPLAY' => true,  'STEP' => 1,  
                                                'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                                                'CSS' => 'width_pct_25',),

'grade_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => false,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_50',),
        


'grade_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_50',),
        


'value_ar' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-AR' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => true,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_50',),
        


'value_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE-EN' => true,  
        'EDIT' => true,  'QEDIT' => true,  'SIZE' => '100', 'MAXLENGTH' => '100', 'UTF8' => false,  
        'TYPE' => 'TEXT',    'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => false,  
        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
        'CSS' => 'width_pct_50',),
        


'mark_min' => array(
        'IMPORTANT' => 'IN',
        'SHOW' => true,
        'RETRIEVE' => false,
        'QEDIT' => true,
        'EDIT' => true,
        'TYPE' => 'INT', 'MANDATORY' => false, 
        'STEP' => 1,
        'DISPLAY-UGROUPS' => '',
        'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_50',),



'mark_max' => array(
        'IMPORTANT' => 'IN',
        'SHOW' => true,
        'RETRIEVE' => false,
        'QEDIT' => true,
        'EDIT' => true,
        'TYPE' => 'INT', 'MANDATORY' => false, 
        'STEP' => 1,
        'DISPLAY-UGROUPS' => '',
        'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_50',),



'level' => array(
        'IMPORTANT' => 'IN',
        'SHOW' => true,
        'RETRIEVE' => true,
        'QEDIT' => true,
        'EDIT' => true,
        'TYPE' => 'INT', 'MANDATORY' => false, 
        'STEP' => 1,
        'DISPLAY-UGROUPS' => '',
        'EDIT-UGROUPS' => '',
        'CSS' => 'width_pct_50',),




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