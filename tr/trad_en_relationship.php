<?php
class RelationshipEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["relationship"]["relationship.single"] = "Relationship";
	$trad["relationship"]["relationship.new"] = "new";
	$trad["relationship"]["relationship"] = "Relationships";
	$trad["relationship"]["relationship_name_ar"] = "relationship name arabic";
	$trad["relationship"]["relationship_name_en"] = "relationship name english";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new RelationshipArTranslator();
		return new Relationship();
	}
}