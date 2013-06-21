$('#search').click(function(){
	var v = $('#upc').val();

	if(v == '')
	{
		$('#response').html('').html('<div class="alert"><p>Please enter UPC to search.<p></div>');
	}
	else
	{
		var check_numeric = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;

		if($.trim(v).length < 12 || check_numeric.test(v) == false)
		{
			$('#response').html('').html('<div class="alert"><p>Invalid UPC.</p><p>Please enter a validate UPC.</p></div>');
		}
		else
		{
			$('#response').html('');

			$.ajax({
				url: '/locator/search',	
				data: {
					upc: v
				},
				dataType: "json",
				success: function(response) {

					if(response.available > 0)
					{
						$('#response').html(response.content);
						$('#results').html(response.total);
					}
					else
					{
						$('#response').html("<p class='alert'>No results found.</p>");
					}
				}
			}); 

		}
	}


	

});