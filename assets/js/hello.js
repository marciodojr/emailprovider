global.jQuery = $ = require('jquery');
require('bootstrap-sass');
var moment = require('moment')

$(function(){
	$("#sayHello").click(function(){
		alert('Hello ' + moment().format());
	});

});
