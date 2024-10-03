function qualification_major_id_onchange()
{

}
function source_onchange(){
    $.getJSON("./api/getGpaFrom.php", 
                   {
                   
                   qualification_id: $("#qualification_id").val()
                       
                   },
                   
                   function(result)
                   {
                    //alert(result);
                   $('#gpa_from').val(result); 
                   
                   });
}

