<?php
class ApplicantFintransEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_fintrans"]["applicantfintrans.single"] = "Applicant fintrans";
	$trad["applicant_fintrans"]["applicantfintrans.new"] = "new";
	$trad["applicant_fintrans"]["applicant_fintrans"] = "Applicant fintranss";
	$trad["applicant_fintrans"]["applicant_id"] = "Applicant";
	$trad["applicant_fintrans"]["application_id"] = "Application request";
	$trad["applicant_fintrans"]["appmodel_fintran_id"] = "Finacial Transaction";
	$trad["applicant_fintrans"]["total_amount  "] = "Total Amount";
	$trad["applicant_fintrans"]["payment_status_enum"] = "Payment Status";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantFintrans();
	}
}