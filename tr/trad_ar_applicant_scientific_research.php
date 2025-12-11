<?php

class ApplicantScientificResearchArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_scientific_research"]["applicantscientificresearch.single"] = "النشر العلمي والبحث العلمي";
		$trad["applicant_scientific_research"]["applicantscientificresearch.new"] = "جديد(ة)";
		$trad["applicant_scientific_research"]["applicant_scientific_research"] = "النشر العلمي والبحث العلمي";
		$trad["applicant_scientific_research"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_scientific_research"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_scientific_research"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_scientific_research"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_scientific_research"]["applicant_id"] = "المتقدم";
		$trad["applicant_scientific_research"]["title"] = "عنوان البحث";
		$trad["applicant_scientific_research"]["publication_venue"] = "وسيلة النشر";
		$trad["applicant_scientific_research"]["authorship_category_id"] = "فئة الالمؤلف";
		$trad["applicant_scientific_research"]["publication_link"] = "(DOI)الرابط";
		$trad["applicant_scientific_research"]["citation"] = "الاستشهادات";
		$trad["applicant_scientific_research"]["publication_date"] = "تاريخ النشر";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantScientificResearchEnTranslator();
		return new ApplicantScientificResearch();
	}
}