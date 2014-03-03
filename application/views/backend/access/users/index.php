	<form id="filters" action="" method="get">
		<div class="actions">
			<a href="access/users/form" class="button"><span><?=__('Create new')?></span></a>
		</div>
		<fieldset class="hidden">
			<span id="csrf_token"><?=Security::token()?></span>
			<input type="hidden" name="page" value="" />
			<input type="hidden" name="order_by" value="<?=$order_by?>" />
			<input type="hidden" name="sort" value="<?=$sort?>" />
		</fieldset>
		<table class="data">
			<tr>
				<th class="sortable" abbr="name"><?=__('Name')?></th>
				<th class="sortable" abbr="email"><?=__('Email')?></th>
				<th><?=__('Last login')?></th>
				<th class="sortable" abbr="is_active">Status</th>
				<th><?=__('Edit')?></th>
				<th><?=__('Delete')?></th>
			</tr>
			<?php foreach ($users as $user): ?>
			<tr>
				<td><?=$user['name']?></td>
				<td><?=$user['email']?></td>
				<td><?=Time::format('%e %h, %Y %H:%M', $user['last_login'])?></td>
				<td><?=Lookup::name('status', $user['status'])?></td>
				<td class="action"><a href="access/users/form?id=<?=$user['id']?>"><img src="../assets/images/backend/pencil.png" width="16" height="16" alt="Edit" /></a></td>
				<td class="action delete"><a href="access/users/delete?id=<?=$user['id']?>"><img src="../assets/images/backend/delete.png" width="16" height="16" alt="Delete" /></a></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</form>