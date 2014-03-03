	<form id="filters" action="" method="get">
		<div class="actions">
			<a href="manage/<?=$controller?>/form" class="button"><span><?=__('Create new')?></span></a>
		</div>
		<fieldset class="hidden">
			<span id="csrf_token"><?=Security::token()?></span>
			<input type="hidden" name="page" value="" />
			<input type="hidden" name="order_by" value="<?=$order_by?>" />
			<input type="hidden" name="sort" value="<?=$sort?>" />
		</fieldset>
		<table class="data">
			<tr>
				<th><?=__('Title')?></th>
				<th>Status</th>
				<th><?=__('Add')?></th>
				<th colspan="2" class="action"><?=__('Order')?></th>
				<th><?=__('Edit')?></th>
				<th><?=__('Delete')?></th>
			</tr>
			<?php foreach ($pages as $page): ?>
			<tr>
				<td class="level<?=$page['level']?>"><?=$page['title'];?></td>
				<td><?=Lookup::name('status', $page['status'])?></td>
				<td class="action"><?php if($page['parent_id']==NULL){ ?><a href="manage/<?=$controller?>/form?parent_id=<?=$page['id']?>"><img src="../assets/images/backend/add.png" width="16" height="16" alt="Edit" /></a><?php } else echo "&nbsp;"; ?></td>
				<td class="action"><a href="manage/<?=$controller?>/sort?id=<?=$page['id']?>&parent_id=<?=$page['parent_id']?>&position=up"><img src="../assets/images/backend/arrow_up.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action"><a href="manage/<?=$controller?>/sort?id=<?=$page['id']?>&parent_id=<?=$page['parent_id']?>&position=down"><img src="../assets/images/backend/arrow_down.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action"><a href="manage/<?=$controller?>/form?id=<?=$page['id']?>&parent_id=<?=$page['parent_id']?>"><img src="../assets/images/backend/pencil.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action delete"><a href="manage/<?=$controller?>/delete?id=<?=$page['id']?>"><img src="../assets/images/backend/delete.png" width="16" height="16" alt="Delete" /></a></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</form>