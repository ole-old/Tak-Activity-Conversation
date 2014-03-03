<script src="assets/scripts/jquery_tools.js" type="text/javascript"></script>
<script src="assets/scripts/jquery.lightbox_me.js" type="text/javascript"></script>
<script src="assets/scripts/custom.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/scripts/jquery.jcarousel.min.js"></script>
<script type="text/javascript">
/**
 * We use the initCallback callback
 * to assign functionality to the controls
 */


$(document).ready(function() {
   
	
	$('.tak_iniciarsesion').click(function() {
	    $(".tak_lightbox").lightbox_me({
		   centered: true}
		);
	 });		
	
	/* Form validation */
	$("form.validate").submit(function(){
	

		var error = false;
		
			if($('#password').val()==""){
				alert("Por favor ingresa una contraseña");
				$('#password').focus();
				error = true;
				return false;
			
			}

			if($('#password_conf').val()==""){
				alert("Por favor confirma tu contraseña");
				$('#password_conf').focus();
				error = true;
				return false;
			
			}
			

			if($('#password').val() != $('#password_conf').val()){
			alert('Las contraseñas no coinciden, favor de verificar');
				$('#password').val("");
				$('#password_conf').val("");
				$('#password').focus();
				error = true;
				return false;
			}


		
		if(error) {
			$("p.warning-text").fadeIn();
		}
		
		return !error;		
		
	});
	
	
 
 	$('#username').keyup(function() {
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9]/g, function(str) { alert('Escribiste " ' + str + ' ".\n\nAmig@ sólo escribe con letras y números.'); return ''; } ) );
    });
    $('#password').keyup(function() {
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9]/g, function(str) { alert('Escribiste " ' + str + ' ".\n\nAmig@ sólo escribe con letras y números.'); return ''; } ) );
    });
    $('#password_conf').keyup(function() {
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9]/g, function(str) { alert('Escribiste " ' + str + ' ".\n\nAmig@ sólo escribe con letras y números.'); return ''; } ) );
    });
 
});
</script>


	<div class="tak_contenido">
        <div class="tak_registro">
        	<h1>Nueva contraseña</h1>
            <p>Por favor escribe una nueva contraseña. Al terminar haz  click en Guardar datos.</p>
       		<div class="tak_formulario">
			<h2>Llena los datos</h2>
                <ul> 
							<li><span>Datos obligatorios</span> </li>
							<li>Usuario / Apodo</li>
							<li>Contraseña</li>
							<li>Repite tu contraseña</li>
                </ul>
                <div>
                <form id="frm_register" action="" method="post" class="validate">
        			       
						   <input type="hidden" id="avatar_seleccionado" name="avatar" value="<?=str_replace('.png', '', $player_data['avatar'])?>" />
                            <input type="hidden" id="id_usr" name="id_usr" value="<?=$player_data['id']?>" />
                            <input type="hidden" id="username" name="username" value="<?=$player_data['username']?>" />
							<input type="text" id="s_username" name="s_username" value="<?=$player_data['username']?>" class="required" title="Escribe tu usuario/apodo" maxlength="16" disabled="disabled"/>
							<input type="password" id="password" name="password"  class="required" maxlength="16"  />
							<input type="password" id="password_conf" name="password_conf"  class="required" maxlength="16"  />
				</form>		   
				</div>


            </div>
            
                              <a class="tak_registrate2" href="javascript:void(0);" onclick="$('#frm_register').submit();">Guardar datos</a>
          
        </div>	
    </div>  