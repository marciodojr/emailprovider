<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Erro 500</h2>
                <p>O servidor teve um problema inesperado.</p>
                <br>
                <code>
                    <small> <?php echo $message; ?> </small>
                    <small> <?php print_r($trace); ?> </small>
                </code>
            </div>
        </div>
    </div>
</section>
