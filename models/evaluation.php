<?php
        class Evaluation extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "evaluation"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("evaluation","id","adm");
                        AdmEvaluationAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Evaluation();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public static function loadByEnglishName($name_en)
                {
                        $obj = new Evaluation();
                        $obj->select("evaluation_name_en", $name_en);
                        if($obj->load())
                        {
                                return $obj;
                        }
                        else return null;
                }

                public static function EvalNameToId($name_en)                
                {
                        $obj = self::loadByEnglishName($name_en);
                        if($obj) return $obj->id;
                        return 0;
                }


                

                public function getDisplay($lang = 'ar')
                {
                        return $this->getDefaultDisplay($lang);
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

                protected function userCanEditMeWithoutRole($auser)
                {
                        // @todo this temporary for demo of amjad
                        return [true, 'for demo'];
                }


        }
?>