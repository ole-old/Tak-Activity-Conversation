	<form id="form" action="" method="post" class="validate">
		<fieldset>
			<input type="hidden" name="id" value="<?=$page['id']?>" />
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h3><?=__('Generic data')?></h3>
			<?php if($parent_id): ?>
			<label>
				<span class="label"><?=__('Section')?></span>
				<select name="parent_id" class="required">
					<option value=""><?=__('- Select -')?></option>
					<?php foreach($sections as $section): ?>
					<option value="<?=$section['id']?>"<?php if($section['id']==$parent_id): ?> selected="selected"<?php endif; ?>><?=$section['title']?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<?php endif; ?>
			<label class="large">
				<span class="label"><?=__('Title')?></span>
				<input type="text" name="title" value="<?=$page['title']?>" class="required" />
			</label>
			<label class="large">
				<span class="label"><?=__('Content')?></span>
				<div class="richtext"><textarea name="content" class="ckeditor" cols="50" rows="5" style="width: 800px; height: 400px;"><?=$page['content']?></textarea></div>
			</label>
			<label class="large">
				<span class="label"><?=__('Redirect')?></span>
				<input type="text" name="redirect_to" value="<?=$page['redirect_to']?>" />
			</label>
			<div class="options">
				<span class="label">Status</span>
				<?php foreach ($status as $s): ?>
				<label><input type="radio" name="status" value="<?=$s['code']?>"<?php if (Arr::get($page, 'status', 1)==$s['code']): ?> checked="checked"<?php endif; ?> /> <?=$s['name']?></label>
				<?php endforeach; ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="buttons">
				<?php if ($page['id'] AND $page['log_user']): ?>
				<p class="log"><?=__('Last modified <strong>:timestamp</strong> by <strong>:user</strong>', array(':timestamp' => Time::format('%e %h, %Y %H:%M', $page['log_timestamp']), ':user' => $page['log_user']))?></p>
				<?php endif; ?>
				<a href="#" class="cancel"><span><?=__('Cancel')?></span></a>
				<?php if ($page['id']): ?><a href="manage/<?=$controller?>/delete" class="delete"><span><?=__('Delete')?></span></a><?php endif; ?>
				<button type="submit" class="submit"><span><?=__('Save')?></span></button>
			</div>
		</fieldset>
	</form>