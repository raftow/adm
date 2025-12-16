<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class ApplicationCvScore extends AFWObject{

        public static $MY_ATABLE_ID=14031; 
  
        public static $DATABASE		= "nauss_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "application_cv_score";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("application_cv_score","id","adm");
            AdmApplicationCvScoreAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new ApplicationCvScore();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        

        public function getScenarioItemId($currstep)
                {
                    
                    return 0;
                }
        
        
        public function getDisplay($lang="ar")
        {
               
        }
        
        
        

        
        protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
        {
             $lang = AfwLanguageHelper::getGlobalLanguage();
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
        
        /*
        public function isTechField($attribute) {
            return (($attribute=="created_by") or 
                    ($attribute=="created_at") or 
                    ($attribute=="updated_by") or 
                    ($attribute=="updated_at") or 
                    // ($attribute=="validated_by") or ($attribute=="validated_at") or 
                    ($attribute=="version"));  
        }*/
        
        
        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","nauss_");
            
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

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}

    public function afterMaj($id, $fields_updated)
    {
        	
        if ($fields_updated["score_QUAL"]) {
            
            $this->set("review_date_QUAL", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_PEXP"]) {
            
            $this->set("review_date_PEXP", date("Y-m-d H:i:s"));    
        }
        if ($fields_updated["score_CRWQ"]) {
            
            $this->set("review_date_CRWQ", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_SCINT"]) {
            
            $this->set("review_date_SCINT", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_VOLAC"]) {
            
            $this->set("review_date_VOLAC", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_AWAP"]) {
            
            $this->set("review_date_AWAP", date("Y-m-d H:i:s"));
        }
        if ($fields_updated["score_SCRSC"]) {
            
            $this->set("review_date_SCRSC", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_LANGP"]) {
            
            $this->set("review_date_LANGP", date("Y-m-d H:i:s"));
        }
        if ($fields_updated["score_SCCONF"]) {
            
            $this->set("review_date_SCCONF", date("Y-m-d H:i:s"));
            
        }
        if ($fields_updated["score_RECLT"]) {
            
            $this->set("review_date_RECLT", date("Y-m-d H:i:s"));
        }
        $this->commit();
    }
             
}

