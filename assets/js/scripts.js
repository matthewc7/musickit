//@codekit-prepend 'modernizr.foundation.js';
//@codekit-prepend 'foundation.min.js';


!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");


$("#loading").bind("ajaxStart", function(){
    $(this).show();
    $('#loading').css({
    	'position' : 'absolute',
    	'width' : $('#content').width()+ 'px',
    	'margin' : '0 auto'
    });
}).bind("ajaxStop", function(){
    $(this).hide();
});



