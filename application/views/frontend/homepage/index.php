    <div class="tak_contenido">
    	<div class="tak_slider">
    	<div class="tak_btnjugar"><a href="juegos"><img src="assets/images/frontend/jugar.gif" /></a>
   	      <audio id="beep-four" controls="controls" preload="auto">
                    <source src="assets/audio/126418__cabeeno-rossley__button-select.wav"></source>
                              <source src="assets/audio/126418__cabeeno-rossley__button-select.mp3"></source>
                </audio>
        </div>
                <div id="slider-wrapper">
                   <div id="slider" class="nivoSlider">
                       <?php foreach($banner_big as $row): ?>
                       <a href="<?=$row['url']?>"><div><img src="assets/files/banners/<?=$row['imagename']?>" alt="" /></div></a>
                       <?php endforeach; ?>
                   </div>  
                </div>
       			<div class="clearBoth"></div>	
        </div>
    	<div class="tak_banners">
        	<div  class="tak_banner_izq" ><a href="<?=$banner_small[0]['url']?>"></a><img src="assets/files/banners/<?=$banner_small[0]['imagename']?>" /></div><!--solo colocar la imagen del banner despues de la liga vacia, la liga o circulo, cae encima de la imagen-->
        	    <audio id="beep-two" controls="controls" preload="auto">
                  <source src="assets/audio/171174__pyaro__button-3.wav"></source>
                   <source src="assets/audio/171174__pyaro__button-3.mp3"></source>
                </audio>
          <div  class="tak_banner_der" ><a href="<?=$banner_small[1]['url']?>"></a><img src="assets/files/banners/<?=$banner_small[1]['imagename']?>" /></div>
        </div>
      <script>$(".tak_banners a")
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
      <script>$(".tak_btnjugar")
			  .each(function(i) {
				if (i != 0) { 
				  $("#beep-four")
					.clone()
					.attr("id", "beep-four" + i)
					.appendTo($(this).parent()); 
				}
				$(this).data("beeper", i);
			  })
			  .mouseenter(function() {
				$("#beep-four" + $(this).data("beeper"))[0].play();
			  });
				$("#beep-four").attr("id", "beep-four0");
        </script>
        
    </div>
    <div id="botones" class="tak_contenido_landing" <?=sizeof($games)>5?"":"style='height:400px;'"?>>
    	<?php if(sizeof($games_matriz) > 0){ ?>
    		
    		<div class="juegos_matriz">	
	    		<?php foreach($games_matriz as $key=>$row): ?>
	    			
	    			<div class='<?=$key==0?"cont_izq":"cont_der"?>'>
	    				<?= $key==0? "<h2 class='recom_der landing_izq'>Si te gusta este juego...</h2>" : ""?>
	    				<?= $key==1? "<h2 class='recom_izq'>Te va a encantar este</h2>" : ""?>
		    			<div class="tak_juegofavorito">
		    				<a <?php if(in_array($row['id'], $favorites)) {} else { echo "id='tak_favoritoactivo'"; } ?> class="favoritos" href="favorito/<?=$row['slug']?>"></a> <!--el ID tak_favoritoactivo es para indicar que un juego ya ha sido indicado como favorito-->
							<a href="detalle/<?=$row['slug']?>"> <img src="assets/files/games/images/<?=$row['imagename']?>" /></a><!--aqui va la imagen del juego -->
							<a href="detalle/<?=$row['slug']?>"><h3><?=$row['brief']?></h3></a>
			                <h4>
								<a href="detalle/<?=$row['slug']?>"><?=$row['title']?></a>
								<span><!--este span se deja vacio--></span>
							</h4>
							<a href="detalle/<?=$row['slug']?>"><div class="tak_juegohover"></div></a>
						</div>
					</div>
	    			
	    		<?php endforeach; ?>
	    	</div>
    		
    	<?php }?>
    	<!-- <?=sizeof($games)>5?"":"<h2>&iquest;Por qu&eacute; no pruebas estos juegos?</h2>"?> -->
		<?php $ind = 0; foreach($games as $row): ?>
        
        <?php if($ind % 5 == 0): ?>
        <div class="tak_filafavoritos">
        <?php endif; ?>
			<div class="tak_juegofavorito">
				<!--<a class="masinfo" href="detalle/<?=$row['slug']?>"></a>-->
				<a <?php if(in_array($row['id'], $favorites)) {} else { echo "id='tak_favoritoactivo'"; } ?> class="favoritos" href="favorito/<?=$row['slug']?>"></a> <!--el ID tak_favoritoactivo es para indicar que un juego ya ha sido indicado como favorito-->
				<a href="detalle/<?=$row['slug']?>"> <img src="assets/files/games/images/<?=$row['imagename']?>" /> </a><!--aqui va la imagen del juego -->
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
     <?php if(sizeof($games)>5){ ?>
     	<a href="#header" class="tak_subir"></a>
     <?php }else{ ?>
     	<a href="inicio?fetch_all=1" class="tak_todos"></a>
     <?php }?>