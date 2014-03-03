		<div id="content">
			<h1><?=$page['title']?></h1>
			<div class="like">
				<iframe src="http://www.facebook.com/plugins/like.php?href=<?=urlencode('http://'.$_SERVER['SERVER_NAME'].'/'.$_SERVER['REQUEST_URI'])?>&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
			</div>
			<div id="branches">
				<h3>Pica para ver los detalles y ubicación</h3>
				<ul class="columns-6">
					<?php foreach($branches as $branch): ?>
					<li><a href="sucursales#!<?=$branch['slug']?>"><?=$branch['name']?><?php if($branch['is_mini']): ?><sup>(mini)</sup><?php endif; ?></a></li>
					<?php endforeach; ?>
				</ul>
				<p class="note"><?=utf8_encode('* Las mini sucursales tienen menú reducido.')?></p>
			</div>
			<div id="branch">
				<div id="map"></div>
				<div class="details"></div>
				<div class="content">
					<?=$page['content']?>
				</div>
			</div>
		</div>