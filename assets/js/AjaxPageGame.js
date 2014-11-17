$(document).ready(function(){
	$("#menu-game a").click(function()
	{
		page=$(this).attr("href");
		$.ajax({
			url: "./views/ContentAjax/"+page,
			cache:false,
			success:function(html){
				afficher(html);
			},
			error:function(XMLHttpRequest,textStatus, errorThrown){
				afficher("erreur lors du chagement de la page");
			}
		})
		return false;
	});
});

function afficher(data)
{
	$("#contenu").fadeOut(250,function()
	{
		$("#contenu").empty();
		$("#contenu").append(data);
		$("#contenu").fadeIn(250);
	})
}