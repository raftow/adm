<?php 
// medali 15/09/2024
/*
DROP TABLE IF EXISTS c0adm.program_track;

CREATE TABLE IF NOT EXISTS c0adm.`program_track` (
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
  
  `lookup_code` varchar(64) DEFAULT NULL,  
   track_code varchar(50)  DEFAULT NULL , 
   track_name_ar varchar(50)  DEFAULT NULL , 
   track_name_en varchar(50)  DEFAULT NULL , 
   sorting_instructions varchar(200)  DEFAULT NULL , 
   application_model_id int(11) DEFAULT NULL , 
   sorting_formula varchar(200)  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_program_track on c0adm.program_track(track_code,track_name_ar,track_name_en,sorting_instructions,application_model_id,sorting_formula);

INSERT INTO `program_track` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `track_code`, `track_name_ar`, `track_name_en`, `sorting_instructions`, `application_model_id`, `sorting_formula`) VALUES
(1, 1, '2024-09-15 14:53:24', 1, '2024-09-15 14:53:24', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'TECH', 'المسار التقني', 'Technical Track', '', NULL, NULL),
(2, 1, '2024-09-15 14:53:24', 1, '2024-09-15 14:53:24', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'NTECH', 'المسار الغير تقني', 'Non technical Track', NULL, NULL, NULL),
(3, 1, '2024-09-15 14:53:24', 1, '2024-09-15 14:53:24', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'SPEC', 'مسار التقنية الخاصة', 'Disabled track', NULL, NULL, NULL),
(4, 1, '2024-09-15 14:54:30', 1, '2024-09-15 14:54:30', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'INST', 'مسار دبلوم المعاهد', 'Institute Diploma Track', NULL, NULL, NULL),
(5, 1, '2024-09-15 14:54:30', 1, '2024-09-15 14:54:30', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'INST_PROG', 'مسار برامج المعاهد', 'Institute Program Track', NULL, NULL, NULL),
(6, 1, '2024-09-15 14:54:30', 1, '2024-09-15 14:54:30', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'ENG_PROG', 'مسار برنامج الإنجليزية المكثف', 'Intensive English Program Track', NULL, NULL, NULL);

*/
                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class ProgramTrack extends AFWObject{

        public static $MY_ATABLE_ID=13875; 
        // إحصائيات المسارات 
        public static $BF_STATS_PROGRAM_TRACK = 104693; 
        // إدارة المسارات 
        public static $BF_QEDIT_PROGRAM_TRACK = 104688; 
        // إنشاء مسار 
        public static $BF_EDIT_PROGRAM_TRACK = 104687; 
        // البحث في المسارات 
        public static $BF_SEARCH_PROGRAM_TRACK = 104691; 
        // المسارات 
        public static $BF_QSEARCH_PROGRAM_TRACK = 104692; 
        // عرض تفاصيل مسار 
        public static $BF_DISPLAY_PROGRAM_TRACK = 104690; 
        // مسح مسار 
        public static $BF_DELETE_PROGRAM_TRACK = 104689; 


 // lookup Value List codes 
  
        public static $DATABASE		= "c0adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "program_track";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("program_track","id","adm");
            AdmProgramTrackAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new ProgramTrack();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public static function loadAll()
        {
           $obj = new ProgramTrack();
           $obj->select("active",'Y');

           $objList = $obj->loadMany();
           
           return $objList;
        }

        
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           if(!$lookup_code) throw new AfwRuntimeException("loadByMainIndex : lookup_code is mandatory field");


           $obj = new ProgramTrack();
           $obj->select("lookup_code",$lookup_code);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("lookup_code",$lookup_code);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               if($this->getVal("track_name_$lang")) return $this->getVal("track_name_$lang");
               $data = array();
               $link = array();
               


               
               return implode(" - ",$data);
        }
        
        
        

        
        protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
        {
             global $lang;
             // $objme = AfwSession::getUserConnected();
             // $me = ($objme) ? $objme->id : 0;

             $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             
             
             // check errors on all steps (by default no for optimization)
             // rafik don't know why this : \//  = false;
             
             return $otherLinksArray;
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            $methodName = "mmmmmmmmmmmmmmmmmmmmmmm";
            //$pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("xxyy"));
            
            
            
            return $pbms;
        }
        
        public function fld_CREATION_USER_ID()
        {
                return "created_by";
        }

        public function fld_CREATION_DATE()
        {
                return "created_at";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return "updated_by";
        }

        public function fld_UPDATE_DATE()
        {
        	return "updated_at";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return "validated_by";
        }

        public function fld_VALIDATION_DATE()
        {
                return "validated_at";
        }
        
        public function fld_VERSION()
        {
        	return "version";
        }

        public function fld_ACTIVE()
        {
        	return  "active";
        }
        
        public function isTechField($attribute) {
            return (($attribute=="created_by") or ($attribute=="created_at") or ($attribute=="updated_by") or ($attribute=="updated_at") or ($attribute=="validated_by") or ($attribute=="validated_at") or ($attribute=="version"));  
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","c0");
            
            if(!$id)
            {
                $id = $this->getId();
                $simul = true;
            }
            else
            {
                $simul = false;
            }
            
            if($id)
            {   
               if($id_replace==0)
               {
                   // FK part of me - not deletable 

                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 
                       // adm.academic_program-Program_Track	program_track_id  ManyToOne
                        if(!$simul)
                        {
                            // require_once "../adm/academic_program.php";
                            AcademicProgram::updateWhere(array('program_track_id'=>$id_replace), "program_track_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_program set program_track_id='$id_replace' where program_track_id='$id' ");
                        }

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
                       // adm.academic_program-Program_Track	program_track_id  ManyToOne
                        if(!$simul)
                        {
                            // require_once "../adm/academic_program.php";
                            AcademicProgram::updateWhere(array('program_track_id'=>$id_replace), "program_track_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_program set program_track_id='$id_replace' where program_track_id='$id' ");
                        }

                        
                        // MFK

                   
               } 
               return true;
            }    
	}

    // program_track 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 406;
      if ($currstep == 2) return 407;

      return 0;
   }
             
}