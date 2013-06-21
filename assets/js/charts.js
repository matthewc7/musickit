

$('.options li').click(function(){
	$(this).siblings('.active').removeClass('active');
	$(this).addClass('active');

	getData();
});


$('#c').change(function(){

	if($('#c').val() == 0){
		$('.country').html('');
	}
	else{
		var country_name = ' - ' + $('#c option:selected').text();
		$('.country').html(country_name);
	}
	
	getData();

});


function getData(country, type){

	var country = $('#c').val();
	var type = $('.options li.active .option').val();
	
	if(country != 0)
	{
		$.ajax({
			url: '/charts/load',	
			data: {
				country: country,
				type: type
			},
			dataType: "text",
			success: function(response) {
				$('#response').html('');
				$('#response').html(response);
			}
		}); 
	}

}
