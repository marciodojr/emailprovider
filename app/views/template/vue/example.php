<h3 class="text-center">Exemplo de uso do Vue em uma tela </h3>
<hr>

<div class="row" id="exampleApp">
    <div class="col-md-3 col-sm-6 col-xs-12" v-for="trip in trips">
        <div class="thumbnail">
            <img v-bind:src="trip.imgSrc" v-bind:alt="trip.imgAlt">
            <div class="caption">
                <h3>{{trip.title}}</h3>
                <p>{{trip.comment}}</p>
                <p>
                    <button class="btn btn-primary" role="button">Mais detalhes</button>
                    <button class="btn btn-danger" role="button" v-on:click="removeTrip(trip.id)">Remover</button>
                </p>
            </div>
        </div>
    </div>
</div>
