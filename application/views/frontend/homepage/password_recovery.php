<script src="assets/scripts/jquery_tools.js" type="text/javascript"></script>
<script src="assets/scripts/jquery.lightbox_me.js" type="text/javascript"></script> 
<script type="text/javascript" src="assets/scripts/jquery.jcarousel.min.js"></script>
<script type="text/javascript">


$(document).ready(function() {
	

	
	
	/* Form validation */
	$("form.validate").submit(function(){
		var error = false;
                              
		$(".required").removeClass('error');
		
		$("input.required, select.required, textarea.required, input.required_checkbox, input.required_checkboxred").each(function(){
			if($.trim($(this).val())==""){
				alert($(this).attr('title'));
				$(this).focus().addClass("error");
				error = true;
				return false;
			}

		});

		if(error) {
			$("p.warning-text").fadeIn();
		}
		
		return !error;		
		
	});
    $('#username').keyup(function() {
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9]/g., function(str) { alert('Escribiste " ' + str + ' ".\n\nAmig@ sólo escribe con letras y números.'); return ''; } ) );
    });
                  
                  
                  
});
</script>



<div class="tak_container">

	<div class="tak_contenido">
        <div class="tak_registro">
        	<h1>Recuperación de contraseña</h1>
            <p>Para recuperar tu contraseña es necesario que respondas a las preguntas con las que registraste tu cuenta.</p>
       		<div class="tak_formulario">
           		<h2>Llena los datos</h2>
                <ul> 
                	<li><span>Datos obligatorios</span> </li>
                    <li>Usuario / Apodo</li>
                    <li>Elige una mascota</li>
                    <li>Elige un color</li>
                    <li>Elige una fruta</li>
                </ul>
                <div>
                <form id="frm_register" action="" method="post" class="validate">
      
                  <input type="text" id="username" name="username" value="<?=$data['username']?>" class="required" title="Escribe tu usuario/apodo" maxlength="16" />
                 
                  <label>
                  	<select id="answer1" name="answer1" class="required" title="Elige una mascota">
	            		<option value="">- Seleccione -</option>
						<?php foreach($answers1 as $row):  ?>
                        <option value="<?=$row['id']?>"><?=$row['answer']?></option>
                        <?php endforeach; ?>
                  	</select>
                  </label>
                  <label>	                    
                  	<select id="answer2" name="answer2" class="required" title="Elige un color">
	            		<option value="">- Seleccione -</option>
						<?php foreach($answers2 as $row):  ?>
                        <option value="<?=$row['id']?>"><?=$row['answer']?></option>
                        <?php endforeach; ?>
                  	</select>
                  </label>
                  <label>
                  	<select id="answer3" name="answer3" class="required" title="Elige una fruta">
	            		<option value="">- Seleccione -</option>
						<?php foreach($answers3 as $row):  ?>
                        <option value="<?=$row['id']?>"><?=$row['answer']?></option>
                        <?php endforeach; ?>
                  	</select>
                  </label>
				</form>		   
						</div>


            </div>
            
                              <a class="tak_registrate2" href="javascript:void(0);" onclick="$('#frm_register').submit();">Enviar</a>
          
        </div>	
    </div>    	
