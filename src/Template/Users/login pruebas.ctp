<?= $this->Html->css('login') ?>

<div class="container" style="background-color: red;">
	<div class="jumbotron">
    	<h1>Bienvenidos al ambiente de pruebas de Sistema Colegio Verdad y Libertad !</h1>
	</div>
	<div class="row" style="margin-top:20px">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
	        <?= $this->Flash->render('auth') ?>
			<?= $this->Form->create() ?>
				<fieldset>
					<hr class="colorgraph">
					<div class="form-group">
	                    <?= $this->Form->input('username', ['class' => 'form-control input-lg', 'placeholder' => 'Usuario', 'label' => false, 'required']) ?>
					</div>
					<div class="form-group">
	                    <?= $this->Form->input('password', ['class' => 'form-control input-lg', 'placeholder' => 'Contraseña', 'label' => false, 'required']) ?>
					</div>
					<hr class="colorgraph">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
	                        <?= $this->Form->button('Acceder', ['id' => 'to-access', 'class' => 'btn btn-lg btn-success btn-block']) ?>
						</div>
<!--
						<div class="col-xs-6 col-sm-6 col-md-6">
							<?= $this->Html->link('Registrarse', ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-lg btn-primary btn-block']) ?>
						</div>
-->
					</div>
				</fieldset>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#to-access').click(function(e) 
        {
        	passwordUser = $("#password").val();
        	if (passwordUser.toLowerCase() == "verdad")
        	{
	            $('#password').val($('#password').val().toLowerCase());
        	}
        });
    });
</script>