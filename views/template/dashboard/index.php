<div id="dashboard" class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2 p-5">
            <p class="text-right"> <a href="#" v-on:click="logout()"><i class="fas fa-sign-out-alt"></i> Sair</a></p>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#emails">
                        <i class="fas fa-envelope"></i> Emails</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#aliases">
                        <i class="fas fa-envelope-open"></i> Aliases </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#domains">
                        <i class="fas fa-globe"></i> Domínios </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="emails">

                    <div class="btn-toolbar mt-3">
                        <div class="btn-group mx-auto" role="group" aria-label="First group">
                            <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" v-on:click="clearEmail()" data-target="#emailModal">
                                <i class="fas fa-plus mr-1 mt-1"></i> Adicionar</button>
                            <button type="button" class="btn btn-sm btn-danger mr-2" data-toggle="modal" v-on:click="setEmailName()" data-target="#emailRemoveModal"
                                v-bind:disabled="isVUserSelected">
                                <i class="fas fa-times mr-1 mt-1"></i> Remover</button>
                        </div>
                    </div>

                    <div class="table-responsive h-500px pr-1">
                        <table class="table table-sm table-hover mt-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody class="cursor-ponter">
                                <tr v-for="(vu, index) in virtualUsers" v-on:click="selectVUser(index)">
                                    <th class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" v-bind:value="index" v-model="selectedVUserIndex">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </th>
                                    <td>{{vu.id}}</td>
                                    <td>{{vu.email}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="aliases">
                    <div class="btn-toolbar mt-3">
                        <div class="btn-group mx-auto" role="group" aria-label="First group">
                            <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" v-on:click="clearAlias()" data-target="#aliasModal">
                                <i class="fas fa-plus mr-1 mt-1"></i> Adicionar</button>
                            <button type="button" class="btn btn-sm btn-danger mr-2" data-toggle="modal" v-on:click="setAliasName()" data-target="#aliasRemoveModal"
                                v-bind:disabled="isVAliasSelected">
                                <i class="fas fa-times mr-1 mt-1"></i> Remover</button>
                        </div>
                    </div>
                    <div class="table-responsive h-500px pr-1">
                        <table class="table table-sm table-hover mt-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Origem</th>
                                    <th scope="col">Destino</th>
                                </tr>
                            </thead>
                            <tbody class="cursor-ponter">
                                <tr v-for="(va, index) in virtualAliases" v-on:click="selectVAlias(index)">
                                    <th class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" v-bind:value="index" v-model="selectedVAliasesIndex">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </th>
                                    <td>{{va.id}}</td>
                                    <td>{{va.source}}</td>
                                    <td>{{va.destination}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="domains">
                    <div class="btn-toolbar mt-3">
                        <div class="btn-group mx-auto" role="group" aria-label="First group">
                            <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" v-on:click="clearDomain()" data-target="#domainModal">
                                <i class="fas fa-plus mr-1 mt-1"></i> Adicionar</button>
                            <button type="button" class="btn btn-sm btn-warning mr-2" data-toggle="modal" v-on:click="setDomainName()" data-target="#domainEditModal"
                                v-bind:disabled="isVDomainSelected">
                                <i class="fas fa-edit mr-1 mt-1"></i> Editar</button>
                            <button type="button" class="btn btn-sm btn-danger mr-2" data-toggle="modal" v-on:click="setDomainName()" data-target="#domainRemoveModal"
                                v-bind:disabled="isVDomainSelected">
                                <i class="fas fa-times mr-1 mt-1"></i> Remover</button>
                        </div>
                    </div>
                    <div class="table-responsive h-500px pr-1">
                        <table class="table table-sm table-hover mt-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Domínio</th>
                                </tr>
                            </thead>
                            <tbody class="cursor-ponter">
                                <tr v-for="(vd, index) in virtualDomains" v-on:click="selectVDomain(index)">
                                    <th class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" v-bind:value="index" v-model="selectedVDomainsIndex">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </th>
                                    <td>{{vd.id}}</td>
                                    <td>{{vd.name}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email -->
    <div class="modal" id="emailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" v-model="domain">
                            <option value="" selected disabled>domínio</option>
                            <option v-for="(vd, idx) in virtualDomains" v-bind:value="idx">{{vd.name}}</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="fulano" v-model="emailName">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-at"></i>{{domain !== "" ? virtualDomains[domain].name: '...'}}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="senha" v-model="emailPassword">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="clearEmail()" data-dismiss="modal">Desistir</button>
                    <button type="button" class="btn btn-primary" v-on:click="addEmail()" v-bind:disabled="waitForResponse">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="emailRemoveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remover Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja remover o email
                        <b>{{emailName}}</b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="clearEmail()" data-dismiss="modal">Desistir</button>
                    <button type="button" class="btn btn-danger" v-on:click="removeEmail()" v-bind:disabled="waitForResponse">Remover</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Alias -->
    <div class="modal" id="aliasModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Alias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" v-model="aliasvu">
                            <option value="" selected disabled>Origem</option>
                            <option v-for="vu in virtualUsers" v-bind:value="vu.id">{{vu.email}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Destino</label>
                        <input type="email" class="form-control" placeholder="fulano@gmail.com" v-model="aliasName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="clearAlias()" data-dismiss="modal">Desistir</button>
                    <button type="button" class="btn btn-primary" v-on:click="addAlias()" v-bind:disabled="waitForResponse">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="aliasRemoveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remover Alias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja remover o alias
                        <b>{{aliasName}}</b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="clearAlias()" data-dismiss="modal">Desistir</button>
                    <button type="button" class="btn btn-danger" v-on:click="removeAlias()" v-bind:disabled="waitForResponse">Remover</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Domínios -->
    <div class="modal" id="domainModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Domínio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-at"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" v-model="domainName" placeholder="incluirtecnologia.com.br">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="clearDomain()" data-dismiss="modal">Desistir</button>
                    <button type="button" class="btn btn-primary" v-on:click="addDomain()" v-bind:disabled="waitForResponse">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="domainEditModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Domínio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-at"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" v-model="domainName" placeholder="incluirtecnologia.com.br">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="clearDomain()" data-dismiss="modal">Desistir</button>
                    <button type="button" class="btn btn-warning" v-on:click="editDomain()" v-bind:disabled="waitForResponse">Editar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="domainRemoveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remover Domínio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja remover o domínio
                        <b>{{domainName}}</b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" v-on:click="clearDomain()" data-dismiss="modal">Desistir</button>
                    <button type="button" class="btn btn-danger" v-on:click="removeDomain()" v-bind:disabled="waitForResponse">Remover</button>
                </div>
            </div>
        </div>
    </div>
</div>
