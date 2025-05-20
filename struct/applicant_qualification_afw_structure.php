<?php
class AdmApplicantQualificationAfwStructure
{

        public static function initInstance(&$obj)
        {
                if ($obj instanceof ApplicantQualification) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                        $obj->DISPLAY_FIELD = array('applicant_id', 'qualification_id', 'major_category_id');
                        $obj->ORDER_BY_FIELDS = "applicant_id, date desc";
                        $obj->UNIQUE_KEY = array('applicant_id', 'qualification_id', 'major_category_id');
                        // tempo for amjad demo @todo
                        $obj->public_display = true;
                        // $obj->IS_LOOKUP = true;

                        // $obj->editByStep = true;
                        // $obj->editNbSteps = 1; 
                        $obj->after_save_edit = array("class" => 'Applicant', "attribute" => 'applicant_id', "currmod" => 'adm', "currstep" => 3);
                }
        }


        public static $DB_STRUCTURE = array(
                'id' => array(
                        'SHOW' => false,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'TYPE' => 'PK',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),

                'applicant_id' => array(
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'applicant',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'OneToMany',
                        'MANDATORY' => true,
                        'READONLY' => true,
                        'AUTOCOMPLETE' => true,
                        'AUTOCOMPLETE-SEARCH' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),


                'qualification_id' => array(
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'qualification',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne',
                        'MANDATORY' => true,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'DEPENDENT_OFME' => array("major_category_id", "source", "qualification_major_id"),
                        'CSS' => 'width_pct_50',
                ),

                'level_enum' => array(
                        'IMPORTANT' => 'HIGH',
                        'CATEGORY' => 'SHORTCUT',
                        'SHORTCUT' => 'qualification_id.level_enum',
                        'TYPE' => 'ENUM',
                        'ANSWER' => 'FUNCTION',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'STEP' => 99,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),

                // dependecy bring only ctegories that exists in major_path for this qualification_id   
                // done by medali     
                'major_category_id' => array(
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'major_category',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne',
                        'MANDATORY' => true,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'WHERE' => 'id in (select major_category_id from §DBPREFIX§adm.major_path where qualification_id=§qualification_id§ and active="Y")',
                        'DEPENDENCIES' => ['qualification_id'],
                        'DEPENDENT_OFME' => array("qualification_major_id"),
                        'CSS' => 'width_pct_50',
                ),


                'major_path_id' => array(
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => false,
                        'QSEARCH' => false,
                        'SHOW' => false,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'major_path',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => false,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne',
                        'MANDATORY' => true,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),

                // @todo  rafik dependency with major_category_id
                'qualification_major_id' => array(
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'qualification_major',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne',
                        'MANDATORY' => false,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'WHERE' => ' id in (select qualification_major_id from §DBPREFIX§adm.qual_major_path mp inner join §DBPREFIX§adm.major_path m on mp.major_path_id=m.id where m.qualification_id=§qualification_id§ and m.major_category_id=§major_category_id§)',
                        'DEPENDENCIES' => ['qualification_id', 'major_category_id'],
                        'DEPENDENT_OFME' => array(),
                        'CSS' => 'width_pct_50',
                ),


                'gpa' => array(
                        'IMPORTANT' => 'HIGH',
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'QEDIT' => true,
                        'EDIT' => true,
                        'SIZE' => 32,
                        'TYPE' => 'FLOAT',
                        'FORMAT' => '*.2',
                        'MANDATORY' => true,
                        'STEP' => 1,
                        'DISPLAY' => true,
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),

                

                'gpa_from' => array(
                        'IMPORTANT' => 'HIGH',
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'QEDIT' => true,
                        'EDIT' => true,
                        'TYPE' => 'INT',
                        'MANDATORY' => false,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'READONLY' => false,
                        'DISPLAY' => true,
                        'DEFAUT' => '',
                        'CSS' => 'width_pct_25'
                ),



                'date' => [
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'MANDATORY' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'DEFAUT' => '',
                        'CSS' => 'width_pct_25',
                ],

                'educational_zone_id' => array(
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => false,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'educational_zone',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => false,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne',
                        'MANDATORY' => true,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),

                // @todo medali dependency with qual_source
                'source' => array(
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '100',
                        'MAXLENGTH' => '100',
                        'UTF8' => true,
                        'TYPE' => 'FK',
                        'ANSWER' => 'qual_source',
                        'ANSMODULE' => 'adm',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'RELATION' => 'ManyToOne',
                        'WHERE' => 'qualification_id=§qualification_id§ ',
                        'DEPENDENCIES' => ['qualification_id'],
                        'CSS' => 'width_pct_25',
                ),
                'source_name' => array('SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 48,  'MAXLENGTH' => 48,  'MIN-SIZE' => 1,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => true,  
				'TYPE' => 'TEXT',  'READONLY' => false,  'DNA' => true, 
				'CSS' => 'width_pct_50', ),
                'qualification_major_desc' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'SIZE' => '100',
                        'MAXLENGTH' => '100',
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_100',
                ),



                'imported' => array(
                        'IMPORTANT' => 'HIGH',
                        'RETRIEVE' => true,
                        'SHOW' => true,
                        'EDIT' => true,
                        'DEFAUT' => 'N',
                        'TYPE' => 'YN',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => true,
                        'QSEARCH' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),



                'import_utility_id' => array(
                        'IMPORTANT' => 'HIGH',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'check_type',
                        'ANSMODULE' => 'adm',
                        'WHERE' => "api_group='IMPORT'",
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne-OneToMany',
                        'MANDATORY' => false,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),


                'adm_file_id' => array(
                        'STEP' => 1,
                        'SHORTNAME' => 'workflow_file',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 40,
                        'MAXLENGTH' => 32,
                        'DEFAUT' => 0,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'workflow_file',
                        'WHERE' => 'id in (select workflow_file_id from §DBPREFIX§adm.applicant_file where applicant_id = §applicant_id§ and doc_type_id = 6)', // DOC_TYPE_DIPLOMA = 6
                        'ANSMODULE' => 'workflow',
                        'RELATION' => 'ManyToOne',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),


                'active' => array(
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'DEFAUT' => 'Y',
                        'TYPE' => 'YN',
                        'FORMAT' => 'icon',
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),









                'created_by' => array(
                        'SHOW-ADMIN' => true,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'DISPLAY' => '',
                        'STEP' => 99,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_100',
                ),

                'created_at' => array(
                        'SHOW-ADMIN' => true,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'DISPLAY' => '',
                        'STEP' => 99,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_100',
                ),

                'updated_by' => array(
                        'SHOW-ADMIN' => true,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'DISPLAY' => '',
                        'STEP' => 99,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_100',
                ),

                'updated_at' => array(
                        'SHOW-ADMIN' => true,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'DISPLAY' => '',
                        'STEP' => 99,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_100',
                ),

                'validated_by' => array(
                        'SHOW-ADMIN' => true,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'DISPLAY' => '',
                        'STEP' => 99,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_100',
                ),

                'validated_at' => array(
                        'SHOW-ADMIN' => true,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'DISPLAY' => '',
                        'STEP' => 99,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_100',
                ),




                'version'                  => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'INT',
                        'FGROUP' => 'tech_fields'
                ),

                'update_groups_mfk'             => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'ANSWER' => 'ugroup',
                        'ANSMODULE' => 'ums',
                        'TYPE' => 'MFK',
                        'FGROUP' => 'tech_fields'
                ),

                'delete_groups_mfk'             => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'ANSWER' => 'ugroup',
                        'ANSMODULE' => 'ums',
                        'TYPE' => 'MFK',
                        'FGROUP' => 'tech_fields'
                ),

                'display_groups_mfk'            => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'ANSWER' => 'ugroup',
                        'ANSMODULE' => 'ums',
                        'TYPE' => 'MFK',
                        'FGROUP' => 'tech_fields'
                ),

                'sci_id'                        => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'INT', /*stepnum-not-the-object*/
                        'FGROUP' => 'tech_fields'
                ),

                'tech_notes'                         => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'TYPE' => 'TEXT',
                        'CATEGORY' => 'FORMULA',
                        'SHOW-ADMIN' => true,
                        'QEDIT' => false,
                        'TOKEN_SEP' => '§',
                        'READONLY' => true,
                        'NO-ERROR-CHECK' => true,
                        'FGROUP' => 'tech_fields'
                ),


        );
}
