<?php
class AdmScreenModelAfwStructure
{

    public static function initInstance(&$obj)
    {
        if ($obj instanceof ScreenModel) {
            $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 3;
            $obj->DISPLAY_FIELD = "screen_name_ar";
            $obj->ORDER_BY_FIELDS = "screen_name_ar";
            $obj->UNIQUE_KEY = array('screen_code');
            $obj->public_display = true;
            // $obj->IS_LOOKUP = true;

            // $obj->editByStep = true;
            // $obj->editNbSteps = 1; 
            // $obj->after_save_edit = array("class"=>'aconditionOriginType',"attribute"=>'acondition_origin_type_id', "currmod"=>'adm',"currstep"=>1);
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

        'screen_code' => array(
            'IMPORTANT' => 'IN',
            'SEARCH' => true,
            'QSEARCH' => true,
            'SHOW' => true,
            'RETRIEVE-AR' => true,
            'EDIT' => true,
            'QEDIT' => true,
            'SIZE' => '32',
            'MAXLENGTH' => '32',
            'UTF8' => true,
            'TYPE' => 'TEXT',
            'DISPLAY' => true,
            'STEP' => 1,
            'MANDATORY' => true,
            'DISPLAY-UGROUPS' => '',
            'EDIT-UGROUPS' => '',
            'CSS' => 'width_pct_25',
        ),



        'screen_title' => array(
            'IMPORTANT' => 'IN',
            'SEARCH' => true,
            'QSEARCH' => true,
            'SHOW' => true,
            'RETRIEVE-AR' => true,
            'EDIT' => true,
            'QEDIT' => true,
            'SIZE' => '32',
            'MAXLENGTH' => '32',
            'UTF8' => true,
            'TYPE' => 'TEXT',
            'DISPLAY' => true,
            'STEP' => 1,
            'MANDATORY' => true,
            'DISPLAY-UGROUPS' => '',
            'EDIT-UGROUPS' => '',
            'CSS' => 'width_pct_25',
        ),



        'screen_name_ar' => array(
            'IMPORTANT' => 'IN',
            'SEARCH' => true,
            'QSEARCH' => true,
            'SHOW' => true,
            'RETRIEVE-AR' => true,
            'EDIT' => true,
            'QEDIT' => true,
            'SIZE' => '64',
            'MAXLENGTH' => '64',
            'UTF8' => true,
            'TYPE' => 'TEXT',
            'DISPLAY' => true,
            'STEP' => 1,
            'MANDATORY' => true,
            'DISPLAY-UGROUPS' => '',
            'EDIT-UGROUPS' => '',
            'CSS' => 'width_pct_25',
        ),



        'screen_name_en' => array(
            'IMPORTANT' => 'IN',
            'SEARCH' => true,
            'QSEARCH' => true,
            'SHOW' => true,
            'RETRIEVE-EN' => true,
            'EDIT' => true,
            'QEDIT' => true,
            'SIZE' => '64',
            'MAXLENGTH' => '64',
            'UTF8' => false,
            'TYPE' => 'TEXT',
            'DISPLAY' => true,
            'STEP' => 1,
            'MANDATORY' => true,
            'DISPLAY-UGROUPS' => '',
            'EDIT-UGROUPS' => '',
            'CSS' => 'width_pct_25',
        ),



        'application_field_mfk' => array(
            'IMPORTANT' => 'IN',
            'SEARCH' => true,
            'QSEARCH' => true,
            'SHOW' => true,
            'RETRIEVE' => true,
            'EDIT' => true,
            'QEDIT' => true,
            'UTF8' => false,
            'MANDATORY' => true,
            'TYPE' => 'MFK',
            'ANSWER' => 'application_field',
            'ANSMODULE' => 'adm',
            'DISPLAY' => true,
            'STEP' => 1,
            'DISPLAY-UGROUPS' => '',
            'EDIT-UGROUPS' => '',
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

        'tech_notes'                     => array(
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
