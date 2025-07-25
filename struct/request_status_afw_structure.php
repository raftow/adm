<?php
class AdmRequestStatusAfwStructure
{
        public static $DB_STRUCTURE = array(


                'id' => array(
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'TYPE' => 'PK',
                        'SEARCH-BY-ONE' => '',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                ),

                'lookup_code' => array(
                        'TYPE' => 'TEXT',
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'SIZE' => 64,
                        'QEDIT' => true,
                        'SHORTNAME' => 'code',
                        'SEARCH-BY-ONE' => '',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                ),

                'request_status_name_ar' => array(
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'QSIZE' => 32,
                        'MIN-SIZE' => 5,
                        'CHAR_TEMPLATE' => 'ARABIC-CHARS,SPACE',
                        'MANDATORY' => true,
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'READONLY' => false,
                        'SEARCH-BY-ONE' => true,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'ERROR-CHECK' => true,
                ),

                'request_status_name_en' => array(
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'QSIZE' => 32,
                        'MIN-SIZE' => 5,
                        'CHAR_TEMPLATE' => 'ALPHABETIC,SPACE',
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'TEXT',
                        'READONLY' => false,
                        'SEARCH-BY-ONE' => true,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'ERROR-CHECK' => true,
                ),


                'customer_status_name_ar' => array(
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'QSIZE' => 32,
                        'MIN-SIZE' => 5,
                        'CHAR_TEMPLATE' => 'ARABIC-CHARS,SPACE',
                        'MANDATORY' => true,
                        'UTF8' => true,
                        'TYPE' => 'TEXT',
                        'READONLY' => false,
                        'SEARCH-BY-ONE' => true,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'ERROR-CHECK' => true,
                ),

                'customer_status_name_en' => array(
                        'SEARCH' => true,
                        'QSEARCH' => true,
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'QSIZE' => 32,
                        'MIN-SIZE' => 5,
                        'CHAR_TEMPLATE' => 'ALPHABETIC,SPACE',
                        'MANDATORY' => true,
                        'UTF8' => false,
                        'TYPE' => 'TEXT',
                        'READONLY' => false,
                        'SEARCH-BY-ONE' => true,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'ERROR-CHECK' => true,
                ),


                'response_type_mfk' => array(
                        'SHORTNAME' => 'response_types',
                        'SEARCH' => true,
                        'QSEARCH' => false,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'SIZE' => 32,
                        'MANDATORY' => false,
                        'UTF8' => false,
                        'DEFAUT' => ',1,',
                        'TYPE' => 'MFK',
                        'ANSWER' => 'response_type',
                        'ANSMODULE' => 'adm',
                        'READONLY' => false,
                        'SEARCH-BY-ONE' => false,
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'ERROR-CHECK' => true,
                ),

                'active' => array(
                        'SHOW-ADMIN' => true,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'QEDIT' => true,
                        'DEFAUT' => 'Y',
                        'TYPE' => 'YN',
                        'SEARCH-BY-ONE' => '',
                        'DISPLAY' => '',
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                ),

                'created_by'         => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'TECH_FIELDS-RETRIEVE' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'FGROUP' => 'tech_fields'
                ),

                'created_at'            => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'TECH_FIELDS-RETRIEVE' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'FGROUP' => 'tech_fields'
                ),

                'updated_by'           => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'TECH_FIELDS-RETRIEVE' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'FGROUP' => 'tech_fields'
                ),

                'updated_at'              => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'TECH_FIELDS-RETRIEVE' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'FGROUP' => 'tech_fields'
                ),

                'validated_by'       => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'FGROUP' => 'tech_fields'
                ),

                'validated_at'          => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'FGROUP' => 'tech_fields'
                ),

                /* 'active'                   => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => true, 
                                                                'QEDIT' => true, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),*/

                'version'                  => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'INT',
                        'FGROUP' => 'tech_fields'
                ),

                // 'draft'                         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => true, 
                //                                        'QEDIT' => true, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),

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
                        "SHOW-ADMIN" => true,
                        'TOKEN_SEP' => "§",
                        'READONLY' => true,
                        "NO-ERROR-CHECK" => true,
                        'FGROUP' => 'tech_fields'
                ),
        );
}
