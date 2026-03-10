<?php
try {
        $file_dir_name = dirname(__FILE__);

        require_once("$file_dir_name/../config/global_config.php");
        // old include of afw.php
        // require_once("$file_dir_name/../lib/afw/modes/afw_ config.php");

        $cl = 'ApplicationDesire';
        $currmod = 'adm';
        $currdb = $server_db_prefix . 'adm';
        $limite = 0;
        $genere_xls = 0;

        $arr_sql_conds = array();
        $arr_sql_conds[] = "me.active='Y'";
        $objme = AfwSession::getUserConnected();
        $myEmplObj = $objme->getEmployee();
        $myEmplId = $objme->getEmployeeId();


        $sql_order_by = 'created_at desc';


        $actions_tpl_arr = array();
        $action = "retrieve-simple";
        // $actions_tpl_arr['edit'] = array('framework_action');

        $fixed_criterea_arr =  array(
                 0 => array('col' => 'admission_status', 'oper' => '=', 'val' => '18',),
               /*  1 => array('col' => 'datatable_off', 'oper' => '=', 'val' => true,),*/
        );

        $current_page = "sendDesireToSIS.php";

        $readOnlyColumns = [
                'admission_status',
        ];


        $requiredColumns = [
                'application_model_id',
                'application_plan_id',
               /* 'application_plan_branch_id',
                'applicant_id',
                'student_id',
                'student_created_ind',
                'sis_date',
                'admission_status',
                'admission_status_date',*/
        ];

        $formColumns = [
                'application_model_id',
                'application_plan_id',
                'application_plan_branch_id',
                'applicant_id',
                'student_id',
                'student_created_ind',
                'payment_created_ind',
                'admission_status',
                'student_id',
               // 'admission_status_date',
        ];

        $forced_retrieve_cols = [
                'application_model_id',
                'application_plan_id',
                'application_plan_branch_id',
                'admission_status',
                'applicant_id',
                'student_id',
                'student_created_ind',
                'sis_date',
                'payment_created_ind',
                'send_to_sis',
                'send_fees_to_sis',
               
        ];
       $hide_retrieve_cols = [
                'formula_value_1',
                'formula_value_2',
                'formula_value_3',
                'track_num',
                'step_num',
                'application_step_id',
                'comments',
                'sorting_value_1',
                'desire_status_enum',
                'application_model_id',
                'application_plan_id',
               /* 'orgunit_id',
                'employee_id',
                'request_date',
                'country_id',
                'workflow_source_id'*/
                
        ];

        //$specialStructure = ['admission_status'=>['WHERE'=>'id in (18,19,20)']];

        $qsearch_page_title = AfwLanguageHelper::tt('SendToSIS', $lang, $currmod);
        include "$file_dir_name/../lib/afw/modes/afw_mode_qsearch.php";
        $collapse_in = '';



        /*$out_scr .= "<div class='workflow-title hzm-info'>$wp_title</div>";

        if ($datatable_on) {
                if ($data_count > 0)
                        $out_scr .= $search_result_html;  // die("search_result_html=".$search_result_html); //
                else
                        $out_scr .= '<div class=\'workflow-information hzm-info\'>
        <i class="hzm-container-center hzm-vertical-align-middle hzm-icon-fm hzm-icon-inbox"></i>
        لا يوجد طلبات للمفاضلة
        </div>';
        }
        */
} catch (Exception $e) {
        $out_scr .= $e->getMessage() . "<br>\n" . $e->getFile() . ' Line ' . $e->getLine() . "<br>\n" . $e->getTraceAsString();
}
