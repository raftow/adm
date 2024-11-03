<?php

// medali 14/09/2024
        class Institution extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "institution"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("institution","id","adm");
                        AdmInstitutionAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Institution();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang = 'ar')
                {
                        return $this->getDefaultDisplay($lang);
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

                // institution 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 400;
      if ($currstep == 2) return 401;

      return 0;
   }

        }
?>