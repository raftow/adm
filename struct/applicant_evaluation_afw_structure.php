<?php
// created by medali

class AdmApplicantEvaluationAfwStructure
{

        public static function initInstance(&$obj)
        {
                if ($obj instanceof ApplicantEvaluation) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                        // $obj->DISPLAY_FIELD = "applicant_evaluation_name_ar";
                        // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                        $obj->UNIQUE_KEY = array('evaluation_id', 'applicant_id', 'eval_date');
                        // tempo for amjad demo @todo
                        $obj->public_display = true;
                        // $obj->IS_LOOKUP = true;

                        $obj->editByStep = false;
                        //$obj->editNbSteps = 1; 
                        $obj->after_save_edit_cases = array(
                                'case-1' => array("class" => 'Applicant', "attribute" => 'applicant_id', "currmod" => 'adm', "currstep" => 3),
                                'case-2' => array("class" => 'NominatingCandidates', "formulaAttribute" => 'nominating_candidates_id', "currmod" => 'adm', "currstep" => 4),
                        );
                } else {
                        ApplicantEvaluationArTranslator::initData();
                        ApplicantEvaluationEnTranslator::initData();
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

                'evaluation_id' => array(
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
                        'ANSWER' => 'evaluation',
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
                        'CSS' => 'width_pct_50',
                ),


                'applicant_id' => array(
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
                        'ANSWER' => 'applicant',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne-OneToMany',
                        'MANDATORY' => true,
                        'READONLY' => true,
                        'AUTOCOMPLETE' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),

                /**** FORMULA */
                'nominating_candidates_id' => array(
                        'CATEGORY' => 'FORMULA',
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
                        'ANSWER' => 'nominating_candidates',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 99,
                        'RELATION' => 'OneToMany',
                        'MANDATORY' => true,
                        'READONLY' => true,
                        'AUTOCOMPLETE' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),
                /**** FORMULA */

                'eval_result' => array(
                        'IMPORTANT' => 'IN',
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
                        'CSS' => 'width_pct_50',
                ),

                'eval_level' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE-AR' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '10',
                        'MAXLENGTH' => '10',
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),

                'eval_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'TYPE' => 'GDAT',
                        'DISPLAY' => true,
                        'MANDATORY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',

                        'CSS' => 'width_pct_50',
                ],


                'eval_expired_date' => [
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SEARCH-ADMIN' => true,
                        'SHOW-ADMIN' => true,
                        'EDIT-ADMIN' => true,
                        'UTF8' => false,
                        'DISPLAY' => true,
                        'MANDATORY' => true,
                        'TYPE' => 'GDAT',
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',

                        'CSS' => 'width_pct_50',
                ],


                'nomination_letter_id' => array(
                        // 'SHORTNAME' => 'funding_status',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'nomination_letter',
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'OneToMany',
                        'READONLY' => true,
                        'MANDATORY' => true,
                        'DNA' => true,
                        'CSS' => 'width_pct_50',
                        'STEP' => 1,
                ),

                'workflow_file_id' => array(
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
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'workflow_file',
                        'ANSMODULE' => 'workflow',
                        'RELATION' => 'ManyToOne',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),

                'imported' => array(
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
                'need_evaluation_enum' => array(
                        'SHORTNAME' => 'evaluation',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => false,
                        'SIZE' => 32,
                        'MAXLENGTH' => 32,
                        'MIN-SIZE' => 1,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'UTF8' => false,
                        'TYPE' => 'ENUM',
                        'ANSWER' => '',
                        'READONLY' => false,
                        'DNA' => true,
                        'CSS' => 'width_pct_25',
                ),


        );
}
