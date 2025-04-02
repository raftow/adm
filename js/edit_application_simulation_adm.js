function simulation_ended(result)
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
    stopCheckCurrentSimulation();
    // alert('runSimulApp ENDED : status='+result.status+' message='+result.message);
}

function stopCheckCurrentSimulation()
{
    if($("#check-interval-id").val()>0)
    {
        clearInterval($("#check-interval-id").val());
    }
}

function checkCurrentSimulation()
{
    var intervalId = setInterval(function(){
        $.ajax({
            url: "./api/checkSimulApp.php",
            dataType: 'json',
            async: true,
            data: {
                simid: $("#simulation_btn").attr('simid'),
                lang:$("#simulation_btn").attr('lang')
            },
            success: function(result)
            {
                if(result.progress<100)
                {
                    if(!$("#simulation_progress_task").hasClass("error"))
                    {
                        $("#simulation_progress_task").html(result.task);
                        //$("#simulation_progress_value").className.replace(/\bvalue-.*?\b/g, '');
                        $("#simulation_progress_value").addClass("value-"+result.progress); 
                    }                                
                }
                else
                {
                    if(!$("#simulation_progress_task").hasClass("error"))
                    {
                        $("#simulation_progress_task").html('');
                        $("#simulation_progress_value").addClass("value-100"); 
                        //$("#simulation_progress_value").className.replace(/\bvalue-.*?\b/g, '');
                        simulation_ended(result);
                    }
                }
                
            }
        }
        );
      }, 500);

      $("#check-interval-id").val(intervalId);
}

function runCurrentSimulation()
{
    $("#simulation_progress_task").removeClass("error"); 
    $("#sim-running").removeClass("hide"); 
    $("#simulation_btn").addClass("disabled"); 
    $("#stop_simulation_btn").removeClass("disabled"); 
    $("#log_panel").addClass("hide");
    $.ajax({
        url: "./api/runSimulApp.php",
        dataType: 'json',
        async: true,
        data: {
            simid: $("#simulation_btn").attr('simid'),
            lang:$("#simulation_btn").attr('lang')
        },
        success: function(result)
        {
            simulation_ended(result);
        }
      }); 

    checkCurrentSimulation();
}


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
                runCurrentSimulation();
            }
            
        }
    ); 

    $("#stop_simulation_btn").click(function()
        {
            if(!$("#stop_simulation_btn").hasClass("disabled"))
            {
                $("#stop_simulation_btn").addClass("disabled"); 
                $.ajax({
                    url: "./api/stopSimulApp.php",
                    dataType: 'json',
                    async: true,
                    data: {
                        simid: $("#simulation_btn").attr('simid'),
                        lang:$("#simulation_btn").attr('lang')
                    },
                    success: function(result)
                    {
                        $("#simulation_progress_task").html('');
                        $("#simulation_btn").removeClass("disabled"); 
                    }
                  });
            }
            
        }
    ); 
});

    

