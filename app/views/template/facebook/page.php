<section>
    <div class="container-fluid">
        <div class="form-group">
            <label for="accessToken" class="control-label">Token de Acesso</label>
            <div class="input-group">
                <input type="text" id="accessToken" value="<?php echo $accessToken; ?>" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-primary" id="requestAccessToken" type="button"> Solicitar </button>
                </span>
            </div>
            <div class="help-block with-errors"><small>Para acessar as informações de páginas é preciso ter algumas permissões de usuário.</div>
        </div>
        <?php if($accessToken): ?>
            <div id="pageContainer" class="row">
                <div class="col-md-4">
                    <div class="form-group">
                          <label for="pageId" class="control-label">Página</label>
                          <div class="input-group">
                            <input type="text" pattern="^[_A-z0-9]{1,}$" maxlength="15" class="form-control" id="pageId" placeholder="nubankbrasil" required>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" id="pageIdBtn" type="button"> Pesquisar </button>
                            </span>
                          </div>
                          <div class="help-block with-errors"><small>Ex: https://www.facebook.com/<code><b>nubankbrasil</b></code>/</small></div>
                    </div>
            </div>
        <?php endif; ?>
    </div>
</section>
