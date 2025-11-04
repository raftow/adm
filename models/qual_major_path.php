<?php

class QualMajorPath extends AdmObject
{

    public static $DATABASE = '';

    public static $MODULE = 'adm';

    public static $TABLE = 'qual_major_path';

    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct('qual_major_path', 'id', 'adm');
        AdmQualMajorPathAfwStructure::initInstance($this);

    }

    public static function loadById($id)
    {
        $obj = new QualMajorPath();

        if ($obj->load($id)) {
            return $obj;
        } else {
            return null;
        }

    }

    public function getDisplay($lang = 'ar')
    {
        return $this->getDefaultDisplay($lang);
    }

    public function stepsAreOrdered()
    {
        return false;
    }

    public function beforeDelete($id, $id_replace)
    {
        $server_db_prefix = AfwSession::config('db_prefix', 'nauss_');

        if (! $id) {
            $id    = $this->getId();
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

}
