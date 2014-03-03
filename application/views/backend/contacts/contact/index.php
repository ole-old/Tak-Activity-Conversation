	<form id="filters" action="" method="get">
		<div class="actions">
			<a href="contacts/contact/export" class="button" target="_blank"><span><?=__('Exportar a Excel')?></span></a>
		</div>
		<fieldset class="hidden">
			<span id="csrf_token"><?=Security::token()?></span>
			<input type="hidden" name="page" value="" />
		</fieldset>
		<table class="data">
			<tr>
				<th><?=__('Nombre')?></th>
				<th><?=__('Email')?></th>
				<th><?=__('Fecha')?></th>
				<th><?=__('Detalle')?></th>
			</tr>
			<?php foreach ($data as $page): ?>
			<tr>
				<td><?=$page['fullname']?></td>
				<td><?=$page['email']?></td>
				<td><?=$page['datereg']?></td>
				<td class="action view"><a href="contacts/contact/details?id=<?=$page['id']?>"><img src="../assets/images/backend/magnifier.png" width="16" height="16" alt="View" /></a></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</form>