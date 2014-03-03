	<form id="form" action="" method="post" class="validate" enctype="multipart/form-data">
		<fieldset>
			<input type="hidden" name="id" value="<?=$data['id']?>" />
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h3><?=__('Generic data')?></h3>
			<label class="large">
				<span class="label"><?=__('Section')?></span>
				<select name="id_section" class="required">
					<option value="0">- Seleccione -</option>
			<?php
				foreach($sections as $dat)
					echo '<option value="'.$dat['id'].'" '.(($dat['id']==$data['id_section'])?'selected="selected"':'').'>'.$dat['title'].'</option>';
			?>
					<option value="1000" <?=(($data['id_section'] == 1000)?'selected="selected"':'')?>>Contacto</option>
				</select>
			</label>
			<label class="large">
				<span class="label"><?=__('Title')?></span>
				<input type="text" name="title" value="<?=$data['title']?>" class="required" />
			</label>
			<label>
				<span class="label"><?=__('Content')?></span>
				<textarea name="content"><?=$data['content']?></textarea>
			</label>
			<label class="left">
				<span class="label"><?=__('Image')?></span>
			</label>
			<div class="image" id="mainimg_uploaded">
				<div class="thumb"><?=(strlen($data['imagename'])>0)?'<a href="../assets/files/banners/'.$data['imagename'].'" target="_blank"><img src="../assets/files/banners/thumb/'.$data['imagename'].'" width="68" height="68" /></a>':""?></div>
				<div class="uploadifyData">
					<div class="uploader">
						<input type="file" name="imagenameasd" value="" id="bannerimgupload" />
					</div>
					<div class="fileDetail"><?=(strlen($data['imagename'])>0)?$data['imagename']:"No se ha seleccionado imágen"?></div>
				</div>
				<div class="uploadProgress" id="SD23fds_queueID"></div>
				<input type="hidden" name="imagename" id="imagename" value="<?=$data['imagename']?>" />
			</div>
			<label class="large">
				<span class="label"><?=__('Link')?></span>
				<input type="text" name="link" value="<?=$data['link']?>" />
			</label>
			<div class="options">
				<span class="label"><?php echo __('New window')?></span>
				<?php foreach ($yesno as $s): ?>
				<label><input type="radio" name="newwin" value="<?php echo $s['code']?>"<?php if (Arr::get($data, 'newwin', 0)==$s['code']): ?> checked="checked"<?php endif; ?> /> <?php echo $s['name']?></label>
				<?php endforeach; ?>
			</div>
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
				<?php if ($data['id']): ?><a href="manage/banners/delete" class="delete"><span><?=__('Delete')?></span></a><?php endif; ?>
				<button type="submit" class="submit"><span><?=__('Save')?></span></button>
			</div>
		</fieldset>
	</form>