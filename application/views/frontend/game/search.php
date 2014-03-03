
        
    <div id="botones" class="tak_contenido_landing">
		<?php $ind = 0; foreach($games as $row): ?>
        
        <?php if($ind % 5 == 0): ?>
        <div class="tak_filafavoritos">
        <?php endif; ?>
			<div class="tak_juegofavorito">
				<!--<a class="masinfo" href="detalle/<?=$row['slug']?>"></a>-->
				<a <?php if(in_array($row['id'], $favorites)) {} else { echo "id='tak_favoritoactivo'"; } ?> class="favoritos" href="favorito/<?=$row['slug']?>"></a> <!--el ID tak_favoritoactivo es para indicar que un juego ya ha sido indicado como favorito-->
				<img src="assets/files/games/images/<?=$row['imagename']?>" /> <!--aqui va la imagen del juego -->
				  <a href="detalle/<?=$row['slug']?>"><h3><?=$row['brief']?></h3></a>
                <h4>
					<a href="detalle/<?=$row['slug']?>"><?=$row['title']?></a>
					<span><!--este span se deja vacio--></span>
				</h4>
				<a href="detalle/<?=$row['slug']?>">
				<div class="tak_juegohover"> <!--ESTE DIV SE DEJA VACIO PARA HACER POSIBLE EL EFECTO DEL ZOOM-->
				</div></a>
			</div>
		<?php if($ind % 5 == 4 || $ind +1 == count($games)): ?>
        </div>
        <?php endif; ?>
        <?php $ind++; endforeach; ?>
	
		<script>$(".tak_juegofavorito")
			  .each(function(i) {
				if (i != 0) { 
				  $("#beep-three")
					.clone()
					.attr("id", "beep-three" + i)
					.appendTo($(this).parent()); 
				}
				$(this).data("beeper", i);
			  })
			  .mouseenter(function() {
				$("#beep-three" + $(this).data("beeper"))[0].play();
			  });
				$("#beep-three").attr("id", "beep-three");
        </script>
	</div>


