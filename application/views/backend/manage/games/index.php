	<form id="filters" action="" method="get">
		<div class="actions">
			<a href="manage/<?=$controller?>/form" class="button"><span><?=__('Create new')?></span></a>
		</div>
		<fieldset class="hidden">
			<span id="csrf_token"><?=Security::token()?></span>
			<input type="hidden" name="page" value="" />
		</fieldset>
		<table class="data">
			<tr>
				<th><?=__('Juego')?></th>
				<th><?=__('Desarrollador')?></th>
				<th>Status</th>
				<th colspan="2" class="action"><?=__('Order')?></th>
				<th><?=__('Edit')?></th>
				<th><?=__('Delete')?></th>
			</tr>
			<?php foreach ($data as $page): ?>
			<tr>
				<td><?=$page['title']?></td>
				<td><?=$page['developer']?></td>
				<td><?=Lookup::name('status', $page['status'])?></td>
				<td class="action"><a href="manage/<?=$controller?>/sort?id=<?=$page['id']?>&position=up"><img src="../assets/images/backend/arrow_up.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action"><a href="manage/<?=$controller?>/sort?id=<?=$page['id']?>&position=down"><img src="../assets/images/backend/arrow_down.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action"><a href="manage/<?=$controller?>/form?id=<?=$page['id']?>"><img src="../assets/images/backend/pencil.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action delete"><a href="manage/<?=$controller?>/delete?id=<?=$page['id']?>"><img src="../assets/images/backend/delete.png" width="16" height="16" alt="Delete" /></a></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</form>