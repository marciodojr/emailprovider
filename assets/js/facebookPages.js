$("#requestAccessToken").click(function(){
    $.getJSON('/facebook/requestPageAccessToken').then(function(response){
        location.href = response.url;
    });
});
