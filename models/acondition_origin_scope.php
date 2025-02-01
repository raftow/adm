<?php
class AconditionOriginScope extends AdmObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "adm";
    public static $TABLE            = "acondition_origin_scope";
    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct("acondition_origin_scope", "id", "adm");
        AdmAconditionOriginScopeAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new AconditionOriginScope();

        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public function getDisplay($lang = 'ar')
    {
        return $this->getDefaultDisplay($lang, '&larr;');
    }

    public function stepsAreOrdered()
    {
        return true;
    }

    public function shouldBeCalculatedField($attribute)
    {
        if($attribute == "application_model_mfk") return true;
        if($attribute=="program_track_mfk") return true;
        return false;
    }

    public function beforeMaj($id, $fields_updated)
    {
        if (!$this->getVal("training_unit_id")) {
            $this->setForce("training_unit_id", 0, true);
        }

        if (!$this->getVal("department_id")) {
            $this->setForce("department_id", 0, true);
        }

        if (!$this->getVal("application_model_branch_id")) {
            $this->setForce("application_model_branch_id", 0, true);
        }




        return true;
    }

    public function beforeDelete($id, $id_replace)
    {
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

        if (!$id) {
            $id = $this->getId();
            $simul = true;
        } else {
            $simul = false;
        }

        if ($id) {
            if ($id_replace == 0) {
                // FK part of me - not deletable 


                // FK part of me - deletable 


                // FK not part of me - replaceable 



                // MFK

            } else {
                // FK on me 


                // MFK


            }
            return true;
        }
    }

    // acondition_origin_scope 
    public function getScenarioItemId($currstep)
    {
        if ($currstep == 1) return 472;

        return 0;
    }

    protected function userCanEditMeWithoutRole($auser)
    {
        // @todo this temporary for demo of amjad
        return [true, 'for demo'];
    }
}
