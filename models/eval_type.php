<?php
        class EvalType extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "eval_type"; 
                public static $DB_STRUCTURE = null;
                public static $copypast = true;

                public function __construct(){
                        parent::__construct("eval_type","id","adm");
                        AdmEvalTypeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new EvalType();
                        
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