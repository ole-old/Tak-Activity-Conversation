<?php if($the_action == 'report'): ?>	

<table class="zebra">
				<tr>
                    <th style="text-align:center">Juego</th>
                    <th style="text-align:center">Desarrollador</th>
                    <th style="text-align:center">Total de usuarios</th>
                    <th style="text-align:center">Tiempo (seg)</th>
                    <th style="text-align:center">Score</th>
                    <th style="text-align:center">Veces&nbsp;jugadas</th>
				</tr>
				<?php foreach($data as $row) { ?>
                <tr>
					
					<td><?=$row['game']?></td>
					<td style="text-align:center"><?=$row['developer']?></td>
					<td style="text-align:center"><?=$row['jugadores']?></td>
                    <td style="text-align:center"><?=$row['tot_time']?></td>
                    <td style="text-align:center"><?=$row['tot_score']?></td>
                    <td style="text-align:center"><?=$row['num_games']?></td>
				</tr>
                <?php } ?>
			</table>



<?php else: ?>
<script type="text/javascript">
$(document).ready(function() {


	$("#reporte").click(function() {
		$('#filters_player').attr('action', 'reports/game/report');
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	
	$("#game_asc").click(function(){
		$('#order_by').val("game ASC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#game_desc").click(function(){
		$('#order_by').val("game DESC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#dev_asc").click(function(){
		$('#order_by').val("developer ASC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#dev_desc").click(function(){
		$('#order_by').val("developer DESC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#score_asc").click(function(){
		$('#order_by').val("tot_score ASC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#score_desc").click(function(){
		$('#order_by').val("tot_score DESC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#time_asc").click(function(){
		$('#order_by').val("tot_time ASC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#time_desc").click(function(){
		$('#order_by').val("tot_time DESC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#num_asc").click(function(){
		$('#order_by').val("num_games ASC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#num_desc").click(function(){
		$('#order_by').val("num_games DESC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#users_asc").click(function(){
		$('#order_by').val("jugadores ASC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
	$("#users_desc").click(function(){
		$('#order_by').val("jugadores DESC");
		$('#filters_player').submit();
		$('#filters_player').attr('action', '');
	});
});
</script>
	<div class="overview">
		<p class="welcome">
			<?=__('Reporte de Juegos')?> <br />
            <form name="filters_player"  id="filters_player" method="get">
	            <input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
	            <input type="hidden" name="page" id="page" value="<?=$page?>" />
				<input type="hidden" name="order_by" id="order_by" value="" />
            	<div class="filter">
                    <label>Estado</label>
                    <select name="state_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($states as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['state_id']) { echo "selected"; } ?>><?=$row['name']?></option>
                        <?php endforeach; ?> 
                    </select>
                </div>
            	<div class="filter date">
                    <label>Rango fechas</label>
                    <input type="text" name="date_start" class="date" value="<?=$params['date_start']?>" />
                    <input type="text" name="date_end" class="space date" value="<?=$params['date_end']?>" />
                </div>
            	<div class="filter">
                    <label>Desarrollador</label>
                    <select name="developer_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($developers as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['developer_id']) { echo "selected"; } ?>><?=$row['title']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            	<div class="filter">
                    <label>Juego</label>
                    <select name="game_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($games as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['game_id']) { echo "selected"; } ?>><?=$row['title']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            	<div class="filter">
                    <label>Grado escolar</label>
                    <select name="school_year_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($school_years as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['school_year_id']) { echo "selected"; } ?>><?=$row['school_year']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            	<div class="filter">
                    <label>Materia</label>
                    <select name="asignature_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($asignatures as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['asignature_id']) { echo "selected"; } ?>><?=$row['asignature']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            	<div class="filter">
                    <label>Actividad favorita</label>
                    <select name="activity_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($activities as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['activity_id']) { echo "selected"; } ?>><?=$row['activity']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            	<div class="filter">
                    <label>Como te enteraste</label>
                    <select name="how_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($how_id as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['how_id']) { echo "selected"; } ?>><?=$row['how']?></option>
                        <?php endforeach; ?> 
                    </select>
                </div>
            	<div class="filter">
                    <label>Género</label>
                    <select name="gender">
                        <option value="">- Seleccione -</option>
                        <option value="1" <?php if($params['gender']==1) { echo "selected"; } ?>>niño</option>
                        <option value="2" <?php if($params['gender']==2) { echo "selected"; } ?>>niña</option>
                        <option value="3" <?php if($params['gender']==3) { echo "selected"; } ?>>adulto</option>
                    </select>
                </div>
            	<div class="filter">
                    <label>Campaña origen</label>
                    <select name="source_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($source_id as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['source_id']) { echo "selected"; } ?>><?=$row['source']?></option>
                        <?php endforeach; ?> 
                    </select>
                </div>
                 <div class="filter">
                   <label>Sub Origen</label>
                    <select name="location_id">
                        <option value="">- Seleccione -</option>
                        <?php foreach($location_id as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($row['id']==$params['location_id']) { echo "selected"; } ?>><?=$row['location']?></option>
                        <?php endforeach; ?> 
                    </select>
                </div>
                <div class="filter">

                	<input type="submit" value="Buscar" class="submit">
			
                </div>            
            </form>
			
		    <div class="filter"><input type="button" id="reporte" name="reporte" value="Exportar reporte" class="submit"></div>
			
		</p>
        <p style="width: 100%; height: 20px;float: left;">&nbsp;</p>
		
		<input type="hidden" name="order_by1" id="order_by1" value="" />
		
		<div style="float: left; width: 900px;">
			<!--<h3><?=__('Información del sitio')?></h3>-->
			<table class="zebra">
				<?echo $page_links;?>
				<tr>
                    <th>Juego<img align="right" src="../assets/images/backend/bullet_arrow_down.png" id="game_desc"/><img id="game_asc" align="right" src="../assets/images/backend/bullet_arrow_up.png" /></th>
                    <th>Desarrollador<img align="right" src="../assets/images/backend/bullet_arrow_down.png" id="dev_desc" /><img id="dev_asc" align="right" src="../assets/images/backend/bullet_arrow_up.png" /></th>
                    <th style="text-align:center">Total de usuarios<img align="right" src="../assets/images/backend/bullet_arrow_down.png" id="users_desc" /><img id="users_asc" align="right" src="../assets/images/backend/bullet_arrow_up.png" /></th>
                    <th style="text-align:center">Tiempo (seg)<img align="right" src="../assets/images/backend/bullet_arrow_down.png" id="time_desc" /><img id="time_asc" align="right" src="../assets/images/backend/bullet_arrow_up.png" /></th>
                    <th style="text-align:center">Score<img align="right" src="../assets/images/backend/bullet_arrow_down.png" id="score_desc" /><img id="score_asc" align="right" src="../assets/images/backend/bullet_arrow_up.png" /></th>
                    <th style="text-align:center">Veces&nbsp;jugadas<img align="right" src="../assets/images/backend/bullet_arrow_down.png" id="num_desc" /><img id="num_asc" align="right" src="../assets/images/backend/bullet_arrow_up.png" /></th>
				</tr>
				<?php foreach($data as $row) { ?>
                <tr>
					
					<td><?=$row['game']?></td>
					<td><?=$row['developer']?></td>
					<td style="text-align:center"><?=$row['jugadores']?></td>
                    <td style="text-align:center"><?=$row['tot_time']?></td>
                    <td style="text-align:center"><?=$row['tot_score']?></td>
                    <td style="text-align:center"><?=$row['num_games']?></td>
				</tr>
                <?php } ?>
			</table>
		</div>
	</div>
	
<?php endif; ?>
	
