<?php 

     
        class AdmSisProgramCodeAfwStructure
        {
                // token separator = §
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof SisProgramCode ) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                                $obj->DISPLAY_FIELD_BY_LANG = ['ar'=>array("name_ar","lookup_code"), 'en'=>array("name_en","lookup_code")];
                               // $obj->DISPLAY_FIELD = "lookup_code";
                                $obj->FORMULA_DISPLAY_FIELD = "concat(IF(ISNULL(name_ar), '', name_ar) , ' - ' , IF(ISNULL(lookup_code), '', lookup_code) ))";

                               // $obj->FORMULA_DISPLAY_FIELD = "concat(IF(ISNULL(name_ar2), '', name_ar) , ' ' , IF(ISNULL(lookup_code), '', lookup_code) ))";

                                
                                 $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                                $obj->ORDER_BY_FIELDS = "";
                                 
                                $obj->IS_LOOKUP = true;
                                
                                
                                $obj->UNIQUE_KEY = array('lookup_code', 'sis_level_code');
                                $obj->editByStep = false;
                                $obj->editNbSteps = 0;
                                $obj->showQeditErrors = true;
                                $obj->showRetrieveErrors = true;
                                $obj->general_check_errors = true;
                                // $obj->after_save_edit = array("class"=>'SisProgramCode',"attribute"=>'xxxx_id', "currmod"=>'adm',"currstep"=>2);
                                $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'SisProgramCode',"submit"=>true);
                        }
                        else 
                        {
                                SisProgramCodeArTranslator::initData();
                                SisProgramCodeEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE =  
     array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),
		'lookup_code' => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true, "SHORTNAME"=>"code", "DISPLAY" => true),

		'name_ar' => array('STEP' => 1,  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  'DiSPLAY' => true,
				'SIZE' => 128,  'MAXLENGTH' => 128,  'MIN-SIZE' => 5,  'CHAR_TEMPLATE' => "ARABIC-CHARS,SPACE",  'MANDATORY' => true,  'UTF8' => true,  
				'TYPE' => 'TEXT',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'name_en' => array('STEP' => 1,  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  'DiSPLAY' => true,
				'SIZE' => 128,  'MAXLENGTH' => 128,  'MIN-SIZE' => 5,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => true,  'UTF8' => false,  
				'TYPE' => 'TEXT',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),

		'desc_ar' => array('STEP' => 1,  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 'AREA',  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => true,  
				'TYPE' => 'TEXT',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_100', ),

		'desc_en' => array('STEP' => 1,  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 'AREA',  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'TEXT',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_100', ),
                'sis_level_code' => array('STEP' => 1,  'SHORTNAME' => 'level_code',  'SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 16,  'MAXLENGTH' => 16,  'MIN-SIZE' => 3,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'sis_level_code',  'ANSMODULE' => 'adm',  
				'RELATION' => 'ManyToOne',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),                
                'created_by'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false,  'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'created_at'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'updated_by'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'updated_at'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'validated_by'       => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'validated_at'       => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'active'             => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
                'version'            => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),
                'draft'             => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
                'update_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'delete_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'display_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'sci_id'            => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'tech_notes' 	      => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 'TOKEN_SEP'=>"§", 'READONLY' =>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
	);  
    
         }
    


// errors 

