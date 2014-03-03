			<div class="grl_content news">
				<div class="newsslider">
					<ul id="newsslider">
			<?php
				$i=0;
				foreach($news as $nws){
					echo '<li '.(($i==0)?'class="active"':'').'><img src="assets/files/news/'.$nws['imagename'].'" width="300" height="435" /></li>';
					$i++;
				}
			?>
					</ul>
					<ul id="newsctrl"></ul>
				</div>
				<h2><span>Noticias</span></h2>
				<ul id="newscont">
			<?php
				$i=0;
				foreach($news as $nws){
					echo '<li '.(($i==0)?'class="active"':'').'>'.$nws['content'].'</li>';
					$i++;
				}
			?>
					
				</ul>
			</div>
