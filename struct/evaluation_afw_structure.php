<?php
class AdmEvaluationAfwStructure
{

        public static function initInstance(&$obj)
        {
                if ($obj instanceof Evaluation) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                        $obj->DISPLAY_FIELD = "evaluation_name_ar";
                        // $obj->ORDER_BY_FIELDS = "xxxx, yyyy";
                        // $obj->UNIQUE_KEY = array('evaluation_name_ar','evaluation_name_en');
                        $obj->public_display = true;
                        // $obj->IS_LOOKUP = true;

                        $obj->editByStep = true;
                        $obj->editNbSteps = 1;
                        // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
                        $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'Evaluation',"submit"=>true);
                }
        }


        public static $DB_STRUCTURE = array(
                'id' => array(
                        'SHOW' => false,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'TYPE' => 'PK',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),

                'eval_type_id' => array(
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
                        'ANSWER' => 'eval_type',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'OneToMany',
                        'MANDATORY' => true,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),

                'evaluation_name_ar' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '100',
                        'MAXLENGTH' => '100',
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),



                'evaluation_name_en' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '100',
                        'MAXLENGTH' => '100',
                        'UTF8' => false,
                        'TYPE' => 'TEXT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),



                


                'maxexamresult' => array(
                        'IMPORTANT' => 'IN',
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'QEDIT' => true,
                        'EDIT' => true,
                        'TYPE' => 'INT',
                        'MANDATORY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),



                'examresulttype' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '100',
                        'MAXLENGTH' => '100',
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),



                'validity_days' => array(
                        'IMPORTANT' => 'IN',
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => true,
                        'EDIT' => true,
                        'TYPE' => 'INT',
                        'MANDATORY' => false,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),



                'validity_months' => array(
                        'IMPORTANT' => 'IN',
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => true,
                        'EDIT' => true,
                        'TYPE' => 'INT',
                        'MANDATORY' => false,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),



                'validity_years' => array(
                        'IMPORTANT' => 'IN',
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => true,
                        'EDIT' => true,
                        'TYPE' => 'INT',
                        'MANDATORY' => false,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),



                'examspecialtycode' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
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
                        'CSS' => 'width_pct_25',
                ),



                'examspecialtyname' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '100',
                        'MAXLENGTH' => '100',
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),



                'instructions' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 'AREA',
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
                        'TYPE' => 'FK',
                        'ANSWER' => 'scenario_item',
                        'ANSMODULE' => 'ums',
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
