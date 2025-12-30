<?php
class AdmApplicantScholarshipAfwStructure
{

        public static function initInstance(&$obj)
        {
                if ($obj instanceof ApplicantScholarship) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                        $obj->DISPLAY_FIELD = "applicant_scholarship_name_ar";
                        // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                        $obj->UNIQUE_KEY = array('applicant_id', 'scholarship_id');
                        // $obj->public_display = true;
                        // $obj->IS_LOOKUP = true;

                        $obj->editByStep = true;
                        $obj->editNbSteps = 1;
                        // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        $obj->after_save_edit = array("mode" => "qedit", "attribute" => 'scholarship_id', "currmod" => 'adm', "class" => 'Scholarship', "currstep" => 2, "submit" => true);
                } else {
                        ApplicantScholarshipArTranslator::initData();
                        ApplicantScholarshipEnTranslator::initData();
                }
        }


        public static $DB_STRUCTURE = array(
                'id' => array(
                        'SHOW' => false,
                        'RETRIEVE' => true,
                        'EDIT' => false,
                        'TYPE' => 'PK',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),

                'applicant_id' => array(
                        'STEP'=>1,
                       'SHORTNAME' => 'applicant',
			'SEARCH' => true,
			'QSEARCH' => true,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => false,
			'QEDIT' => false,
			'SIZE' => 40,
			'MAXLENGTH' => 32,
			'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
			'MANDATORY' => false,
			'UTF8' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'applicant',
			'ANSMODULE' => 'adm',
			'AUTOCOMPLETE' => true,
			'AUTOCOMPLETE-SEARCH' => true,
			'RELATION' => 'OneToOne',
			'READONLY' => false,
			'CSS' => 'width_pct_25',
                        //'WHERE' => 'id in (select distinct applicant_id from §DBPREFIX§adm.application ap inner join §DBPREFIX§adm.application_plan p where ap.application_plan_id=p.id and p.term_id=(select academic_term_id from §DBPREFIX§adm.scholarship where id=§scholarship_id§ ))'
                ),


                'scholarship_id' => array(
                        'IMPORTANT' => 'IN',
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
                        'ANSWER' => 'scholarship',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne-OneToMany',
                        'MANDATORY' => true,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),


                'applicant_scholarship_status_id' => array(
                        'IMPORTANT' => 'IN',
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => true,
                        'EDIT' => true,

                        'TYPE' => 'FK',
                        'ANSWER' => 'applicant_scholarship_status',
                        'ANSMODULE' => 'adm',
                        'MANDATORY' => false,
                        'STEP' => 1,
                        'DISPLAY' => true,
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),



                'application_plan_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  
                        'EDIT' => true,  'QEDIT' => true, 'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
                        'TYPE' => 'FK',  'ANSWER' => 'application_plan',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' => 0,    
                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'ManyToOne-OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                        'CSS' => 'width_pct_25',
                        'WHERE' => 'id in (select id from §DBPREFIX§adm.application_plan p where  p.term_id=(select academic_term_id from §DBPREFIX§adm.scholarship where id=§scholarship_id§ ))'
                                         ),

                'application_simulation_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false, 
                        'QSEARCH' => false, 'SHOW' => false,  'RETRIEVE' => false,  
                        'EDIT' => false,  'QEDIT' => false, 'SHOW-ADMIN' => false,  'EDIT-ADMIN' => false,  'UTF8' => false,  
                        'TYPE' => 'FK',  'ANSWER' => 'application_simulation',  'ANSMODULE' => 'adm',  'SIZE' => 40,  'DEFAUT' =>2,    
                        'DISPLAY' => true,  'STEP' => 1,  'RELATION' => 'OneToMany', 'MANDATORY' => false, 'READONLY'=>false, 'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
                        'CSS' => 'width_pct_25', ),



                'academic_term_id' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => false,
                        'QSEARCH' => false,
                        'SHOW' => false,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'SHOW-ADMIN' => false,
                        'EDIT-ADMIN' => false,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'academic_term',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => false,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne-OneToMany',
                        'MANDATORY' => false,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),


                'academic_year_id' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => false,
                        'QSEARCH' => false,
                        'SHOW' => false,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'SHOW-ADMIN' => false,
                        'EDIT-ADMIN' => false,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'academic_year',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => false,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne-OneToMany',
                        'MANDATORY' => false,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),


                'academic_program_id' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => false,
                        'QSEARCH' => false,
                        'SHOW' => false,
                        'RETRIEVE' => false,
                        'EDIT' => false,
                        'QEDIT' => false,
                        'SHOW-ADMIN' => false,
                        'EDIT-ADMIN' => false,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'academic_program',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => false,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne-OneToMany',
                        'MANDATORY' => false,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),


                'remarks' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE-AR' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '250',
                        'MAXLENGTH' => '250',
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_100',
                ),




                'active' => array(
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'DEFAUT' => 'Y',
                        'TYPE' => 'YN',
                        'FORMAT' => 'icon',
                        'STEP' => 99,
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
