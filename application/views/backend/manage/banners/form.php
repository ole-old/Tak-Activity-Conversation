	<form id="form" action="" method="post" class="validate" enctype="multipart/form-data">
		<fieldset>
			<input type="hidden" name="id" value="<?=$data['id']?>" />
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h3><?=__('Generic data')?></h3>
			<label class="large">
				<span class="label"><?=__('Tipo')?></span>
				<select name="type_id" class="required">
                	<option value="">- Seleccione -</option>
                    <?php foreach($banner_types as $row): ?>
                    <option value="<?=$row['id']?>" <?php if($data['type_id']==$row['id']) { echo "selected"; } ?>><?=$row['title']?></option>
                    <?php endforeach; ?>
                </select>
			</label>            
			<label class="large">
				<span class="label"><?=__('Title')?></span>
				<input type="text" name="title" value="<?=$data['title']?>" class="required" />
			</label>
			<label class="large">
				<span class="label"><?=__('Url')?></span>
				<input type="text" name="url" value="<?=$data['url']?>" class="required" />
			</label>            
			<label class="left">
				<span class="label"><?php echo __('Image')?> (893x362 | 416x136 px)</span>
			</label>
			<div class="fileupldr upldr_imagename">
				<div class="thumb"><?=(strlen($data['imagename'])>0)?'<a href="../assets/files/banners/'.$data['imagename'].'" target="_blank"><img src="../assets/files/banners/thumb/'.$data['imagename'].'" /></a>':""?></div>
				<div class="uploadifyData">
					<div class="uploader">
						<input type="file" name="fileupload_1" value="" id="upldf_imagename" class="upldify image" folder="/banners/" callback="show_delpic_options" />
					</div>
					<div class="fileDetail"><?=(strlen($data['imagename'])>0)?$data['imagename']:__('No file selected')?></div>
				</div>
				<div class="uploadProgress" id="queueID_<?=rand(1000,9999)?>"></div>
				<input type="hidden" name="imagename" id="imagename" value="<?=$data['imagename']?>" class="filename" />
			</div>
			<div class="note" id="showdel_imagename" style="display:<?=(strlen($data['imagename'])>0)?'block':'none';?>"><a href="#" id="del_imagename" class="delattach">Delete current Picture</a></div>
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
				<?php if ($data['id']): ?><a href="manage/<?=$controller?>/delete" class="delete"><span><?=__('Delete')?></span></a><?php endif; ?>
				<button type="submit" class="submit"><span><?=__('Save')?></span></button>
			</div>
		</fieldset>
	</form>