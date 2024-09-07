<?php


$records = "term_mode
term_mode_enum
1	نصفي	Semester
2	ثلثي	XXXXX
3	ربعي	Trimester";

        $record_template = "
        \$arr_list_of_[TABLE_NAME][\"en\"][[LKP_ID]] = \"[LKP_NAME_EN]\";
        \$arr_list_of_[TABLE_NAME][\"ar\"][[LKP_ID]] = \"[LKP_NAME_AR]\";
        \$arr_list_of_[TABLE_NAME][\"code\"][[LKP_ID]] = \"[LKP_CODE]\";
";

        $all_template = "public static function code_of_[FIELD_NAME](\$lkp_id=null)
        {
            global \$lang;
            if(\$lkp_id) return self::[TABLE_NAME]()['code'][\$lkp_id];
            else return self::[TABLE_NAME]()['code'];
        }
        
        
        public static function list_of_[FIELD_NAME]()
        {
            global \$lang;
            return self::[TABLE_NAME]()[\$lang];
        }
        
        public static function [TABLE_NAME]()
        {
                \$arr_list_of_[TABLE_NAME] = array();
                
                [RECORDS]
                
                
                
                return \$arr_list_of_[TABLE_NAME];
        }";

        $direct_dir_name = $file_dir_name = dirname(__FILE__);
        include("$file_dir_name/adm_start.php");
        $objme = AfwSession::getUserConnected();
        //if(!$objme) $studentMe = AfwSession::getStudentConnected();
        $studentMe = null;
        if(!$lang) $lang = "ar";
        
        
        $trad = "";
        
        $records_arr = explode("\n", $records);
        
        $TABLE_NAME = strtolower(trim($records_arr[0]));
        unset($records_arr[0]);
        
        $field_name = strtolower(trim($records_arr[1]));
        unset($records_arr[1]);

        $CLASS_NAME = AfwStringHelper::tableToClass($TABLE_NAME); 

        $records_php = "";

        foreach($records_arr as $record_line)
        {        
            list($lkp_id, $lkp_ar, $lkp_en, $lkp_code) = explode("\t", $record_line);


            $php_c = $record_template;


            $php_c = str_replace("[FIELD_NAME]",$field_name, $php_c);                        
            $php_c = str_replace("[TABLE_NAME]",$TABLE_NAME, $php_c);                        
            $php_c = str_replace("[LKP_ID]",$lkp_id, $php_c);
            $php_c = str_replace("[LKP_NAME_EN]",trim($lkp_en), $php_c);
            $php_c = str_replace("[LKP_NAME_AR]",trim($lkp_ar), $php_c);
            $php_c = str_replace("[LKP_CODE]",trim($lkp_code), $php_c);


            $records_php .= $php_c;
        }


        $all_php = $all_template;

        $all_php = str_replace("[FIELD_NAME]",$field_name, $all_php);                        
        $all_php = str_replace("[TABLE_NAME]",$TABLE_NAME, $all_php);
        $all_php = str_replace("[RECORDS]",$records_php, $all_php);
?>

        <textarea><?php echo $all_php ?> </textarea>
        
