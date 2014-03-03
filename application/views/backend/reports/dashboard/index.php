	<div class="overview">
		<p class="welcome">
			<?=__('Welcome to the administration interface for the site website.')?> <br />

		</p>
		<div class="left">
			<form name="filter_dashboard" id="filter_dashboard" method="get">
				<div class="filter date">
					<label>Rango fechas</label>
					<input type="text" name="date_start" class="date" value="<?=$params['date_start']?>" />
					<input type="text" name="date_end" class="space date" value="<?=$params['date_end']?>" />
				</div>
				<div class="filter">
                	<input type="submit" value="Buscar" class="submit"></button>
                </div>
			</form>	
		</div>
		<br style="clear: both" />
		<div class="left">
			<h3 class="left"><?=__('Información del sitio')?></h3>
			<table class="zebra">
				<tr>
					<th>Item</th>
					<th><?=__('Valor')?></th>
				</tr>
				<?php foreach($site_info as $row) { ?>
                <tr>
					<td><?=$row['key']?></td>
					<td><?=$row['val']?></td>
				</tr>
                <?php } ?>
			</table>
		</div> 
     <!--  <br style="clear: both" /> -->
		<div class="right">
			<h3>Top 5 más jugados</h3>
			<table class="zebra">
				<tr>
                    <th>Juego</th>
                    <th style="text-align:center">Veces jugadas</th>
				</tr>
				<?php foreach($top_games as $row) { ?>
                <tr>
					
					<td><?=$row['title']?></td>
					<td style="text-align:center"><?=$row['total']?></td>
				</tr>
                <?php } ?>
			</table>
		</div>
		<br style="clear: both" />
		<div class="left">
			<h3>Top 5 menos jugados</h3>
			<table class="zebra">
				<tr>
                    <th>Juego</th>
                    <th style="text-align:center">Veces jugadas</th>
				</tr>
				<?php foreach($top_games2 as $row) { ?>
                <tr>
					
					<td><?=$row['title']?></td>
					<td style="text-align:center"><?=$row['total']?></td>
				</tr>
                <?php } ?>
			</table>
		</div>
		<div class="right">
			<h3>Jugadores con más puntos</h3>
			<table class="zebra">
				<tr>
                    <th>Jugador</th>
                    <th style="text-align:center">Score Total</th>
				</tr>
				<?php foreach($top_points as $row) { ?>
                <tr>
					
					<td><?=$row['usuario']?></td>
					<td style="text-align:center"><?=$row['total']?></td>
				</tr>
                <?php } ?>
			</table>
		</div>
		<br style="clear: both" />
		<div class="left">
			<h3>Top jugadores</h3>
			<table class="zebra">
				<tr>
                    <th>Jugador</th>
                    <th style="text-align:center">Veces jugadas</th>
				</tr>
				<?php foreach($top_played as $row) { ?>
                <tr>
					
					<td><?=$row['usuario']?></td>
					<td style="text-align:center"><?=$row['total']?></td>
				</tr>
                <?php } ?>
			</table>
		</div>

	</div>
	