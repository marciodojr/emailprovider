$("#requestAccessToken").click(function(){
    $.getJSON('/facebook/requestPageAccessToken').then(function(response){
        location.href = response.url;
    });
});

$("#pageIdBtn").click(function(){
    var pageId = $("#pageId").val();
    if(pageId) {
        console.log('click...', pageId);
        $.getJSON('/facebook/page/' + pageId).then(function(response){
            console.log('page', response);
        });
    }
});
