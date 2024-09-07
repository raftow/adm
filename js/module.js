function application_model_id_onchange() {
  $("#edit_form").submit();
}

function term_id_onchange() {
  $("#edit_form").submit();
}

function academic_program_id_onchange()
{
  
}

function job_status_enum_onchange(){
  // alert("aa="+$("#job_status_enum").val());
  if($("#job_status_enum").val()==2)
  {
    $("#employer_approval").prop("disabled", true);
    $("#employer_enum").prop("disabled", true);
    $("#employer_approval_afile_id").prop("disabled", true);

  }
  else
  {
    $("#employer_approval").prop("disabled", false);
    $("#employer_enum").prop("disabled", false);
    $("#employer_approval_afile_id").prop("disabled", false);
  }
}


function mother_saudi_ind_onchange(){
  if($("#mother_saudi_ind").val()=="N")
  {
    $("#mother_idn").prop("disabled", true);
    $("#mother_birth_date").prop("disabled", true);

  }
  else
  {
    $("#mother_idn").prop("disabled", false);
    $("#mother_birth_date").prop("disabled", false);

  }
}
