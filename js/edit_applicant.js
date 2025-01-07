function bootstrapHzmBtnInputChanged(inputname, old_val, new_val)
{
    if((inputname=='doc_type_id') && (new_val > 0))
    {
        $("#drop").removeClass("hide");
    }

}