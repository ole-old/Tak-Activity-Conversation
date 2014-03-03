<form id="login" action="" method="post" class="validate">
	<fieldset class="login">
		<label>
			<span><?=__('Username / Email')?></span>
			<input type="text" name="email" value="<?=$email?>" class="required email" />
		</label>
		<label>
			<span><?=__('Password')?></span>
			<input type="password" name="password" class="required" />
		</label>
		<label class="option">
			<a href="start/session/password"><?=__('Forgot your password?')?></a>
		</label>
		<button type="submit" class="submit"><span><?=__('Continue')?></span></button>
	</fieldset>
	<?php if ( ! $success): ?>
	<div class="message"><div class="warning"><?=__('The username/password combination is incorrect')?></div></div>
	<?php endif; ?>
	<p></p>
</form>