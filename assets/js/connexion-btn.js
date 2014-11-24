
		 			$(document).ready(
				    function(){
				        $("#connection").click(function () {
				            $("#connexion-pop-up").show(500);
				        });
				
				    });
				    $(document).mouseup(function (e)
					{
					    var container = $("#connexion-pop-up");
					
					    if (!container.is(e.target) // if the target of the click isn't the container...
					        && container.has(e.target).length === 0) // ... nor a descendant of the container
					    {
					        container.hide(500);
					    }
					});
					$(document).ready(
				    function(){
				        $("#inscription-btn").click(function () {
				            $("#connection-form").hide(400);
				            $("#inscription-form").show(400);
				        });
				    });
				    $(document).ready(
				    function(){
				        $("#connexion-btn").click(function () {
				            $("#inscription-form").hide(400);
				            $("#connection-form").show(400);
				        });
				    });
					
					
		 		
		 			