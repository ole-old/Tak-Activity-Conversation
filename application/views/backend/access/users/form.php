	<form id="form" action="" method="post" class="validate">
		<fieldset>
			<input type="hidden" name="id" value="<?=$user['id']?>" />
			<input type="hidden" name="o_email" value="<?=$user['o_email']?>" />
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h3><?=__('Generic data')?></h3>
			<label>
				<span class="label"><?=__('Name')?></span>
				<input type="text" name="name" value="<?=$user['name']?>" class="required" />
			</label>
			<label class="left">
				<span class="label"><?=__('Email')?></span>
				<input type="text" name="email" value="<?=$user['email']?>" class="required email" />
				<span class="note"><?=__('This will be used as your username')?></span>
			</label>
			<label class="right">
				<span class="label"><?=__('Password')?></span>
				<input type="password" name="password"<?php if (empty($user['id'])): ?> class="required"<?php endif; ?> />
				<?php if ($user['id']): ?><span class="note"><?=__('Please leave it blank if you want to keep the same password')?></span><?php endif; ?>
			</label>
			<div class="options">
				<span class="label">Status</span>
				<?php foreach ($status as $s): ?>
				<label><input type="radio" name="status" value="<?=$s['code']?>"<?php if (Arr::get($user, 'status', 1)==$s['code']): ?> checked="checked"<?php endif; ?> /> <?=$s['name']?></label>
				<?php endforeach; ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="buttons">
				<?php if ($user['id'] AND $user['log_user']): ?>
				<p class="log"><?=__('Last modified <strong>:timestamp</strong> by <strong>:user</strong>', array(':timestamp' => Time::format('%e %h, %Y %H:%M', $user['log_timestamp']), ':user' => $user['log_user']))?></p>
				<?php endif; ?>
				<a href="#" class="cancel"><span><?=__('Cancel')?></span></a>
				<?php if ($user['id']): ?><a href="access/users/delete" class="delete"><span><?=__('Delete')?></span></a><?php endif; ?>
				<button type="submit" class="submit"><span><?=__('Save')?></span></button>
			</div>
		</fieldset>
	</form>