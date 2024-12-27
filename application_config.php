<?php
$config_arr = array(
        'application_id' => 1282,

        'application_code' => 'adm',

        // roClassName => Booking,

        'x_module_means_company'=>false,


        'application_name' => ['ar' => 'ادارة أعمال القبول', 'en' => 'Admissions management',],
                                  
        'no_menu_for_login' => true,

        'enable_language_switch' => true,

        'student_title' => "المتقدم",

        /*
        'cust_type_list' => array(1 => "فرد من المجتمع",
                                  5 => "متعاون من خارج المؤسسة",
                                  3 => "متدرب", ),*/


        //  classes params
        /*TravelTemplate_showId =>true, */
        
        'default_controller_name' => "content",                                  

        

        'notify_customer' => array("new_request" => array("sms"=>true, "email" => false, "web" => false, "whatsup" => false),
        
                                ),

        'notify_manager' => array("new_request" => array("sms"=>true, "email" => false, "web" => true, "whatsup" => false),
        
                        ),

        'notify_employee' => array("new_request" => array("sms"=>true, "email" => false, "web" => true, "whatsup" => false),
        
                ),


        'general_company_id' => 1,

        'tasksClassName' => "Request",

        'consider_user_as_customer' =>true,

        'default_customer_type' =>2,

        'LOGO_APP_HEIGHT' => 66,
        'LOGO_APP_MARGIN_TOP' => 5,
        'TITLE_APP_HEIGHT' => 56,
        'TITLE_APP_MARGIN_TOP' => 15,
        'LOGO_COMP_HEIGHT' => 56,
        'LOGO_COMP_MARGIN_TOP' => 14,
        'TITLE_COMP_HEIGHT' => 56,
        'TITLE_COMP_MARGIN_TOP' => -10,
        
        
        

        'DISABLE_PROJECT_ITEMS_MENU' => true,

        'register_file' => "customer_register",

        
        // smtp email config can be found in external folder
        
        // APPLICATION SETTINGS
        'MODE_DEVELOPMENT' => true,

        'adm-AfileClass' => "WorkflowFile",

        'adm-file_types' => [7,20,6,28,18,27,29],


        // SIS settings
        'default_course_mfk' => ',1,',

        'date_system' => 'GREG',
        'school_year_name_template' => 'PY - CY',
        'school_year_start' => 'PY-09-01',
        'school_year_end' => 'CY-06-30',
        'school_year_date_current_year' => 'CY-02-01',

        );

//$sql_capture_and_backtrace = "or (session_date =";
