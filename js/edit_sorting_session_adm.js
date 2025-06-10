function pageWizardReady()
{
        $(".wizcapacity").click(function() {
                var col = 'capacity';
                var cls = 'SortingSessionStat';
                var mod = 'adm';
                var idobj = $(this).attr("idobj");
                var val = $(this).attr("val");
                save_popup(mod, cls, idobj, col, val);
                
                var parent_container = $("#popup_edit_parent_capacity").val();
                $("#"+parent_container).addClass("obsolete"); 
                $("#tr-object-"+idobj).removeClass("hzm_row_Y"); 
                $("#tr-object-"+idobj).removeClass("hzm_row_N"); 
                $("#tr-object-"+idobj).removeClass("hzm_row_W"); 
                $("#tr-object-"+idobj).addClass("hzm_row_0"); 
        });


        $(".dlike").click(function() {
                var idobj = $(this).attr("idobj");
                $("#tr-object-"+idobj).addClass("remove-execo"); 
        });

        $(".elike").click(function() {
                var idobj = $(this).attr("idobj");
                $("#tr-object-"+idobj).addClass("add-execo"); 
        });

        $(".farz-wizard").removeClass("disable"); 
        $(".btn.refresh_wizard").addClass("hide"); 
}

$(document).ready(function() {
       pageWizardReady();         
});