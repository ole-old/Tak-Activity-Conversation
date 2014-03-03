<?php if($the_action=='play'): ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title><?=$site_title?><?php if($title){ echo ' - '.$title; } ?></title>
			<base href="<?=URL::base(TRUE)?>" />
			<link href="assets/styles/tak_styles.css" rel="stylesheet" type="text/css"/>
			<script src="assets/scripts/UnityObject.js" type="text/javascript"></script>
			<script type="text/javascript" src="assets/scripts/jquery-1.4.3.min.js"></script>
			<script type="text/javascript" src="http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject.js"></script>
			<script src="assets/scripts/datosjuego.js" type="text/javascript"></script>
			<script type="text/javascript">
				function GetUnity() {
					if(typeof unityObject != "undefined") {
						return unityObject.getObjectById("unityPlayer");
					}
					return null;
				}
				if(typeof unityObject != "undefined") {
					unityObject.embedUnity("unityPlayer", "assets/files/games/roms/<?=$the_game_info['base_path'].$the_game_info['gamefile']?>", <?=$the_game_info['game_width']?>, <?=$the_game_info['game_height']-80?>);
				}
			</script>
			<link rel="shortcut icon" href="assets/images/frontend/favicon.ico" />  
		</head>
		<?php $funcion = "";
		if($user_front){
			$funcion = "setValoresIniciales('" . htmlentities($game_data['game_data'],ENT_QUOTES) . "','" . $user_front['id'] . "','" . $user_front['username'] . "');";
		}?>
		<body onload="<?=$funcion?> setTimeout(logo_load(),1000);">
			<?=$content?>
			<?php //echo $registry['google_analytics']?>
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
				ga('create', 'UA-43305301-1', 'taktaktak.com');
				ga('send', 'pageview');
			</script>
		</body>
	</html>
<?php else: ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title><?=$site_title?><?php if($title){ echo ' - '.$title; } ?></title>
			<base href="<?=URL::base(TRUE)?>" />
			<link href="assets/styles/tak_styles.css" rel="stylesheet" type="text/css"/>
			<link rel="stylesheet" type="text/css" href="assets/styles/jquerystyles.css" media="screen" />
			<script type="text/javascript" src="assets/scripts/fondo.js"></script>
			<script type="text/javascript" src="assets/scripts/jquery-1.4.3.min.js"></script>
			<script src="assets/scripts/datosjuego.js" type="text/javascript"></script>  	      
			<script type="text/javascript" src="assets/scripts/jquery.nivo.slider.pack.js"></script>        
			<script src="assets/scripts/jquery.lightbox_me.js" type="text/javascript"></script>
			<script src="assets/scripts/custom.js" type="text/javascript"></script>
			<script src="assets/scripts/frontend.js" type="text/javascript"></script>
			<link rel="shortcut icon" href="assets/images/frontend/favicon.ico" />  
			<!--[if lte IE 8]> <link href="css/explorer.css" rel="stylesheet" type="text/css"/> <![endif]-->
			<script type="text/javascript" charset="utf-8">
				$(document).ready(function() {
					$('.tak_iniciarsesion').click(function() {
						$(".tak_lightbox").lightbox_me({
							centered: true
						});
					});
				});
			</script>
		</head>
		<?php $funcion = "";
		if($user_front) {
			$funcion = "setValoresIniciales('" . htmlentities($game_data['game_data'],ENT_QUOTES) . "','" . $user_front['id'] . "','" . $user_front['username'] . "');";
		}?>
		<body onload="<?=$funcion?> setTimeout(logo_load(),1000);">
			<div class="tak_container">
				<?php if(isset($cookie)):
						$usuario=$cookie;
						$chk="checked";
					else:
						$usuario="Nombre de usuario";
						$chk="";
					endif;
					if(isset($cookie2)):
						$passwd=$cookie2;
						$chk2="checked";
					else:
						$passwd="Contraseña";
						$chk2="";
					endif;
				?>
				<div class="tak_lightbox">
					<h1>Iniciar sesi&oacute;n</h1>
					<form id="frm_login" action="login" method="post">
						<input type="text" name="login_username" placeholder="<?=$usuario?>" value="<?=$usuario?>"/>
						<input type="password" name="login_password" placeholder="<?=$passwd?>" value="<?=$passwd?>"/>
						<label class="texto_check"  for="sample-check"><input class="fix_check" type="checkbox" name="sample-check" id="sample-check" value="sample-check" <?=$chk;?> />Recu&eacute;rdame en este equipo</label><br>
						<label class="texto_check"  for="sample-check2"><input class="fix_check" type="checkbox" name="sample-check2" id="sample-check2" value="sample-check2" <?=$chk2;?> />Recuerda mi contrase&ntilde;a</label>
						<input type="submit" class="abrir_sesion" value="Abrir sesi&oacute;n" />
					</form>
					<div>        
						<p>¿A&uacute;n no tienes cuenta? Crea una <a href="registro">aqu&iacute;</a></p>
						<p><span>¿Olvidaste tu contrase&ntilde;?</span></p>
						<p><a href="recupera_contrasena">Recupera tu contrase&ntilde;a</a></p>
					</div>
				</div>
				<div class="tak_header" id="header">
					<div class="tak_logo">
						<?php if($the_action=='index'): ?>
							<audio id="logo_snd" controls="controls" preload="auto">
								<source src="assets/audio/125429__jspath1__three-bass-thumps(1).wav"></source>
								<source src="assets/audio/125429__jspath1__three-bass-thumps(1).mp3"></source>
							</audio>
						<?php else: ?>
							<script type="text/javascript">
								var images = [],
								index = 0;
								images[0] = "<a href = 'inicio'><img src='assets/images/frontend/logo_9.jpg' alt=''></a>";
								images[1] = "<a href = 'inicio'><img src='assets/images/frontend/logo_2.jpg' alt=''></a>";
								images[2] = "<a href = 'inicio'><img src='assets/images/frontend/logo_3.jpg' alt=''></a>";
								images[3] = "<a href = 'inicio'><img src='assets/images/frontend/logo_4.jpg' alt=''></a>";
								images[4] = "<a href = 'inicio'><img src='assets/images/frontend/logo_5.jpg' alt=''></a>";
								images[5] = "<a href = 'inicio'><img src='assets/images/frontend/logo_6.jpg' alt=''></a>";
								images[6] = "<a href = 'inicio'><img src='assets/images/frontend/logo_7.jpg' alt=''></a>";
								images[7] = "<a href = 'inicio'><img src='assets/images/frontend/logo_8.jpg' alt=''></a>";
								images[8] = "<a href = 'inicio'><img src='assets/images/frontend/logo_9.jpg' alt=''></a>";
								index = Math.floor(Math.random() * images.length);
								document.write(images[index])
							</script>
						<?php endif; ?>
					</div>
					<?php if (isset($user_front)): ?>
						<div class="tak_menulogueado">
							<!--<ul class="menu_idioma"> 
							<li><a href="#">English</a></li>
							</ul>-->
							<div class="tak_avatar_menu"><a href="mi_perfil"><img src="assets/images/frontend/<?=$user_front['avatar']?>" alt="avatar" /></a></div>
							<ul class="tak_opciones_usuario">
								<li><a href="mi_perfil"><?=$user_front['username']?></a>
									<ul> 
										<li><a href="mi_perfil">Cuenta</a></li>
										<li><a href="favoritos">Favoritos</a></li>
										<li><a href="logout">Cerrar sesi&oacute;n</a></li>             
									</ul>
								</li>
							</ul>	
						</div>        
					<?php else: ?>
						<div class="tak_menu_nologueado">
							<a class="tak_iniciarsesion" href="javascript:void(0);">Iniciar sesi&oacute;n</a><!-- ESTO ES EL MENÚ SIN LOGUEAR--><!--AL DAR CLICK EN ESTE BOTÓN SE ABRE EL LIGHTBOX -->
							<a class="tak_registrate" href="registro">Reg&iacute;strate</a>
							<ul class="menu_idioma">
							<!--  	<li><a href="#">English</a></li>       -->
							</ul>
						</div>
					<?php endif; ?>
					<!-- HTML COMENTADO ES EL CODIGO QUE APARECERÁ CUANDO EL MENÚ ESTE LOGUEADO-->
					<div class="tak_menuauxiliar_buscador">
						<ul>
							<li><a class="tak_padres" href="padres-y-maestros">Padres y Maestros</a></li>
							<!--<li><a class="tak_maestros" href="padres-y-maestros">Maestros</a></li>-->
						</ul>
						<form action="search" method="get">
							<input type="text" name="search_txt" value="Busca tu juego" onclick="javascript:this.value=''" />
							<input type="submit" class="buscar" value="" />
						</form>
					</div>
				</div>
				<?=$content?>
				<div class="tak_footer"><a href="terminos-legales">T&eacute;rminos Legales</a><a class="tak_sinborde" href="aviso-de-privacidad">Aviso de privacidad</a></div>
			</div>
			<?php //echo $registry['google_analytics']?>
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
				ga('create', 'UA-43305301-1', 'taktaktak.com');
				ga('send', 'pageview');
			</script>
		</body> 
	</html>
<?php endif; ?>