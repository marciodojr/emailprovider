var Vue = require("vue/dist/vue.common");

console.log('Hello!!!!');


$(document).ready(function(){
    loadData();
});

var veData = {
    trips: []
}

// imgSrc: '/img/portfolio/dreams-preview.png',
//     imgAlt: 'Foto dos sonhos',
//     title: 'Thumbnail label',
//     comment: 'Esta é a foto feliz de um momento inesquecivel da história da Disney'


var vueExampleApp = new Vue({
    el: "#exampleApp",
    data: veData,
    methods: {
        removeTrip: function(tripId){
            if(confirm('Tem certeza que deseja remover a viagem ' + tripId)) {
                // requisição ajax para solicitar remoção
                var index = null;

                this.trips.find(function(t, i){
                    if(t.id == tripId) {
                        index = i;
                        return true;
                    }
                });
                if(index !== null) {
                    this.trips.splice(index, 1);
                }
            }
        }
    }
});


function loadData() {
    $.get('/vue-example/data', null, null, 'json').then(function(response){
        var d = response.data;
        console.log('resp', d);
        veData.trips = d;
        // veData.imgAlt = d.imgAlt;
        // veData.title = d.title;
        // veData.comment = d.comment;
    });
}


