function getData(e,t){var e=$("#c").val(),t=$(".options li.active .option").val();e!=0&&$.ajax({url:"/charts/load",data:{country:e,type:t},dataType:"text",success:function(e){$("#response").html("");$("#response").html(e)}})}$(".options li").click(function(){$(this).siblings(".active").removeClass("active");$(this).addClass("active");getData()});$("#c").change(function(){if($("#c").val()==0)$(".country").html("");else{var e=" - "+$("#c option:selected").text();$(".country").html(e)}getData()});