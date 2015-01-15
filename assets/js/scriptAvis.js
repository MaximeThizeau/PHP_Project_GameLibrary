$(function() {

	var working = false;
	$('#form1').submit(function(e){

		e.preventDefault();
		if(working) return false;

		working = true;
		$('#submit').val('Chargement en cours..');
		$('span.error').remove();
		$.post('../views/include/submitAvis.php',$(this).serialize(),function(msg){

			working = false;
			$('#submit').val('Envoyer');

			console.log(msg);

			if(msg.status){

				$(msg.html).hide().insertBefore('#contentavis').slideDown();
				$('.comment').val('');
			}
			else {
				$.each(msg.errors,function(k,v){
					$('label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}
		},'json');

		/*$.ajax({

			type: "POST",
			url: './views/include/submitAvis.php',
			data: $(this).serialize(),
			success: function(data){

			}
		})*/

	});

});

$(document).ready(function(){
	$("#unhide").click(function(){
		$("#test").show();
		$("#addCommentContainer").show();
	});


	/*$("#submit").click(function(){
		$validate = true;
		if($(#name).val() == "")
			{
				$validate = false;
				$("#test").show();
			}
		else
			{
				$validate = true;
				$("#test").hide();
			}
		return $validate;
	});*/

	$("#hide").click(function(){
		$("#addCommentContainer").hide();
	});

});

/*$(document).click(function(event) {
if($(event.target).closest('#test').length) {
if($('#test').is(":visible")) {
$('#test').hide()
}
}
})*/

/*$("body").click(function(){$("#addCommentContainer").hide()});

$('#addCommentContainer').click(function(event){
event.stopPropagation();
});*/


$(document).mouseup(function (e)
{
	var container = $("#addCommentContainer");

	if (!container.is(e.target) // if the target of the click isn't the container...
		&& container.has(e.target).length === 0) // ... nor a descendant of the container
		{
			container.hide();
		}
	});
