	<form id="filters" action="" method="get">
		<div class="actions">
		<!--
			<a href="manage/<?=$controller?>/form" class="button"><span><?=__('Create new')?></span></a>
		-->
		</div>
		<fieldset class="hidden">
			<span id="csrf_token"><?=Security::token()?></span>
			<input type="hidden" name="page" value="" />
			<input type="hidden" name="order_by" value="<?=$order_by?>" />
			<input type="hidden" name="sort" value="<?=$sort?>" />
		</fieldset>
		<table class="data">
			<tr>
				<th><?=__('Name')?></th>
				<th>Status</th>
				<th><?=__('Detail')?></th>
				<th><?=__('Delete')?></th>
			</tr>
			<?php foreach ($dbdata as $dat): ?>
			<tr>
				<td><?=$dat['fullname'];?></td>
				<td><?=Lookup::name('status', $dat['status'])?></td>
				<td class="action view"><a href="manage/<?=$controller?>/details?id=<?=$dat['id']?>"><img src="../assets/images/backend/magnifier.png" width="16" height="16" alt="View" /></a></td>
				<td class="action delete"><a href="manage/<?=$controller?>/delete?id=<?=$dat['id']?>"><img src="../assets/images/backend/delete.png" width="16" height="16" alt="Delete" /></a></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</form>