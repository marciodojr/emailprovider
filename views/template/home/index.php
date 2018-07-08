<div class="w-25 loginbox bg-dark text-white border p-3" id="loginbox">
    <form class="mr-3 ml-3 mb-5">
        <div class="alert alert-danger mt-4" role="alert" v-if="error">
            {{error}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="alert alert-success mt-4" role="alert" v-if="success">
            {{success}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="input-group input-group-lg mt-5">
            <input type="text" class="form-control" v-model="username"
                placeholder="Usuário">
        </div>
        <div class="input-group input-group-lg mt-2">
            <input type="password" class="form-control" v-model="password" placeholder="Senha">
        </div>

        <button type="button" class="btn btn-primary btn-lg btn-block mt-3"
            v-bind:disabled="block"
            v-on:click="doLogin"
            >Entrar</button>
    </form>
</div>
