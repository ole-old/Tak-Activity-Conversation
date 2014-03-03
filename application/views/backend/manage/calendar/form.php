	<form id="form" action="" method="post" class="validate" enctype="multipart/form-data">
		<fieldset>
			<input type="hidden" name="id" value="<?=$data['id']?>" />
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h3><?=__('Generic data')?></h3>
			<label class="left">
				<span class="label"><?=__('Típo')?></span>
				<select name="id_type" class="required">
					<option value="0">- Seleccione -</option>
					<option value="1" <?=(($data['id_type'] == 1)?'selected="selected"':'')?>>Cursos de Investigación</option>
					<option value="2" <?=(($data['id_type'] == 2)?'selected="selected"':'')?>>Habilidades Gerenciales</option>
				</select>
			</label>
			<label class="large">
				<span class="label"><?=__('Title')?></span>
				<input type="text" name="title" value="<?=$data['title']?>" class="required" />
			</label>
			<label class="left">
				<span class="label"><?=__('Date')?></span>
				<input type="text" name="eventdate" value="<?=$data['eventdate']?>" class="required date" />
			</label>
			<label class="right">
				<span class="label"><?=__('Duración')?></span>
				<select name="duration" class="required">
					<option value="0">- Seleccione -</option>
		<?php
			for($i=1; $i<51; $i++)
				echo '<option value="'.$i.'" '.(($data['duration']==$i)?'selected="selected"':'').'>'.$i.' '.(($i==1)?'día':'días').'</option>';
		?>
				</select>
			</label>
			<div class="options">
				<span class="label">Status</span>
				<?php foreach ($status as $s): ?>
				<label><input type="radio" name="status" value="<?=$s['code']?>"<?php if (Arr::get($data, 'status', 1)==$s['code']): ?> checked="checked"<?php endif; ?> /> <?=$s['name']?></label>
				<?php endforeach; ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="buttons">
				<?php if ($data['id'] AND $data['log_user']): ?>
				<p class="log"><?=__('Last modified <strong>:timestamp</strong> by <strong>:user</strong>', array(':timestamp' => Time::format('%e %h, %Y %H:%M', $data['log_timestamp']), ':user' => $data['log_user']))?></p>
				<?php endif; ?>
				<a href="#" class="cancel"><span><?=__('Cancel')?></span></a>
				<?php if ($data['id']): ?><a href="manage/homepage/delete" class="delete"><span><?=__('Delete')?></span></a><?php endif; ?>
				<button type="submit" class="submit"><span><?=__('Save')?></span></button>
			</div>
		</fieldset>
	</form>