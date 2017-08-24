<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Erro 500</h2>
                <h3 class="section-subheading text-muted">O servidor teve um problema inexperado.</h3>
                <?php if(!\IntecPhp\Model\Config::isProduction()):?>
<pre>
<?php echo debug_print_backtrace(); ?>
</pre>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
