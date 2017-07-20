global.jQuery = $ = require('jquery');
require('bootstrap-sass');

$(function(){
    console.log('????');
	$("#sayHello").click(function(){
		alert('Hello from /hello testing browserSync!!');
	});

});
