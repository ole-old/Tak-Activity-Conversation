<link rel="stylesheet" href="assets/styles/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" /><!--esta es la css para el lightbox de los juego-->
<script src="assets/scripts/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script><!--este es el script para el lightbox de los juegos-->    
    
<div class="tak_lightbox_queremos">
	<div class="tak_plecasuperior"></div>
		<div class="tak_contenido_queremos">
			<h1>Queremos conocerte más</h1>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td class="tak_fechanacimiento">Fecha de Nacimiento</td>
				<td class="tak_fondofecha"><input class="tak_diames2" name="" type="text" /><input class="tak_diames2"  name="" type="text" /><input name="" class="tak_anio2"  type="text" /></td>
				<td><input type="button" /></td>
				<td><label class="label_check" for="sample-check">
    <input name="sample-check" id="sample-check" value="1" type="checkbox" />
    Adulto
</label></td>
			  </tr>
			</table>
			<p>Nota: Los campos proporcionados nos ayudarán a mejorar nuestros juegos y entender tus necesidades. Gracias por ayudarnos.</p>
			<input type="button" value="Guardar" class="tak_guardar"/>
			<input type="button" value="Ahora no, gracias" class="tak_ahorano close" />
		</div>
	<div class="tak_plecainferior"></div>
</div>    
    
    <div id="tak_juegocontenido" class="tak_contenido">
    	<div class="tak_fondojuegos">
        	
	
				<div id="tak_otroboton" class="tak_regresar_favoritos">
                	<?php if($game['imagetop']): ?>
                    <img src="assets/files/games/images/<?=$game['imagetop']?>" width="202" height="78" alt="<?=$game['title']?>" />
                    <?php endif; ?>
                	<a class="tak_regresartablero" href="inicio">Regresar a tablero</a>	
                    <a class="tak_agregarfavorito" href="favorito/<?=$game['slug']?>">Agregar a favoritos</a>
                    <!--<a class="tak_usa"href="#"></a>-->
                    <audio id="beep-trhee" controls="controls" preload="auto">
                    <source src="audio/126418__cabeeno-rossley__button-select.wav"></source>
                    <source src="audio/126418__cabeeno-rossley__button-select.mp3"></source>
                </audio>
                </div>
				<div class="tak_juego">
                		<ul style="display:none;" class="gallery clearfix">
			</ul>
	
			
	
		
			<ul class="gallery clearfix">
				
  <li><!--esta es la liga para que cargue el lightbox del juego-->
<a title="<?=$game['title']?>" rel="prettyPhoto[iframes]" href="jugar/<?=$game['slug']?>?iframe=true&width=<?=$game['game_width']?>&height=<?=$game['game_height']?>"></a><!--w:650 h:510-->
</li>
	
			
            
            </ul>
                    <audio id="beep-four" controls="controls" preload="auto">
                         <source src="audio/36802__alexpadina__ready-go.wav"></source>
                         <source src="audio/36802__alexpadina__ready-go.mp3"></source>
               		 </audio>
                    <?php if($game['imageback']): ?>
                    <img src="assets/files/games/images/<?=$game['imageback']?>" width="805" height="434" alt="" />
                    <?php endif; ?>
                </div>
              		<!--<a class="tak_terminarjuego2" href="javascript:void(0);">Terminar juego</a>-->
     				<audio id="beep-five" controls="controls" preload="auto">
                         <source src="audio/177083__gb01__crowd-clap.wav"></source>
                         <source src="audio/177083__gb01__crowd-clap.mp3"></source>
               		 </audio>
                
				<script>$(".tak_regresar_favoritos a")
                  .each(function(i) {
                    if (i != 0) { 
                      $("#beep-trhee")
                        .clone()
                        .attr("id", "beep-trhee" + i)
                        .appendTo($(this).parent()); 
                    }
                    $(this).data("beeper", i);
                  })
                  .mouseenter(function() {
                    $("#beep-trhee" + $(this).data("beeper"))[0].play();
                  });
                    $("#beep-trhee").attr("id", "beep-trhee0");
            </script>
            
				<script>$(".tak_juego a")
                  .each(function(i) {
                    if (i != 0) { 
                      $("#beep-four")
                        .clone()
                        .attr("id", "beep-four" + i)
                        .appendTo($(this).parent()); 
                    }
                    $(this).data("beeper", i);
                  })
                  .click(function() {
                    $("#beep-four" + $(this).data("beeper"))[0].play();
                  });
                    $("#beep-four").attr("id", "beep-four0");
            </script>
            <script>$(".tak_terminarjuego2")
                  .each(function(i) {
                    if (i != 0) { 
                      $("#beep-five")
                        .clone()
                        .attr("id", "beep-five" + i)
                        .appendTo($(this).parent()); 
                    }
                    $(this).data("beeper", i);
                  })
                  .click(function() {
                    $("#beep-five" + $(this).data("beeper"))[0].play();
                  });
                    $("#beep-five").attr("id", "beep-five0");
            </script>
            
        </div>
        <div style="height:50px">
        <!--div class="tak_instrucciones">
       				 <div>
                       <h1>Instrucciones</h1>
                        <p>Utiliza las teclas para jugar</p>
                	 </div>
                        <p>
                        	<span><img align="left" src="assets/images/frontend/btn_arriba.png" /><strong>Saltar</strong></span>
                        	<span><img align="left" src="assets/images/frontend/btn_abajo.png" /><strong>Agacharse</strong></span>
                        	<span><img align="left" src="assets/images/frontend/btn_atras.png" /><strong>Atrás</strong></span>
                        	<span><img align="left" src="assets/images/frontend/btn_adelante.png" /><strong>Adelante</strong></span>
                        	<span><img align="left" src="assets/images/frontend/btn_espacio.png" /><strong>Cerrar</strong></span>
                        
                        </p-->
                 
                </div>
    </div>
    <script type="text/javascript" charset="utf-8"><!--este es el script para el lightbox de los juegos-->
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true, allow_resize: false,keyboard_shortcuts: false});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true, allow_resize: false,keyboard_shortcuts: false});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

			//	$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
//					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
//					changepicturecallback: function(){ _bsap.exec(); }
//				});
			});
			</script>
            <script src="assets/scripts/jquery.lightbox_me.js" type="text/javascript"></script> 
		<script type="text/javascript" charset="utf-8">
			   $(document).ready(function() {
			 $('.tak_terminarjuego2').click(function() {
			 $(".tak_lightbox_queremos").lightbox_me({centered: true});
			 });
		});
</script>    
    
    
    
    
    
    
    
    