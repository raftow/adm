<?php 

/*
 medali 26/09/2024 */
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class ThirdPartyType extends AFWObject{

        public static $MY_ATABLE_ID=13918; 
  
        public static $DATABASE		= "";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "third_party_type";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("third_party_type","id","adm");
            AdmThirdPartyTypeAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new ThirdPartyType();
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
               return $this->getVal("third_party_type_name_$lang");
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
        
        public function isTechField($attribute) {
            return (($attribute=="created_by") or ($attribute=="created_at") or ($attribute=="updated_by") or ($attribute=="updated_at") or ($attribute=="validated_by") or ($attribute=="validated_at") or ($attribute=="version"));  
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","default_db_");
            
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
                       // adm.third_party-نوع الطرف الثالث	third_party_type_id  ManyToOne
                        if(!$simul)
                        {
                            // require_once "../adm/third_party.php";
                            ThirdParty::removeWhere("third_party_type_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.third_party where third_party_type_id = '$id' ");
                            
                        } 
                        
                        

                   
                   // FK not part of me - replaceable 
                       // adm.third_party-نوع الطرف الثالث	third_party_type_id  ManyToOne
                        if(!$simul)
                        {
                            // require_once "../adm/third_party.php";
                            ThirdParty::updateWhere(array('third_party_type_id'=>$id_replace), "third_party_type_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.third_party set third_party_type_id='$id_replace' where third_party_type_id='$id' ");
                        }

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
                       // adm.third_party-نوع الطرف الثالث	third_party_type_id  ManyToOne
                        if(!$simul)
                        {
                            // require_once "../adm/third_party.php";
                            ThirdParty::updateWhere(array('third_party_type_id'=>$id_replace), "third_party_type_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.third_party set third_party_type_id='$id_replace' where third_party_type_id='$id' ");
                            
                        }
                        
                       // adm.third_party-نوع الطرف الثالث	third_party_type_id  ManyToOne
                        if(!$simul)
                        {
                            // require_once "../adm/third_party.php";
                            ThirdParty::updateWhere(array('third_party_type_id'=>$id_replace), "third_party_type_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.third_party set third_party_type_id='$id_replace' where third_party_type_id='$id' ");
                        }

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}



// errors 

