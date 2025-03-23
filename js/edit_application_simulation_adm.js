
$(document).ready(function(){
    $(".simlog.case").click(function()
        { 
            $(".simlog.case").removeClass("current"); 
            $(this).addClass("current"); 
            arr_data = $(this).attr('id').split("-");
            idapp = arr_data[2];
            $(".rslog").addClass("hide");  
            $(".app"+idapp).removeClass("hide");  
        }
    ); 

    $("#simulation_btn").click(function()
        {
            if(!$("#simulation_btn").hasClass("disabled"))
            {
                $("#simulation_progress_task").removeClass("error"); 
                $("#sim-running").removeClass("hide"); 
                $("#simulation_btn").addClass("disabled"); 
                $("#stop_simulation_btn").removeClass("disabled"); 
                $("#log_panel").addClass("hide"); 
                $.getJSON("./api/runSimulApp.php", 
                    {
                        simid: $("#simulation_btn").attr('simid'),
                        lang:$("#simulation_btn").attr('lang')
                    },
                    
                    function(result)
                    {
                        $("#sim-running").addClass("hide"); 
                        $("#sim-done").removeClass("hide"); 
                        $("#simulation_btn").removeClass("disabled"); 
                        $("#stop_simulation_btn").addClass("disabled"); 
                        if(result.status=='success')
                        {
                            $("#simulation_progress_task").html('');
                        }
                        else
                        {
                            $("#simulation_progress_task").addClass("error"); 
                            $("#simulation_progress_task").html(result.message);
                        }
                        // alert('runSimulApp ENDED : status='+result.status+' message='+result.message);
                    }
                );

                var intervalId = setInterval(function(){
                    $.getJSON("./api/checkSimulApp.php", 
                        {
                            simid: $("#simulation_btn").attr('simid'),
                            lang:$("#simulation_btn").attr('lang')
                        },
                        
                        function(result)
                        {
                            if(result.progress<100)
                            {
                                $("#simulation_progress_task").html(result.task);
                                $("#simulation_progress_value").className.replace(/\bvalue-.*?\b/g, '');
                                $("#simulation_progress_value").addClass("value-"+result.progress); 
                            }
                            else
                            {
                                $("#simulation_progress_task").html('');
                                $("#simulation_progress_value").className.replace(/\bvalue-.*?\b/g, '');
                            }
                            
                        }
                    );
                  }, 3000);
            }
            
        }
    ); 

    $("#stop_simulation_btn").click(function()
        {
            if(!$("#stop_simulation_btn").hasClass("disabled"))
            {
                $("#stop_simulation_btn").addClass("disabled"); 
                $("#simulation_btn").removeClass("disabled"); 

                $.getJSON("./api/stopSimulApp.php", 
                    {
                        simid: $("#simulation_btn").attr('simid'),
                        lang:$("#simulation_btn").attr('lang')
                    },
                    
                    function(result)
                    {
                        alert('stopSimulApp ENDED : status='+result.status+' message='+result.message);
                    }
                );
            }
            
        }
    ); 
});

