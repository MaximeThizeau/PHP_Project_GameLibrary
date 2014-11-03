$(document).ready(function() {
	$('#search').autocomplete({
		serviceUrl: './views/include/search.php',
		dataType: 'json'
	});
});
