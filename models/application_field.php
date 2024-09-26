<?php
// 9/9/24 rafik
/*
DROP TABLE IF EXISTS c0adm.application_field;

CREATE TABLE IF NOT EXISTS c0adm.`application_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   field_name varchar(48)  DEFAULT NULL , 
   shortname varchar(32)  DEFAULT NULL , 
   application_table_id smallint DEFAULT NULL , 
   application_field_type_id smallint DEFAULT NULL , 
   field_title_ar varchar(64)  DEFAULT NULL , 
   field_title_en varchar(64)  DEFAULT NULL , 
   reel char(1) DEFAULT NULL , 
   additional char(1) DEFAULT NULL , 
   unit varchar(32)  DEFAULT NULL , 
   unit_en varchar(32)  DEFAULT NULL , 
   field_order smallint DEFAULT NULL , 
   field_num smallint DEFAULT NULL , 
   field_size smallint DEFAULT NULL , 
   help_text text  DEFAULT NULL , 
   help_text_en text  DEFAULT NULL , 
   question_text text  DEFAULT NULL , 
   question_text_en text  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_application_field on c0adm.application_field(application_table_id, field_name);

delete from c0adm.`application_field`;

insert into c0adm.`application_field` (id, created_by, created_at, active, version, field_name, shortname, application_table_id, application_field_type_id, field_title_ar, field_title_en, reel, additional, unit, unit_en, field_order, field_num, field_size)
select id, id_aut, now(), avail, version, field_name, shortname, 1, afield_type_id, titre, titre_en, reel, additional, unit, unit_en, field_order, field_num, field_size
from c0pag.afield
where id in (110734, 110735);

insert into c0adm.`application_field` (id, created_by, created_at, active, version, field_name, shortname, application_table_id, application_field_type_id, field_title_ar, field_title_en, reel, additional, unit, unit_en, field_order, field_num, field_size)
select id, id_aut, now(), avail, version, field_name, shortname, 1, afield_type_id, titre, titre_en, reel, additional, unit, unit_en, field_order, field_num, field_size
-- select count(*)
from c0pag.afield
where atable_id = 13890
  and avail = 'Y'
  and reel = 'Y'
  and afield_type_id in (1,2,3,13,14,5,6,7,9,8,12,15,16)
  and id not in (110297,110298,110308,110306,110332,110356,110358,110361,110373,110375);

insert into c0adm.`application_field` (id, created_by, created_at, active, version, field_name, shortname, application_table_id, application_field_type_id, field_title_ar, field_title_en, reel, additional, unit, unit_en, field_order, field_num, field_size)
select id, id_aut, now(), avail, version, field_name, shortname, 3, afield_type_id, titre, titre_en, reel, additional, unit, unit_en, field_order, field_num, field_size
-- select count(*)
from c0pag.afield
where atable_id = 13917
  and avail = 'Y'
  and reel = 'Y'
  and readonly = 'N'
  and afield_type_id in (1,2,3,13,14,5,6,7,9,8,12,15,16);

  

*/


global $enum_tables, $lookup_tables, $count_here;






class ApplicationField extends AdmObject {

        public static $AFIELD_TYPE_AMNT = 3; 

        // BIGINT - قيمة عددية كبيرة  
        public static $AFIELD_TYPE_BIGINT = 14; 

        // DATE - تاريخ  
        public static $AFIELD_TYPE_DATE = 2; 

        // ENUM - إختيار من قائمة قصيرة  
        public static $AFIELD_TYPE_ENUM = 12; 

        // FLOAT - قيمة عددية كسرية  
        public static $AFIELD_TYPE_FLOAT = 16; 

        // GDAT - تاريخ نصراني  
        public static $AFIELD_TYPE_GDAT = 9; 

        // ITEMS - قائمة تفاصيل  
        public static $AFIELD_TYPE_ITEMS = 17; 

        // LIST - اختيار من قائمة  
        public static $AFIELD_TYPE_LIST = 5; 

        // MENUM - إختيار متعدد من قائمة قصيرة  
        public static $AFIELD_TYPE_MENUM = 15; 

        // MLST - اختيار متعدد من قائمة  
        public static $AFIELD_TYPE_MLST = 6; 

        // MTXT - نص طويل  
        public static $AFIELD_TYPE_MTXT = 11; 

        // NMBR - قيمة عددية متوسطة  
        public static $AFIELD_TYPE_NMBR = 1; 

        // PCTG - نسبة مائوية  
        public static $AFIELD_TYPE_PCTG = 7; 

        // SMALLINT - قيمة عددية صغيرة  
        public static $AFIELD_TYPE_SMALLINT = 13; 

        // TEXT - نص قصير  
        public static $AFIELD_TYPE_TEXT = 10; 

        // TIME - وقت  
        public static $AFIELD_TYPE_TIME = 4; 

        // YN - نعم/لا  
        public static $AFIELD_TYPE_YN = 8; 

        // MANYTOONE - حقل يفلتر به-ManyToOne  
        public static $ENTITY_RELATION_TYPE_MANYTOONE = 2; 
 
        // ONETOMANY - أنا تفاصيل لها-OneToMany  
        public static $ENTITY_RELATION_TYPE_ONETOMANY = 1; 
 
        // ONETOONEBIDIRECTIONAL - جزء مني ولا يعمل إلا بي-OneToOneBidirectional  
        public static $ENTITY_RELATION_TYPE_ONETOONEBIDIRECTIONAL = 4; 
 
        // ONETOONEUNIDIRECTIONAL - جزء مني ويعمل مستقلا-OneToOneUnidirectional  
        public static $ENTITY_RELATION_TYPE_ONETOONEUNIDIRECTIONAL = 5; 
 
        // UNKN - غير معروفة-unkn  
        public static $ENTITY_RELATION_TYPE_UNKN = 3; 
        
        
        public static $enum_tables;
        
        public static $lookup_tables;

	public static $DATABASE		= ""; 
        public static $MODULE		    = "adm"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null; 
        
        
        public function __construct(){
		parent::__construct("application_field","id","adm");
                AdmApplicationFieldAfwStructure::initInstance($this);
	}
        
        public static function loadById($id)
        {
           $obj = new ApplicationField();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($field_name, $application_table_id,$create_obj_if_not_found=false)
        {


           $obj = new ApplicationField();
           $obj->select("field_name",$field_name);
           $obj->select("application_table_id",$application_table_id);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("field_name",$field_name);
                $obj->set("application_table_id",$application_table_id);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               if($this->getVal("field_title_$lang")) return $this->getVal("field_title_$lang");
               return $this->getVal("field_name");
        }
        
        /*
        protected function dynamicHelpCondition($attribute)
        {
             if($attribute=="titre_short") return ($this->getVal("titre_short") != $this->getVal("titre"));
             
             return true; 
        }*/
        
        public function select_visibilite_horizontale($dropdown = false)
        {
                $server_db_prefix = AfwSession::config("db_prefix","c0");
                $objme = AfwSession::getUserConnected();
                $me = ($objme) ? $objme->id : 0;
                $this->select_visibilite_horizontale_default();
                if(!$objme->isSuperAdmin())
                {        
                   $this->where("(${server_db_prefix}adm.fnGetModuleId(id) in (select mu.id_module from ${server_db_prefix}ums.module_auser mu where mu.id_auser = '$me' and mu.avail='Y'))");
                } 
        }
        
        
        public function hasOption($option)
        {
            return $this->findInMfk("foption_mfk",$option,false);
        }
        
        public function lookupListWithoutLookupTable()
        {
            return $this->hasOption(114);
        }
        
        public function needAnswerTable()
        {
             if(in_array($this->getVal("application_field_type_id"),array(12,15))) 
             {
                 return (!$this->lookupListWithoutLookupTable());
             }   

             return (in_array($this->getVal("application_field_type_id"),array(5,6,17)));
        }
        
        public function myAnswerTableName()
        {
              if($this->needAnswerTable())
              {
                   $anstab = $this->get("answer_table_id");
                   return $anstab->valAtable_name();
              }
              else
              {
                   return "";
              }
        }
        
        
        
         public function attributeIsApplicable($attribute)
         {
                $my_tab = $this->het("application_table_id");
                
                if($attribute=="answer_table_id")
                {
                        return $this->needAnswerTable();
                }
                
                if($attribute=="answer_module_id")
                {
                        return $this->needAnswerTable();
                }
                
                if($attribute=="field_where")
                {
                        return $this->needAnswerTable();
                }
                
                
                
                
                if($attribute=="entity_relation_type_id")
                {
                        return (($this->getVal("application_field_type_id")==5) and ($this->is("reel"))); 
                }
                
                if($attribute=="application_field_category_id")
                {
                        return (!$this->is("reel")); 
                }

                if(($attribute=="sql") or ($attribute=="sql_gen") 
                        or ($attribute=="mode_qsearch")
                        or ($attribute=="mandatory")
                        or ($attribute=="distinct_for_list")
                        )
                {
                        return ($this->is("reel")); 
                }
                        


                if($attribute=="foption_mfk")
                {
                        return true; 
                }
                
                if($attribute=="entity_relation_type_id_help")
                {
                        return ($this->getVal("application_field_type_id")==5); 
                }
                
                if($attribute=="utf8")
                {
                        return (in_array($this->getVal("application_field_type_id"),array(10,11)));
                }
                
                if(($attribute=="field_size") or ($attribute=="field_width"))
                {
                        return ($this->is("reel") and in_array($this->getVal("application_field_type_id"),array(10, 11)));
                }
                
                if($attribute=="field_min_size")
                {
                        return ($this->is("reel") and $this->is("mandatory") and in_array($this->getVal("application_field_type_id"),array(10, 11)));
                }
                
                if($attribute=="char_group_men")
                {
                        return ($this->is("reel") and in_array($this->getVal("application_field_type_id"),array(10, 11)));
                }
                
                if($attribute=="scenario_item_id")
                {
                        if($my_tab)
                        {
                                $roles_on_screen_tabs = $my_tab::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS;
                                if($my_tab->hasOption($roles_on_screen_tabs))
                                {
                                        //if($my_tab->getVal("application_table_name")=="travel_template_bus") die("my_tab->hasOption($roles_on_screen_tabs) = true");
                                        return true;
                                } 
                                /*
                                $scis = $my_tab->get("scis");
                                $scis_count = count($scis);
                                if($scis_count>0)
                                {
                                //if($my_tab->getVal("application_table_name")=="travel_template_bus") die("scis = ".var_export($scis,true));
                                return true;
                                }*/
                                else return false;
                                
                                /* old code before changes 004
                                if($my_tab->hasOption($my_tab::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS)) return true;
                                $scis = $my_tab->get("scis");
                                $scis_count = count($scis);
                                if($scis_count>0)  return true;*/                           
                        }
                }

                return true;
        }
        
        
        public function getNextFieldOrder() 
        {
               
               $this->select("application_table_id", $this->getVal("application_table_id"));
               $this->select("reel", 'Y');
               $this->select("avail", 'Y');  
               return $this->func("IF(ISNULL(max(field_order)), 0, max(field_order))+10");
        
        }
        
        public function isFK() 
        {
             return ($this->getVal("application_field_type_id")==5);
        }
        
        public function isMFK() 
        {
             return ($this->getVal("application_field_type_id")==6);
        }
        
        public function getTypeInput() 
        {
                switch ($this->getVal("application_field_type_id")) 
        	{
                        // 5	اختيار من قائمة	list
                        // 6	اختيار متعدد من قائمة	mlst
                        // 8	نعم/لا	yn
        		case 5        :
                        case 6        : 
        		case 8     : 
                                        return "select";

                        // 1	قيمة عددية متوسطة	nmbr
                        // 2	تاريخ	date
                        // 3	مبلغ من المال	amnt
                        // 4	وقت	time
                        // 7	نسبة مائوية	pctg        
                        // 9	تاريخ ميلادي	gdat
                        // 10	نص قصير	text
                        // 11	نص طويل
                        // 13	قيمة عددية صغيرة
                        // 14	قيمة عددية كبيرة
        
        		case 1   :
        		case 2   :  
        		case 3   :
        		case 4   :  
        		case 7   :  
        		case 9   :      
        		case 10  :
        		case 11  :
        		case 13  :
        		case 14  :
                                return "text";

                        // 12	إختيار من قائمة قصيرة
                        // 15	إختيار متعدد من قائمة قصيرة	menum
        		default       : 
                                return "???";
        	}
        }
        
        
        public function getPreviousApplicationField()
        {
            $my_tab = $this->get("application_table_id");
            // if($my_tab)
               return $my_tab->getAFieldBefore($this,true);
            // else
                  
        }
        
        public function getNextApplicationField()
        {
            $my_tab = $this->get("application_table_id");
            // if($my_tab)
               return $my_tab->getAFieldAfter($this,true);
            // else
                  
        }
        
        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")
        {
             global $lang;
             $objme = AfwSession::getUserConnected();
             $me = ($objme) ? $objme->id : 0;
           
             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);                
	     if($this->getVal("application_table_id")<=0) return $otherLinksArray;    
	     $tbl =& $this->getTable();
             $tbl_id = $tbl->getId();
             $fld_id = $this->getId();
             
             $pf = $this->getPreviousApplicationField();
             $nf = $this->getNextApplicationField();
             $displ = $this->getDisplay($lang);

             
             if($nf) $next_field_id = $nf->getId();
             else $next_field_id = 0;
             if($pf) $previous_field_id = $pf->getId();
             else $previous_field_id = 0;
             
             if(($mode=="edit") and ($next_field_id))
             {
                     $link = array();
                     $link["URL"] = "main.php?Main_Adme=afw_mode_display.php&cl=ApplicationField&currmod=adm&id=$next_field_id";
                     $link["TITLE"] = "الحقل الموالي : ".$nf->getDisplay($lang);
                     $link["COLOR"] = "yellow"; 
                     $link["UGROUPS"] = array();
                     // $link["STEP"] = 8;
                     $otherLinksArray[] = $link;
             }
             
             if(($mode=="edit") and ($previous_field_id))
             {
                     $link = array();
                     $link["URL"] = "main.php?Main_Adme=afw_mode_display.php&cl=ApplicationField&currmod=adm&id=$previous_field_id";
                     $link["TITLE"] = "الحقل السابق : ".$pf->getDisplay($lang);
                     $link["COLOR"] = "yellow"; 
                     $link["UGROUPS"] = array();
                     // $link["STEP"] = 8;
                     $otherLinksArray[] = $link;
             }
             
             
             return $otherLinksArray;          
        }
        
        
        


        protected function getSpecificDataErrors($lang="ar",$show_val=true,$step="all",$erroned_attribute=null,$stop_on_first_error=false, $start_step=null, $end_step=null)
        {
              $sp_errors = array();
              
              if(!$this->getVal("application_field_type_id"))
              {
                    $sp_errors["application_field_type_id"] = "نوع الحقل مفقود";
              }
              
              if(!$this->getVal("field_name"))
              {
                    $sp_errors["field_name"] = "رمز الحقل مفقود";
              }
              /*
              if(!$this->getVal("titre_short"))
              {
                    $sp_errors["titre_short"] = "مسمى الحقل المختصر مفقود";
              }*/
              
              return $sp_errors;
              
        }
        
        public function myCategory()
        {
             if(!$this->_isReel()) return 1;
             return 0;
        }
        
        public static function char_template_to_mfk($char_template) 
        {
             $char_template = self::char_groups_template($char_template);
             $char_template_arr = explode(",",$char_template);
             $mfk_arr = array();
             foreach($char_template_arr as $char_template_item)
             {
                  $mfk_arr[] = self::char_group_code_to_id($char_template_item); 
             }
             
             if(count($mfk_arr)>0)
             {
                 return ",".implode(",",$mfk_arr).",";
             }
             else return "";
        }
        
        public static function mfk_to_char_template($mfk) 
        {
              $mfk_arr = explode(",",trim($mfk,","));
              $temp_arr = array();
              
              foreach($mfk_arr as $mfk_item)
              {
                  $temp_arr[] = self::char_group_id_to_code($mfk_item); 
              }
              
             if(count($temp_arr)>0)
             {
                 return implode(",",$temp_arr);
             }
             else return "";
        }
        
        
        public static function char_groups_template($char_template) 
        { 
           if($char_template=="LOOKUP_CODE") $char_template = "ALPHABETIC,UNDERSCORE";
           if($char_template=="TEXT_AR") $char_template = "ARABIC-CHARS,SPACE";
           if($char_template=="TEXT_EN") $char_template = "ALPHABETIC,SPACE";
            
           return  $char_template;
        }
        
        public static function char_group_id_to_code($id) { 
            $code = ""; 
            if($id==1) $code = "ALPHABETIC"; 
            if($id==2) $code = "ARABIC-CHARS"; 
            if($id==3) $code = "NUMERIC"; 
            if($id==4) $code = "MATH-SYMBOLS"; 
            if($id==5) $code = "BRACKETS"; 
            if($id==6) $code = "COMMAS"; 
            if($id==7) $code = "SPACE"; 
            if($id==8) $code = "MARKS"; 
            if($id==9) $code = "UNDERSCORE"; 
            if($id==10) $code = "OTHER-SYMBOLS";
            if($id==11) $code = "ALL"; 
           return  $code;
        }
        
        public static function char_group_code_to_id($code) { 
            $id = ""; 
            if($code == "ALPHABETIC")    $id=1;    
            if($code == "ARABIC-CHARS")  $id=2;  
            if($code == "NUMERIC")       $id=3;       
            if($code == "MATH-SYMBOLS")  $id=4;  
            if($code == "BRACKETS")      $id=5;      
            if($code == "COMMAS")        $id=6;        
            if($code == "SPACE")         $id=7;         
            if($code == "MARKS")         $id=8;         
            if($code == "UNDERSCORE")    $id=9;   
            if($code == "OTHER-SYMBOLS") $id=10;
            if($code == "ALL")           $id=11;  
           return  $id;
        }
        
        public function list_of_char_group_men() { 
            $list_of_items = array(); 
            $list_of_items[1] = "   a..z alphabetic";  //     code : ALPHABETIC 
            $list_of_items[2] = "أ..ي حروف عربية";  //     code : ARABIC-CHARS 
            $list_of_items[5] = "[]{}()     أقواس متنوعة";  //     code : BRACKETS 
            $list_of_items[6] = ":;,،  فواصل";  //     code : COMMAS 
            $list_of_items[8] = "\" '   علامات الاقتباس";  //     code : MARKS 
            $list_of_items[4] = "  +-*/  رموز حساب";  //     code : MATH-SYMBOLS 
            $list_of_items[3] = "0..9 الأرقام";  //     code : NUMERIC 
            $list_of_items[10] = "  كل الرموز الأخرى     $%#@...الخ";  //     code : OTHER-SYMBOLS 
            $list_of_items[7] = "فضاء";  //     code : SPACE 
            $list_of_items[9] = "مطة  اندرسكور  _";  //     code : UNDERSCORE\
            $list_of_items[11] = "الجميع";  //     code : OTHER-SYMBOLS 
           return  $list_of_items;
        }
        
        
        
        public function getDefaultStep()
        {
            if($this->isOk()) return 7;

            return 0;
        }
        
        public function getFieldGroupInfos($fgroup)
        {
           return array("name"=>$fgroup, "css"=>"pct_100 min_height_auto");
        }

        public function stepsAreOrdered()
        {
                return false;
        }


        // application_field 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 463;
                if ($currstep == 2) return 464;
                if ($currstep == 3) return 465;
                if ($currstep == 4) return 466;
                if ($currstep == 5) return 467;
                if ($currstep == 6) return 468;
                if ($currstep == 7) return 469;
                if ($currstep == 8) return 470;

                return 0;
        }

        
}
?>