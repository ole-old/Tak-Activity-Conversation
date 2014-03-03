	<form id="filters" action="" method="get">
		<div class="actions">
			<a href="manage/<?=$controller?>/form" class="button"><span><?=__('Create new')?></span></a>
		</div>
		<fieldset class="filters">
			<label style="width: 250px;"><span><?=__('Típo')?></span>
				<select name="id_type" style="width: 250px;">
					<option value="0">- Seleccione -</option>
					<option value="1" <?=(($id_type == 1)?'selected="selected"':'')?>>Cursos de Investigación</option>
					<option value="2" <?=(($id_type == 2)?'selected="selected"':'')?>>Habilidades Gerenciales</option>
				</select>
			</label>
			<button type="submit" class="submit"><span>Filtrar</span></button>
		</fieldset>
		<fieldset class="hidden">
			<span id="csrf_token"><?=Security::token()?></span>
			<input type="hidden" name="page" value="" />
		</fieldset>
		<table class="data">
			<tr>
				<th><?=__('Title')?></th>
				<th><?=__('Date')?></th>
				<th><?=__('Duration')?></th>
				<th>Status</th>
				<th><?=__('Edit')?></th>
				<th><?=__('Delete')?></th>
			</tr>
			<?php foreach ($data as $page): ?>
			<tr>
				<td><?=$page['title']?></td>
				<td><?=$page['eventdate']?></td>
				<td><?=$page['duration']?></td>
				<td><?=Lookup::name('status', $page['status'])?></td>
				<td class="action"><a href="manage/<?=$controller?>/form?id=<?=$page['id']?>"><img src="../assets/images/backend/pencil.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action delete"><a href="manage/<?=$controller?>/delete?id=<?=$page['id']?>"><img src="../assets/images/backend/delete.png" width="16" height="16" alt="Delete" /></a></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</form>