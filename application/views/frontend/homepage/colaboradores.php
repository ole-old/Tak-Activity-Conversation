			<div class="grl_content">
				<h2><span>Colaboradores</span></h2>
				<ul class="colab">
		<?php
			foreach($colaboradores as $colab){
		?>
					<li>
						<div class="pic"><img src="<?=(strlen($colab['imagename'])>0)?"assets/files/colaboradores/".$colab['imagename']:"assets/images/frontend/pic_colab.png"?>" width="138" height="140" /></div>
						<div class="desc">
							<h4><?=$colab['nombre']?><br /><strong><?=$colab['puesto']?></strong></h4>
							<?=$colab['description']?>
						</div>
					</li>
		<?php
			}
		?>
				</ul>
			</div>
