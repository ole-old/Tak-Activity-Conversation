			<div class="grl_content">
				<h2><span>Talleres de interés</span></h2>
				<div>
					<?=$content['content']?>
				</div>
				<ul class="talleres">
		<?php
			foreach($talleres as $tall){
		?>
					<li>
						<h4><?=$tall['title']?></h4>
						<strong>MODULOS</strong>
						<?=$tall['content']?>
					</li>
		<?php
			}
		?>
				</ul>
				<div class="box_moreinfo">
					Comunicate con <strong>RECURSOS</strong> para mayor información<br />
					<span>Inscripciones al Tel. (+52.55) 52.08.81.90</span>
				</div>
			</div>
