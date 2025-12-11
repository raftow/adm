<?php

class ApplicantScientificResearchEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_scientific_research"]["applicantscientificresearch.single"] = "Scientific publishing research";
		$trad["applicant_scientific_research"]["applicantscientificresearch.new"] = "new";
		$trad["applicant_scientific_research"]["applicant_scientific_research"] = "scientific publishing research";
		$trad["applicant_scientific_research"]["name_ar"] = "Arabic Applicant scientific research name";
		$trad["applicant_scientific_research"]["name_en"] = "English Applicant scientific research name";
		$trad["applicant_scientific_research"]["desc_ar"] = "Arabic Applicant scientific research description";
		$trad["applicant_scientific_research"]["desc_en"] = "English Applicant scientific research description";
		$trad["applicant_scientific_research"]["applicant_id"] = "Applicant";
		$trad["applicant_scientific_research"]["title"] = "Title";
		$trad["applicant_scientific_research"]["publication_venue"] = "Title";
		$trad["applicant_scientific_research"]["authorship_category_id"] = "Authorship category";
		$trad["applicant_scientific_research"]["publication_link"] = "DOI/Link";
		$trad["applicant_scientific_research"]["citation"] = "Citations";
		$trad["applicant_scientific_research"]["publication_date"] = "Publication date";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantScientificResearchArTranslator();
		return new ApplicantScientificResearch();
	}
}