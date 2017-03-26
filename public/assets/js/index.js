global.jQuery = $ = require('jquery');
require('bootstrap-sass');

$(function(){
	console.log('testing....');

	$("#say-hello").click(function(){
		alert('Hello?????');
	});

});
