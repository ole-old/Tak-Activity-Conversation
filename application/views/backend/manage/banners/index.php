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
				<th><?=__('Banner')?></th>
                <th><?=__('Type')?></th>
				<th>Status</th>
				<th colspan="2" class="action"><?=__('Order')?></th>
				<th><?=__('Edit')?></th>
				<th><?=__('Delete')?></th>
			</tr>
			<?php foreach ($data as $row): ?>
			<tr>
				<td><?=$row['title']?></td>
                <td><?=$row['type']?></td>
				<td><?=Lookup::name('status', $row['status'])?></td>
				<td class="action"><a href="manage/<?=$controller?>/sort?id=<?=$row['id']?>&position=up&type_id=<?=$row['type_id']?>"><img src="../assets/images/backend/arrow_up.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action"><a href="manage/<?=$controller?>/sort?id=<?=$row['id']?>&position=down&type_id=<?=$row['type_id']?>"><img src="../assets/images/backend/arrow_down.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action"><a href="manage/<?=$controller?>/form?id=<?=$row['id']?>"><img src="../assets/images/backend/pencil.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action delete"><a href="manage/<?=$controller?>/delete?id=<?=$row['id']?>"><img src="../assets/images/backend/delete.png" width="16" height="16" alt="Delete" /></a></td>
			</tr>
			<?php endforeach; ?>
		</table>
        <p>&nbsp;</p>
		<table class="data">
			<tr>
				<th><?=__('Banner')?></th>
                <th><?=__('Type')?></th>
				<th>Status</th>
				<th colspan="2" class="action"><?=__('Order')?></th>
				<th><?=__('Edit')?></th>
				<th><?=__('Delete')?></th>
			</tr>
			<?php foreach ($data2 as $row): ?>
			<tr>
				<td><?=$row['title']?></td>
                <td><?=$row['type']?></td>
				<td><?=Lookup::name('status', $row['status'])?></td>
				<td class="action"><a href="manage/<?=$controller?>/sort?id=<?=$row['id']?>&position=up&type_id=<?=$row['type_id']?>"><img src="../assets/images/backend/arrow_up.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action"><a href="manage/<?=$controller?>/sort?id=<?=$row['id']?>&position=down&type_id=<?=$row['type_id']?>"><img src="../assets/images/backend/arrow_down.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action"><a href="manage/<?=$controller?>/form?id=<?=$row['id']?>"><img src="../assets/images/backend/pencil.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action delete"><a href="manage/<?=$controller?>/delete?id=<?=$row['id']?>"><img src="../assets/images/backend/delete.png" width="16" height="16" alt="Delete" /></a></td>
			</tr>
			<?php endforeach; ?>
		</table>        
	</form>