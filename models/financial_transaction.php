<?php
        class FinancialTransaction extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "financial_transaction"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("financial_transaction","id","adm");
                        AdmFinancialTransactionAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new FinancialTransaction();
                        
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

        }
?>
