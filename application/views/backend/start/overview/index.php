	<div class="overview">
		<p class="welcome">
			<?=__('Welcome to the administration interface for the :site website.', array(':site' => $site_title))?> <br />
		</p>
		<div class="left">
			<h3><?=__('Recent activity')?></h3>
			<table class="zebra">
				<tr>
					<th><?=__('Module')?></th>
					<th>Item</th>
					<th><?=__('Date')?></th>
					<th><?=__('Action')?></th>
				</tr>
				<?php foreach($transactions as $transaction): ?>
				<tr>
					<td><?=$transaction['module_name']?></td>
					<td><?=$transaction['object_name']?></td>
					<td><?=date('d.m.y H:i', $transaction['timestamp'])?></td>
					<td><?=Lookup::name('activity', $transaction['action'])?></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<h3><?=__('Login history')?></h3>
			<table class="zebra">
				<tr>
					<th><?=__('Browser')?></th>
					<th>IP</th>
					<th><?=__('Date')?></th>
					<th><?=__('Action')?></th>
				</tr>
				<?php foreach($sessions as $session): ?>
				<tr>
					<td><?=Request::browser($session['user_agent'])?></td>
					<td><?=$session['remote_address']?></td>
					<td><?=Time::format('%d.%m.%y %H:%M', $session['timestamp'])?></td>
					<td><?=Lookup::name('session', $session['action'])?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	<!--
		<div class="right">
			<h3><?=__('Latest Filmide')?></h3>
			<a href="manage/filmide/index"><?=__('Manage Filmide')?></a>
		</div>
	-->
	</div>
	