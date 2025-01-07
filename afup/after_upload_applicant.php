<?php
        $applicantObj = Applicant::loadById($after_upload_obj_id);
        if($applicantObj) 
        {
                $afile_name = $applicantObj->attach_file($af, $doc_type_id, $doc_attach_id);
                $af->set("afile_name", $afile_name);
                $af->commit();
        }
        else 
        {
                $af->delete();
                die("applicant id=[$after_upload_obj_id] not found");
        }