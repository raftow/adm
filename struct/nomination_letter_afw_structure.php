<?php 

     
        class AdmNominationLetterAfwStructure
        {
                // token separator = §
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof NominationLetter ) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                                $obj->DISPLAY_FIELD_BY_LANG = ['ar'=>"letter_code", 'en'=>"letter_code"];
                                
                                // $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                                $obj->ORDER_BY_FIELDS = "";
                                $obj->editByStep = true;
                				$obj->editNbSteps = 2;
                                
                                
                                 $obj->UNIQUE_KEY = array('application_plan_id','nominating_authority_id','letter_code');
                                
								$obj->showQeditErrors = true;
								$obj->showRetrieveErrors = true;
								$obj->general_check_errors = true;
                                // $obj->after_save_edit = array("class"=>'NominationLetter',"attribute"=>'xxxx_id', "currmod"=>'adm',"currstep"=>2);
                                $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'NominationLetter',"submit"=>true);
                        }
                        else 
                        {
                                NominationLetterArTranslator::initData();
                                NominationLetterEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE =  
     array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

		
		

		'application_plan_id' => array('SHORTNAME' => 'plan',  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  
				'RELATION' => 'unkn',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),

		/*'nominating_authority_source_enum' => array('SHORTNAME' => 'nominating',  'SEARCH' => false,  'QSEARCH' => false,  'SHOW' => false,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => false,  'QEDIT' => false,  
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',  'READONLY' => false,  'DNA' => true, 
                                'DEPENDENCIES' => [],
                                'WHERE' => '',
                                'DEPENDENT_OFME' => array("nominating_authority_id"), 
				'CSS' => 'width_pct_50', ),*/
                'letter_code' => array('SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 20,  'MAXLENGTH' => 20,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => true,  'UTF8' => false,  
				'TYPE' => 'TEXT',  'READONLY' => false, 
				'CSS' => 'width_pct_25', ),
		'nominating_authority_id' => array('SHORTNAME' => 'authority',  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'nominating_authority',  'ANSMODULE' => 'adm',  
				'RELATION' => 'unkn',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50',
                                //'WHERE' => ' nominating_authority_source_enum = "§nominating_authority_source_enum§"',
                                //'DEPENDENCIES' => ['nominating_authority_source_enum'],
                                'DEPENDENT_OFME' => array("sponsor_cordinator_id"), 
                         ),

		'nomination_letter_date' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 10,  'MAXLENGTH' => 10,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'DATE',  'FORMAT' => 'HIJRI_UNIT',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),

		'sponsor_cordinator_id' => array('SHORTNAME' => 'cordinator',  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 32,  'MAXLENGTH' => 32,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'sponsor_cordinator',  'ANSMODULE' => 'adm',  
				'RELATION' => 'unkn',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50',
                                'WHERE' => 'nominating_authority_id="§nominating_authority_id§"',
                                'DEPENDENCIES' => ['nominating_authority_id'],
                         ),

		'nomination_letter_file_id' => array('STEP' => 1,  'SHORTNAME' => 'admfile',  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 40,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'workflow_file',  'ANSMODULE' => 'workflow',  
				'RELATION' => 'ManyToOne',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),
                'download_light' => array('STEP' => 1,  
				'TYPE' => 'TEXT',  
				'SHORTCUT_CATEGORY' => 'FORMULA', 'CATEGORY' => 'SHORTCUT', 
                                'SHORTCUT'=>"nomination_letter_file_id.download_light", 'SHOW' => true,  
                                'RETRIEVE' => true,  'EDIT' => false,  'QEDIT' => false,  'READONLY' => true,  
                                'RO_DIV_CLASS' => 'empty_div',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',),
		'nominationCandidateList' => array('TYPE' => 'FK', 'ANSWER' => 'nominating_candidates', 'ANSMODULE' => 'adm', 
                                                'CATEGORY' => 'ITEMS', 'ITEM' => 'nomination_letter_id', 'STEP' => 2,                                                
                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => false, 
                                                'ICONS'=>true, 'DELETE-ICON'=>true, 'VIEW-ICON'=>false, 'BUTTONS'=>true, 'NO-LABEL'=>false),                                                


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

