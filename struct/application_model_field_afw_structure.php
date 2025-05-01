<?php
class AdmApplicationModelFieldAfwStructure
{

        public static function initInstance(&$obj)
        {
                if ($obj instanceof ApplicationModelField) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
                        // $obj->DISPLAY_FIELD = "application_model_field_name_ar";
                        $obj->ORDER_BY_FIELDS = "api_endpoint_id, step_num, screen_model_id";
                        $obj->UNIQUE_KEY = array('application_model_id', 'application_field_id');
                        // tempo for demo
                        $obj->public_display = true;
                        // $obj->IS_LOOKUP = true;

                        // $obj->editByStep = true;
                        // $obj->editNbSteps = 1; 
                        $obj->after_save_edit = array("class" => 'ApplicationModel', "attribute" => 'application_model_id', "currmod" => 'adm', "currstep" => 7);
                } else {
                        ApplicationModelFieldArTranslator::initData();
                        ApplicationModelFieldEnTranslator::initData();
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

                'application_model_id' => array(
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
                        'ANSWER' => 'application_model',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'OneToMany',
                        'MANDATORY' => true,
                        'READONLY' => true,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),


                'acondition_id' => array(
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
                        'ANSWER' => 'acondition',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'OneToMany',
                        'MANDATORY' => true,
                        'READONLY' => true,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),


                'application_field_id' => array(
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
                        'ANSWER' => 'application_field',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'NO-COTE' => true,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'OneToMany',
                        'MANDATORY' => true,
                        'READONLY' => true,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),


                'screen_model_id' => array(
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
                        'ANSWER' => 'screen_model',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne',
                        'READONLY' => true,
                        'MANDATORY' => true,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),

                'step_num' => array(
                        'IMPORTANT' => 'IN',
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'QEDIT' => true,
                        'READONLY' => true,
                        'EDIT' => true,
                        'CAN_ZERO' => true,
                        'TYPE' => 'INT',
                        'MANDATORY' => false,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_25',
                ),

                'api_endpoint_id' => array(
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
                        'ANSWER' => 'api_endpoint',
                        'ANSMODULE' => 'adm',
                        'SIZE' => 40,
                        'DEFAUT' => 0,
                        'WHERE' => "application_field_mfk like '%,§application_field_id§,%'",
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'RELATION' => 'ManyToOne',
                        'MANDATORY' => true,
                        'READONLY' => false,
                        'AUTOCOMPLETE' => false,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'CSS' => 'width_pct_50',
                ),


                'api_endpoint2_id' => array(
                        'STEP' => 1,
                        'SHORTNAME' => 'endpoint2',
                        'WHERE' => "application_field_mfk like  %,§application_field_id§,% ",
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'AUDIT' => false,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 40,
                        'MAXLENGTH' => 32,
                        'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                        'MANDATORY' => false,
                        'UTF8' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'api_endpoint',
                        'DISPLAY' => true,
                        'ANSMODULE' => 'adm',
                        'RELATION' => 'ManyToOne',
                        'READONLY' => false,
                        'CSS' => 'width_pct_50',
                ),



                'duration_expiry' => array(
                        'IMPORTANT' => 'IN',
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE-AR' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => '50',
                        'MAXLENGTH' => '50',
                        'UTF8' => true,
                        'TYPE' => 'INT',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'MANDATORY' => false,
                        'UNIT' => 'يوم',
                        'DEFAUT' => 15,
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
