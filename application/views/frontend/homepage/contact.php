			<div class="grl_content">
				<h2><span><?=$content['title']?></span></h2>
				<div class="contact_map">
					<iframe width="460" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps/ms?msa=0&amp;msid=215508113178099405829.0004d46f105d3914f6991&amp;ie=UTF8&amp;t=m&amp;ll=19.420439,-99.166578&amp;spn=0.00253,0.004925&amp;z=17&amp;output=embed"></iframe>
				</div>
				<form class="contact" method="post" action="">
					<div>
						<?=$content['content']?>
					</div>
			<?php
				if(!$sent){
			?>
					<h4>DUDAS Y SUGERENCIAS</h4>
					<label>
						<span>Nombre</span>
						<input type="text" name="fullname" value="" />
					</label>
					<label>
						<span>Mail</span>
						<input type="text" name="email" value="" />
					</label>
					<label>
						<span>Mensaje</span>
						<textarea name="message"></textarea>
					</label>
					<button type="submit"><img src="assets/images/frontend/btn_send.png" width="85" height="35" /></button>
			<?php
				} else {
			?>
					<h4>GRACIAS</h4>
					<p>Sus datos se han enviado correctamente.</p>
			<?php
				}
			?>
				</form>
			</div>
