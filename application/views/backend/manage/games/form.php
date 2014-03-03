	<form id="form" action="" method="post" class="validate" enctype="multipart/form-data">
		<fieldset>
			<input type="hidden" name="id" value="<?=$data['id']?>" />
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h3><?=__('Generic data')?></h3>
			<label class="large">
				<span class="label"><?=__('Desarrollador')?></span>
                <select name="developer_id" class="required">
                	<option value="">- Seleccione -</option>
                    <?php foreach($developers as $row): ?>
                    <option value="<?=$row['id']?>" <?php if($row['id']==$data['developer_id']) { echo "selected";} ?>><?=$row['title']?></option>
                    <?php endforeach; ?>
                </select>
			</label>            
			<label class="large">
				<span class="label"><?=__('Title')?></span>
				<input type="text" name="title" value="<?=$data['title']?>" class="required" />
			</label>
			<label class="large">
				<span class="label"><?=__('Resumen')?></span>
				<textarea name="brief" cols="50" rows="4"><?=$data['brief']?></textarea>
			</label>
			<label class="large">
				<span class="label"><?=__('Resolución ancho')?> px</span>
				<input type="text" name="game_width" value="<?=$data['game_width']?>" />
			</label>
			<label class="large">
				<span class="label"><?=__('Reslución alto')?> px</span>
				<input type="text" name="game_height" value="<?=$data['game_height']?>" />
			</label>
			<label class="large">
				<span class="label"><?=__('Directorio base')?></span>
				<input type="text" name="base_path" value="<?=$data['base_path']?>" class="" />
			</label>
			<label class="large">
				<span class="label"><?=__('Archivo Juego')?></span>
				<input type="text" name="gamefile" value="<?=$data['gamefile']?>" class="" />
			</label>
			<label class="large">
				<span class="label"><?=__('Archivo Juego Inglés')?></span>
				<input type="text" name="gamefile_eng" value="<?=$data['gamefile_eng']?>" class="" />
			</label>                        
			<label class="left">
				<span class="label"><?php echo __('Image')?> (142x140 px)</span>
			</label>
			<div class="fileupldr upldr_imagename">
				<div class="thumb"><?=(strlen($data['imagename'])>0)?'<a href="../assets/files/games/images/'.$data['imagename'].'" target="_blank"><img src="../assets/files/games/images/thumb/'.$data['imagename'].'" /></a>':""?></div>
				<div class="uploadifyData">
					<div class="uploader">
						<input type="file" name="fileupload_1" value="" id="upldf_imagename" class="upldify image" folder="/games/images/" callback="show_delpic_options" />
					</div>
					<div class="fileDetail"><?=(strlen($data['imagename'])>0)?$data['imagename']:__('No file selected')?></div>
				</div>
				<div class="uploadProgress" id="queueID_<?=rand(1000,9999)?>"></div>
				<input type="hidden" name="imagename" id="imagename" value="<?=$data['imagename']?>" class="filename" />
			</div>
			<div class="note" id="showdel_imagename" style="display:<?=(strlen($data['imagename'])>0)?'block':'none';?>"><a href="#" id="del_imagename" class="delattach">Delete current Picture</a></div>
			<label class="left">
				<span class="label"><?php echo __('Image título')?> (202x78 px)</span>
			</label>
			<div class="fileupldr upldr_imagetop">
				<div class="thumb"><?=(strlen($data['imagetop'])>0)?'<a href="../assets/files/games/images/'.$data['imagetop'].'" target="_blank"><img src="../assets/files/games/images/thumb/'.$data['imagetop'].'" /></a>':""?></div>
				<div class="uploadifyData">
					<div class="uploader">
						<input type="file" name="fileupload_1" value="" id="upldf_imagetop" class="upldify image" folder="/games/images/" callback="show_delpic_options" />
					</div>
					<div class="fileDetail"><?=(strlen($data['imagetop'])>0)?$data['imagetop']:__('No file selected')?></div>
				</div>
				<div class="uploadProgress" id="queueID_<?=rand(1000,9999)?>"></div>
				<input type="hidden" name="imagetop" id="imagetop" value="<?=$data['imagetop']?>" class="filename" />
			</div>
			<div class="note" id="showdel_imagetop" style="display:<?=(strlen($data['imagetop'])>0)?'block':'none';?>"><a href="#" id="del_imagetop" class="delattach">Delete current Picture</a></div>
			<label class="left">
				<span class="label"><?php echo __('Image fondo')?> (805x434 px)</span>
			</label>
			<div class="fileupldr upldr_imageback">
				<div class="thumb"><?=(strlen($data['imageback'])>0)?'<a href="../assets/files/games/images/'.$data['imageback'].'" target="_blank"><img src="../assets/files/games/images/thumb/'.$data['imageback'].'" /></a>':""?></div>
				<div class="uploadifyData">
					<div class="uploader">
						<input type="file" name="fileupload_1" value="" id="upldf_imageback" class="upldify image" folder="/games/images/" callback="show_delpic_options" />
					</div>
					<div class="fileDetail"><?=(strlen($data['imageback'])>0)?$data['imageback']:__('No file selected')?></div>
				</div>
				<div class="uploadProgress" id="queueID_<?=rand(1000,9999)?>"></div>
				<input type="hidden" name="imageback" id="imageback" value="<?=$data['imageback']?>" class="filename" />
			</div>
			<div class="note" id="showdel_imageback" style="display:<?=(strlen($data['imageback'])>0)?'block':'none';?>"><a href="#" id="del_imageback" class="delattach">Delete current Picture</a></div>
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