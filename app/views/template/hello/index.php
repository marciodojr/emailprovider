<section class="container">
    <p class="text-center">
        HelloController::index says: "<?php echo $resp; ?>". Timestamp: <?php echo date('d/m/Y H:i:s'); ?>
        <br>
        <button id="sayHello" class="btn btn-primary"> <i class="icon-pencil"></i> Click Me</button>
        <br>
        <div class="form-group">
            <label>Telefone</label>
            <input type="text" class="form-control mask-phone">
        </div>
        <div class="form-group">
            <label>Cartão de Crédito</label>
            <input type="text" class="form-control mask-creditcard">
        </div>
        <div class="form-group">
            <label>Código do Cartão de Crédito</label>
            <input type="text" class="form-control mask-cvv">
        </div>
        <div class="form-group">
            <label>Data Cartão de Crédito</label>
            <input type="text" class="form-control mask-cc-expiration">
        </div>
        <div class="form-group">
            <label>Cpf</label>
            <input type="text" class="form-control mask-cpf">
        </div>
        <div class="form-group">
            <label>Cpf/Cnpj</label>
            <input type="text" class="form-control mask-cpf-cnpj">
        </div>
        <div class="form-group">
            <label>Código Bancário</label>
            <input type="text" class="form-control mask-bank-code">
        </div>
        <div class="form-group">
            <label>Cep</label>
            <input type="text" class="form-control mask-zip">
        </div>
        <div class="form-group">
            <label>Data</label>
            <input type="text" class="form-control mask-date">
        </div>
        <div class="form-group">
            <label>Monetário com Moeda</label>
            <input type="text" class="form-control mask-money">
        </div>
        <div class="form-group">
            <label>Monetário sem Moeda</label>
            <input type="text" class="form-control mask-money-no-currency">
        </div>
    </p>
</section>
