	<form id="form" action="/admin/start/settings/index" method="post" class="validate">
		<fieldset>
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h3>Website</h3>
			<label class="large">
				<span class="label">Google analytics</span>
				<textarea name="google_analytics" cols="50" rows="2"><?=$setting['google_analytics']?></textarea>
			</label>
			<label class="large">
				<span class="label"><?=__('Facebook link')?></span>
				<input type="text" name="facebook_link" value="<?=$setting['facebook_link']?>" />
			</label>
			<label class="large">
				<span class="label"><?=__('Twitter link')?></span>
				<input type="text" name="twitter_link" value="<?=$setting['twitter_link']?>" />
			</label>
			<label class="large">
				<span class="label"><?=__('Contact email')?></span>
				<input type="text" name="contact_email" value="<?=$setting['contact_email']?>" />
			</label>
		</fieldset>
		<fieldset>
			<div class="buttons">
				<?php  /*if ($setting['id'] AND $setting['log_user']): ?><p class="log">Last modified <strong><?=strftime('%e %h, %Y %H:%M', $setting['log_timestamp'])?></strong> by <strong><?=$setting['log_user']?></strong></p><?php endif; */ ?>
				<button type="submit" class="submit"><span><?=__('Update')?></span></button>
			</div>
		</fieldset>
	</form>