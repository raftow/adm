<?php
class RelationshipArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["relationship"]["relationship.single"] = "علاقة";
	$trad["relationship"]["relationship.new"] = "جديد ة";
	$trad["relationship"]["relationship"] = "العلاقات";
	$trad["relationship"]["relationship_name_ar"] = "اسم نوع العلاقة عربي";
	$trad["relationship"]["relationship_name_en"] = "اسم نوع العلاقة انقليزي";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new RelationshipEnTranslator();
		return new Relationship();
	}
}