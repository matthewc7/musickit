

$('#settingBtn').click(function(){
	$('#setting').slideToggle('500');
});


$('#search').click(function(){
	var v = $('#term').val();

	if(v != '')
	{
		$('#response').html('');

		$.ajax({
			url: '/finder/search',	
			data: {
				term: v,
				country: $('#c').val(),
				entity: $('#e').val()
			},
			dataType: "json",
			success: function(response) {
				if(response.results > 0)
				{
					$('#response').html(response.content);
				}
				else
				{
					$('#response').html("<p class='alert'>No results found.</p>");
				}
			}
		}); 
	}

});