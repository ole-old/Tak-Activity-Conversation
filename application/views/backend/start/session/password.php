<form id="login" action="" method="post" class="validate small">
	<fieldset class="login">
		<label class="big">
			<span><?=__('Please enter you Email address and we will email you a new password')?></span>
			<input type="text" name="email" value="<?=$email?>" class="required email" />
		</label>
		<label class="option">
			<a href="start/session/login"><?=__('Login')?></a>
		</label>
		<button type="submit" class="submit"><span><?=__('Continue')?></span></button>
	</fieldset>
	<?php if ($success && $sent): ?>
	<div class="message"><div class="success"><?=__('Your new password has been sent to you email address')?></div></div>
	<?php endif; ?>
	<?php if ( ! $success): ?>
	<div class="message"><div class="warning"><?=__('Username does not exist')?></div></div>
	<?php endif; ?>
</form>