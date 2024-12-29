<?php
        $applicantObj = Applicant::loadById($after_upload_obj_id);
        if($applicantObj) $applicantObj->attach_file($af);
        else die("applicant id=[$after_upload_obj_id] not found");