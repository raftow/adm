<?php
$tokens = [];
$tokens["applicant_nb"] = Applicant::aggreg("count(*)");
$tokens["applicants_title"] = Applicant::t('applicant', $lang);
$tokens["application_nb"] = Application::aggreg("count(*)");
$tokens["applications_title"] = Application::t('application', $lang);
$tokens["unit_nb"] = TrainingUnit::aggreg("count(*)");
$tokens["units_title"] = TrainingUnit::t('', $lang);
$tokens["major_nb"] = ApplicationModelBranch::aggreg("count(*)");
$tokens["majors_title"] = ApplicationModelBranch::t('', $lang);
$tokens["satisfaction_pct"] = 99.1;
$tokens["satisfaction_title"] = Application::t('satisfaction', $lang);
$tokens["mytasks_nb"] = 7;
$tokens["mytasks_title"] = Application::t('tasks', $lang);

return $tokens;