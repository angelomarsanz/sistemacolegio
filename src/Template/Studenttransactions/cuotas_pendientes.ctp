<?php
    use Cake\Routing\Router;
?>
<style>
@media screen
{
    .volver 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 50px;
        opacity: 0.5;
    }
    .cerrar 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 95px;
        opacity: 0.5;
    }
    .menumenos
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .menumas 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .noverScreen
    {
      display:none
    }
}
@media print 
{
    .nover 
    {
      display:none
    }
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
}
</style>
<div class="row">
    <div class="col-md-8">
    	<div class="page-header">
	        <h3>Pagos pendientes</h3>
			<h5>
				<?= $this->Form->create() ?>
					<fieldset>						
						<label for="saldo">Saldo ($):</label>
						<input type="text" name="saldo" value="495,00" style="text-align: center">
						<label for="a_pagar">A pagar ($):</label>
						<input type="text" name="a_pagar" value="495,00" style="text-align: center">
					</fieldset>
				<?= $this->Form->end() ?>
			</h5>
        </div>
		<div>
			<h4>Alumno: RUIZ AGUILAR ÁNGEL SAMUEL </h4>
			<?php  
			$cuotas = 
				['Sep 2020',
				'Oct 2020',
				'Nov 2020',
				'Dic 2020',
				'Ene 2021',
				'Feb 2021',
				'Mar 2021',
				'Abr 2021',
				'May 2021',
				'Jun 2021',
				'Jul 2021'];
			?>
			<?= $this->Form->create() ?>
				<fieldset>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th scope="col">Nro.</th>
									<th scope="col">cuota</th>
									<th scope="col">$</th>
									<th scope="col">€</th>
									<th scope="col">Bs.</th>
									<th scope="col">Seleccionar</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($cuotas as $cuota): ?>
									<tr>
										<td>1</td>
										<td><?= $cuota ?></td>
										<td>45,00</td>
										<td>51,75</td>
										<td>16200000,00</td>
										<td><input type="checkbox"></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</fieldset>   
				<?= $this->Form->button(__('Pagar'), ['class' =>'btn btn-success', 'id' => 'pagar']) ?>
				<br />
				<br />
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<script>
    $(document).ready(function()
	{
    });
</script>