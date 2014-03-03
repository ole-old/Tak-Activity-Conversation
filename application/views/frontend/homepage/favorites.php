    <div class="tak_contenido_perfil" style="min-height: 800px;">
    	<div class="tak_avatarmenu">
        	<div class="tak_avatarcontenido">
                <img src="assets/images/frontend/<?=$player_data['avatar']?>" />
            </div>
            <h1><?=$player_data['username']?></h1>
            <ul>
            	<li id="tak_perfilactivo"><a href="favoritos">Favoritos</a></li>
                <li><a href="mi_perfil">Mi perfil</a></li>
            
            </ul>	
        </div>
        		
       <?php $ind = 0; foreach($games as $row): ?>
       
       <?php if($ind % 4 == 0): ?>
       <div class="tak_filafavoritos">
       <?php endif; ?>
       
			<div class="tak_juegofavorito">
				<a class="favoritos" href="favorito/<?=$row['slug']?>"></a> <!--el ID tak_favoritoactivo es para indicar que un juego ya ha sido indicado como favorito-->
				<img src="assets/files/games/images/<?=$row['imagename']?>" /> <!--aqui va la imagen del juego -->
                <h3><?=$row['brief']?></h3>
				<h4>
					<a href="detalle/<?=$row['slug']?>"><?=$row['title']?></a>
					<span><!--este span se deja vacio--></span>
				</h4>
				<div class="tak_juegohover"> <!--ESTE DIV SE DEJA VACIO PARA HACER POSIBLE EL EFECTO DEL ZOOM-->
				</div>
			</div>
	
		<?php if($ind % 4 == 3 || $ind +1 == count($games)): ?>
        </div>
        <?php endif; ?>
        <?php $ind++; endforeach; ?>
        
        
        
       	<script>$(".tak_juegofavorito")
			  .each(function(i) {
				if (i != 0) { 
				  $("#beep-two")
					.clone()
					.attr("id", "beep-two" + i)
					.appendTo($(this).parent()); 
				}
				$(this).data("beeper", i);
			  })
			  .mouseenter(function() {
				$("#beep-two" + $(this).data("beeper"))[0].play();
			  });
				$("#beep-two").attr("id", "beep-two0");
        </script>
    </div>