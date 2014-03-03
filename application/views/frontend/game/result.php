    
    <div id="tak_resultados" class="tak_contenido">
    	<a href="inicio" class="tak_regresartablero"> Regresar a tablero	 </a>
    	<div class="tak_avatar2 rotar"><img src="assets/images/frontend/33.png" /></div>
    	<div class="tak_columna_resultados">
                     
           <div class="tak_logomateo">
			  <?php if($game['imagetop']): ?>
              <img src="assets/files/games/images/<?=$game['imagetop']?>" width="202" height="78" alt="<?=$game['title']?>" />
              <?php endif; ?>         
            </div>
				
			
					<div class="tak_puntaje">
					<h1>Tu puntaje</h1>
						<div class="tak_puntaje_avatar"><img src="assets/images/frontend/<?=$player_data['avatar']?>" /></div>
						<div class="tak_puntaje_texto">
							<h2><?=$player_data['username']?><span><?=$max_score['max_score']?> pts</span></h2>
							<p>&nbsp;</p>
                            
						</div>
					</div>
						<div class="tak_califica">
							<img align="left"width="86" height="84" src="assets/files/games/images/<?=$game['imagename']?>" />
							<a class="tak_favorito" href="favorito/<?=$game['slug']?>">Favorito</a>
							<a class="tak_terminarjuego" href="detalle/<?=$game['slug']?>">Volver a jugar</a>
					        <audio id="beep-trhee" controls="controls" preload="auto">
                                 <source src="audio/126418__cabeeno-rossley__button-select.wav"></source>
                                 <source src="audio/126418__cabeeno-rossley__button-select.mp3"></source>
                			</audio>
						</div>
				
                
                <div class="tak_tudemas">
                	<h1>T&uacute; y los demás</h1>
                    <?php 
						$indice=1;
						foreach($top_players as $row): ?>
                    <h4 <?php if($user_front['id']==$row['id']) { echo 'id="tak_posicion"'; } ?>><span><?=$indice?></span><img src="assets/images/frontend/<?=$row['avatar']?>" /><p><?=$row['username']?></p><p><strong><?=$row['max_score']?> pts</strong></p></h4>
                    <?php 
						$indice++;
						endforeach; ?>
                </div>
         
				<script>$(".tak_califica a, .tak_regresartablero")
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
            </div>
            </div>

    
    
    
    
    
    
    