<script src="assets/scripts/jquery_tools.js" type="text/javascript"></script>
<script src="assets/scripts/jquery.lightbox_me.js" type="text/javascript"></script>
<script src="assets/scripts/custom.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/scripts/jquery.jcarousel.min.js"></script>
<script type="text/javascript">
/**
 * We use the initCallback callback
 * to assign functionality to the controls
 */
function mycarousel_initCallback(carousel) {
    $('.jcarousel-control a').bind('click', function() {
        carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
		$(this).addClass("tag_seleccionado");
		var avatar = parseInt($("#avatar_seleccionado").val()) ;
		$("#caso_" + avatar).removeClass("tag_seleccionado");
		$("#avatar_seleccionado").val($(this).html());
        return false;
    });

    $('.jcarousel-scroll select').bind('change', function() {
        carousel.options.scroll = jQuery.jcarousel.intval(this.options[this.selectedIndex].value);
        return false;
    });

    $('#mycarousel-next').bind('click', function() {
		$("#mycarousel-next").attr("disabled","disabled");
		setTimeout(function(){
			$("#mycarousel-next").removeAttr("disabled");
		},800);
        carousel.next();
		var avatar = parseInt($("#avatar_seleccionado").val()) + 1;
		if(avatar < 50){
			$("#avatar_seleccionado").val(avatar);
			$("#caso_" + avatar).addClass("tag_seleccionado");
			$("#caso_" + (avatar - 1)).removeClass("tag_seleccionado");
		}
        return false;
    });

    $('#mycarousel-prev').bind('click', function() {
		$("#mycarousel-prev").attr("disabled","disabled");
		setTimeout(function(){
			$("#mycarousel-prev").removeAttr("disabled");
		},1000);
        carousel.prev();
		var avatar = parseInt($("#avatar_seleccionado").val()) - 1;
		if(avatar > 0){
			$("#avatar_seleccionado").val(avatar);
			$("#caso_" + avatar).addClass("tag_seleccionado");
			$("#caso_" + (avatar + 1)).removeClass("tag_seleccionado");
		}
        return false;
    });
};


$(document).ready(function() {

	if($('#how_id').val() == 5){
			$('#confirmation_card_q').show();
			$('#confirmation_card').show();
		}
	if($('#how_id').val() != 5){
			$('#confirmation_card_q').hide();
			$('#confirmation_card').hide();
		}
	
    $("#mycarousel").jcarousel({
        scroll: 1,
        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null
    });		
	
	$(".tak_lightbox_avatar").hide();
	$('.siavatar').click(function() {
		$(".tak_lightbox_avatar").lightbox_me({centered: true});
	});
	$('.tak_guardar_avatar').click(function() {
		$('.cerrar').click();
	});	
	
	$('.tak_iniciarsesion').click(function() {
		$(".tak_lightbox").lightbox_me({
		   centered: true}
		);
	 });		
	
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

		if($('#password').val() != $('#password_conf').val()){
			alert('Las contraseñas no coinciden, favor de verificar');
				$('#password').val("");
				$('#password_conf').val("");
				$('#password').focus();
				error = true;
				return false;
			}

		if($('#how_id').val() == 5){
			if($.trim($('#confirmation_card').val())==""){
				alert('Por favor ingresa el folio de tu tarjeta');
				$('#confirmation_card').focus();
				error = true;
				return false;
				}
			 if(!$.isNumeric($('#confirmation_card').val())){
				alert('El folio debe ser numerico');
				$('#confirmation_card').focus();
				error = true;
				return false;
			}
			 
		}

		
		if(error) {
			$("p.warning-text").fadeIn();
		}

		$("#combo_estado").removeAttr("disabled");
		
		return !error;		
		
	});
	
	$("[name=school_year_id]").change(function(){
		if($('[name=school_year_id]').val() != 0){
			$("[name=asignature_id]").empty();
			$.getJSON("materias", { school_year_id: $('[name=school_year_id]').val() },function(data){
				$(data).each(function(i){
					$("select[name=asignature_id]").append('<option value="'+this.id+'">'+this.asignature+'</option>');
				});
			});
		}
		if($('[name=school_year_id]').val() == 0){
		$("[name=asignature_id]").empty();
		$("select[name=asignature_id]").append('<option value="'+this.id+'">'+"-Seleccione-"+'</option>');
		}
	});
	
	$('#how_id').change(function(){
		if($('#how_id').val() == 5){
			$('#confirmation_card_q').show();
			$('#confirmation_card').show();
		}
		if($('#how_id').val() != 5){
			$('#confirmation_card_q').hide();
			$('#confirmation_card').hide();
		}	
	});
	
	$("[name=asignature_id]").click(function(){
		if($('[name=school_year_id]').val() == 0){
		$("[name=asignature_id]").empty();
		$("select[name=asignature_id]").append('<option value="'+this.id+'">'+"-Seleccione-"+'</option>');
		}
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

    
	$("#combo_pais").change(function(){
		var pais_id = $(this).val() || 0;
		 if(pais_id != 24){ // diferente de mexicp
			 $("#combo_estado").val(33);
			 $("#combo_estado").attr("disabled","disabled");
		 }else{
			 $("#combo_estado").val(0);
			 $("#combo_estado").removeAttr("disabled");
		 }
	});
	
 
});
</script>



<div class="tak_container">
    <div  class="tak_lightbox_avatar">
      <a class="cerrar" href="#"></a>
		<h1>Elige tu avatar</h1>		    
    <div id="wrap">
		<div class="tak_fondo_seleccionado"></div>
  <div id="mycarousel" class="jcarousel-skin-tango">
    <div class="jcarousel-control">
      <a style="display:none;"  href="#">1</a>
      <a href="#" id="caso_1" class="tag_seleccionado">1</a>
      <a href="#" id="caso_2">2</a>
      <a href="#" id="caso_3">3</a>
      <a href="#" id="caso_4">4</a>
      <a href="#" id="caso_5">5</a>
      <a href="#" id="caso_6">6</a>
      <a href="#" id="caso_7">7</a>
      <a href="#" id="caso_8">8</a>
      <a href="#" id="caso_9">9</a>
      <a href="#" id="caso_10">10</a>
      <a href="#" id="caso_11">11</a>
      <a href="#" id="caso_12">12</a>
      <a href="#" id="caso_13">13</a>
      <a href="#" id="caso_14">14</a>
      <a href="#" id="caso_15">15</a>
      <a href="#" id="caso_16">16</a>
      <a href="#" id="caso_17">17</a>
      <a href="#" id="caso_18">18</a>
      <a href="#" id="caso_19">19</a>
      <a href="#" id="caso_20">20</a>
      <a href="#" id="caso_21">21</a>
      <a href="#" id="caso_22">22</a>
      <a href="#" id="caso_23">23</a>
      <a href="#" id="caso_24">24</a>
      <a href="#" id="caso_25">25</a>
      <a href="#" id="caso_26">26</a>
      <a href="#" id="caso_27">27</a>
      <a href="#" id="caso_28">28</a>
      <a href="#" id="caso_29">29</a>
      <a href="#" id="caso_30">30</a>
      <a href="#" id="caso_31">31</a>
      <a href="#" id="caso_32" >32</a>
      <a href="#" id="caso_33">33</a>
      <a href="#" id="caso_34">34</a>
      <a href="#" id="caso_35">35</a>
      <a href="#" id="caso_36">36</a>
      <a href="#" id="caso_37">37</a>
      <a href="#" id="caso_38">38</a>
      <a href="#" id="caso_39">39</a>
      <a href="#" id="caso_40">40</a>
      <a href="#" id="caso_41">41</a>
      <a href="#" id="caso_42">42</a>
      <a href="#" id="caso_43">43</a>
      <a href="#" id="caso_44">44</a>
      <a href="#" id="caso_45">45</a>
      <a href="#" id="caso_46">46</a>
      <a href="#" id="caso_47">47</a>
      <a href="#" id="caso_48">48</a>
      <a href="#" id="caso_49">49</a>
      <a href="#" id="caso_50">50</a>
      <a style="display:none;" href="#">10</a>
    </div>

    <ul>
      <li><img height="75" src="assets/images/frontend/vacia.png" alt="" /></li>
      <li><img  src="assets/images/frontend/1.png" /></li>
      <li><img  src="assets/images/frontend/2.png" /></li>
      <li><img  src="assets/images/frontend/3.png" /></li>
 	  <li><img  src="assets/images/frontend/4.png" /></li>
	  <li><img  src="assets/images/frontend/5.png" /></li>
      <li><img  src="assets/images/frontend/6.png" /></li>
 	  <li><img  src="assets/images/frontend/7.png" /></li>
	  <li><img  src="assets/images/frontend/8.png" /></li>
      <li><img  src="assets/images/frontend/9.png" /></li>
 	  <li><img  src="assets/images/frontend/10.png" /></li>
 	  <li><img  src="assets/images/frontend/11.png" /></li>
      <li><img  src="assets/images/frontend/12.png" /></li>
      <li><img  src="assets/images/frontend/13.png" /></li>
 	  <li><img  src="assets/images/frontend/14.png" /></li>
	  <li><img  src="assets/images/frontend/15.png" /></li>
      <li><img  src="assets/images/frontend/16.png" /></li>
 	  <li><img  src="assets/images/frontend/17.png" /></li>
	  <li><img  src="assets/images/frontend/18.png" /></li>
      <li><img  src="assets/images/frontend/19.png" /></li>
 	  <li><img  src="assets/images/frontend/20.png" /></li>
 	  <li><img  src="assets/images/frontend/21.png" /></li>
      <li><img  src="assets/images/frontend/22.png" /></li>
      <li><img  src="assets/images/frontend/23.png" /></li>
 	  <li><img  src="assets/images/frontend/24.png" /></li>
	  <li><img  src="assets/images/frontend/25.png" /></li>
      <li><img  src="assets/images/frontend/26.png" /></li>
 	  <li><img  src="assets/images/frontend/27.png" /></li>
	  <li><img  src="assets/images/frontend/28.png" /></li>
      <li><img  src="assets/images/frontend/29.png" /></li>
 	  <li><img  src="assets/images/frontend/30.png" /></li>
 	  <li><img  src="assets/images/frontend/31.png" /></li>
      <li><img  src="assets/images/frontend/32.png" /></li>
      <li><img  src="assets/images/frontend/33.png" /></li>
 	  <li><img  src="assets/images/frontend/34.png" /></li>
	  <li><img  src="assets/images/frontend/35.png" /></li>
      <li><img  src="assets/images/frontend/36.png" /></li>
 	  <li><img  src="assets/images/frontend/37.png" /></li>
	  <li><img  src="assets/images/frontend/38.png" /></li>
      <li><img  src="assets/images/frontend/39.png" /></li>
 	  <li><img  src="assets/images/frontend/40.png" /></li>
 	  <li><img  src="assets/images/frontend/41.png" /></li>
      <li><img  src="assets/images/frontend/42.png" /></li>
      <li><img  src="assets/images/frontend/43.png" /></li>
 	  <li><img  src="assets/images/frontend/45.png" /></li>
	  <li><img  src="assets/images/frontend/47.png" /></li>
      <li><img  src="assets/images/frontend/49.png" /></li>
 	  <li><img  src="assets/images/frontend/51.png" /></li>
	  <li><img  src="assets/images/frontend/52.png" /></li>
      <li><img  src="assets/images/frontend/54.png" /></li>
 	  <li><img  src="assets/images/frontend/56.png" /></li>
 	
      <li><img width="75" height="75" src="assets/images/frontend/vacia.png" alt="" /></li>
      
    </ul>

    
        <input type="button" id="mycarousel-prev" value="Prev" />
        <input type="button" id="mycarousel-next" value="Next" />
        
           <audio id="beep-two" controls="controls" preload="auto">
                    <source src="assets/audio/171174__pyaro__button-3.wav"></source>
                    <source src="assets/audio/171174__pyaro__button-3.mp3"></source>
            </audio>
            <script>$("#mycarousel-prev, #mycarousel-next, .jcarousel-control a")
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

</div>
    	<a href="javascript:void(0);" class="tak_guardar_avatar">Guardar avatar</a>
     
    </div>
    
    
    <form id="frm_register" action="mi_perfil" method="post" class="validate">
    <div class="tak_contenido_perfil">
    	<div class="tak_avatarmenu">
        	<div class="tak_avatarcontenido">
                <img src="assets/images/frontend/<?=$player_data['avatar']?>" />
            </div>
            <h1><?=$player_data['username']?></h1>
            <ul>
            	<li><a href="favoritos">Favoritos</a></li>
            
                <li id="tak_perfilactivo"><a href="mi_perfil">Mi perfil</a></li>
            
            </ul>	
        </div>
        <div class="tak_settings">
        			<div class="tak_avatarflotado"><img src="assets/images/frontend/1.png" /></div>
        	 		<div class="tak_formulario">
						<ul> 
							<li>Usuario / Apodo</li>
							<li>Contrase&ntilde;a</li>
							<li>Repite tu contrase&ntilde;a</li>
							<li>Elige una mascota</li>
							<li>Elige un color</li>
							<li>Elige una fruta</li>
                            <li>Elige tu avatar</li>
						</ul>
						<div>
                		
        			        <input type="hidden" id="avatar_seleccionado" name="avatar" value="<?=str_replace('.png', '', $player_data['avatar'])?>" />
                            <input type="hidden" id="id" name="id" value="<?=$player_data['id']?>" />
                            <input type="hidden" id="username" name="username" value="<?=$player_data['username']?>" />
							<input type="text" id="s_username" name="s_username" value="<?=$player_data['username']?>" class="required" title="Escribe tu usuario/apodo" maxlength="16" disabled="disabled"/>
							<input type="password" id="password" name="password"  maxlength="16"  />
							<input type="password" id="password_conf" name="password_conf"  maxlength="16"  />
							<label>
								<select id="answer1" name="answer1" class="required" title="Elige una mascota">
									<?php foreach($answers1 as $row): ?>
                                    <option value="<?=$row['id']?>" <?php if($player_data['answer1']==$row['id']) { echo "selected"; } ?>><?=$row['answer']?></option>
                                    <?php endforeach; ?>
								</select>
						  </label>
							 <label>	                    
								 <select id="answer2" name="answer2" class="required" title="Elige un color">
									<?php foreach($answers2 as $row): ?>
                                    <option value="<?=$row['id']?>" <?php if($player_data['answer2']==$row['id']) { echo "selected"; } ?>><?=$row['answer']?></option>
                                    <?php endforeach; ?>
								</select>
							</label>
							<label>
								<select id="answer3" name="answer3" class="required" title="Elige una fruta">
									<?php foreach($answers3 as $row): ?>
                                    <option value="<?=$row['id']?>" <?php if($player_data['answer3']==$row['id']) { echo "selected"; } ?>><?=$row['answer']?></option>
                                    <?php endforeach; ?>
								</select>
							</label>
		                
                
                        <table class="tak_ninonina" width="100%" border="0" cellspacing="0" cellpadding="0">
					 	<tr>
							<td colspan="4">
                             <a  class="siavatar" href="javascript:void(0);">S&iacute; </a>
                             <!--<a class="no_avatar" href="#">No gracias </a>-->
                            
                            <!--<fieldset><label class="label_radio" for="sample-radio">
                                <input name="sample-radio" class="tak_abrir" id="sample-radio" value="1" type="radio" />
                            
                            Si </label>
                            <label class="label_radio" id="no_gracias" for="sample-radio2">
                                <input name="sample-radio" id="sample-radio2"    value="1" type="radio" />
                                No, gracias</label></fieldset>
-->	</td>
					  </tr>
					</table>
						   
						</div>	     				
            </div>
         	
			<div class="tak_avatarflotado2"><img src="assets/images/frontend/33.png" /></div>
	 <div id="tak_form_secundario" class="tak_formulario" style="background-color:#00D2EE;">
				<ul> 
					<li>Nac&iacute;</li>
					<li>Correo electr&oacute;nico</li>
					<!--<li>Nombre </li>-->
					<li>Escuela</li>
					<li>&nbsp;</li>
					<li>Pa&iacute;s</li>
                    <li>Estado</li>
                    <li>Grado escolar</li>
					<li class="tak_otro">Otro</li>
					<li>Materia favorita </li>
					<li class="tak_otro">Otro</li>
					<li>Actividad favorita</li>
					<li class="tak_otro">Otro</li>
					<li>&iquest;C&oacute;mo llegaste a TAK TAK TAK?</li>
					<li id="confirmation_card_q">Folio de tarjeta:</li>
				</ul>
		 		<div>
				<label>
					<table class="tak_nacimiento" width="1535" border="0" cellspacing="0" cellpadding="15">
						 <tr>
							<td>
								<!--input name="day" class="dia_mes" value="<?=$player_data['day']?>" type="text"  />
								<input name="month" class="dia_mes" value="<?=$player_data['month']?>" type="text"  />
								<input name="year" class="anio" value="<?=$player_data['year']?>" type="text"  /-->
								<?php $meses= array(
													1 => "Enero",
													2 => "Febrero",
													3 => "Marzo",
													4 => "Abril",
													5 => "Mayo",
													6 => "Junio",
													7 => "Julio",
													8 => "Agosto",
													9 => "Septiembre",
													10 => "Octubre",
													11 => "Noviembre",
													12 => "Diciembre",
												);
								?>		
								<input name="day" class="dia_mes" value="00" type="hidden"  />
								<select name="month" class="dia_mes" value="<?=$player_data['month']?>" style="width:126px; margin:0;">
								<option value="00" <?php if($player_data['day']=="00"){echo "selected";} ?>>--</option>
								<?php for($i=1;$i<13;$i++){echo '<option value="'.$i.'"'; if($player_data['month']==$i){echo " selected";} echo '>'.$meses[$i].'</option>';}?>
								</select>
								<select name="year" class="anio" value="<?=$player_data['year']?>" style="width:74px; margin:0;">
								<option value="0000" <?php if($player_data['day']=="0000"){echo "selected";} ?>>--</option>
								<?php for($i=2010;$i>=1970;$i--){echo '<option value="'.$i.'"'; if($player_data['year']==$i){echo " selected";} echo '>'.$i.'</option>';}?>
								</select>
							</td>
							<!--<td class="tak_calendario">
								<input type="button"  />
							</td>-->
						 </tr>
					</table>
				</label>

					<input type="text" name="email" value="<?=$player_data['email']?>" />
					<input type="hidden" name="fullname" value="<?=$player_data['fullname']?>" />
					<input type="text" name="school" value="<?=$player_data['school']?>" />
				
					<table class="tak_ninonina" width="100%" border="0" cellspacing="0" cellpadding="0">
					 	<tr>
							<td colspan="4">
                  			<fieldset style="width: 180px;">
                  				<label class="label_radio"><input name="gender" value="1" type="radio" <?php if($player_data['gender']==1) { echo "checked"; } ?> /> Ni&ntilde;o </label>
	                            <label class="label_radio"><input name="gender" value="2" type="radio" <?php if($player_data['gender']==2) { echo "checked"; } ?> /> Ni&ntilde;a</label>
                                <label class="label_radio"><input name="gender" value="3" type="radio" <?php if($player_data['gender']==3) { echo "checked"; } ?> /> Adulto</label>
                            </fieldset>
							</td>
					  </tr>
                      	</table>
                    <label>
						<select name="pais_id" id="combo_pais">
							<option value="0">- Seleccione -</option>
                            <?php foreach($paises as $row): ?>
                            <option value="<?=$row['id']?>" <?php if($player_data['pais_id']==$row['id']) { echo "selected"; } ?>><?=$row['pais']?></option>
                            <?php endforeach; ?>
						</select>
					</label>
					<label>
						<select name="state_id" id="combo_estado" <?=$player_data['pais_id'] != 24?"disabled=disabled":""?>>
							<option value="0">- Seleccione -</option>
                            <?php foreach($states as $row): ?>
                            <option value="<?=$row['id']?>" <?php if($player_data['state_id']==$row['id']) { echo "selected"; }?>><?=$row['name']?></option>
                            <?php endforeach; ?>
						</select>
					</label>
                	<label>
                    <select name="school_year_id">
                        <option value="0">- Seleccione -</option>
                        <?php foreach($school_years as $row): ?>
                        <option value="<?=$row['id']?>" <?php if($player_data['school_year_id']==$row['id']) { echo "selected"; } ?>><?=$row['school_year']?></option>
                        <?php endforeach; ?>
                    </select>
					</label>
					<input type="text" name="school_year_other" value="<?=$player_data['school_year_other']?>" />
					<?php $asignatura=Model::factory('Catasignature')->fetch_by_school_year($player_data['school_year_id']); ?>
					<label>
						<select name="asignature_id">
							<option value="0">- Seleccione -</option>
                            <?php foreach($asignatura as $row): ?>
								<option value="<?=$row['id']?>" <?php if($player_data['asignature_id']==$row['id']) { echo "selected"; } ?>><?=$row['asignature']?></option>
                            <?php endforeach; ?>
						</select>
					
					</label>						
						<input type="text" name="asignature_other" value="<?=$player_data['asignature_other']?>" />
         
					<label>
						<select name="activity_id">
							<option value="0">- Seleccione -</option>
                            <?php foreach($factivities as $row): ?>
                            <option value="<?=$row['id']?>" <?php if($player_data['activity_id']==$row['id']) { echo "selected"; } ?>><?=$row['activity']?></option>
                            <?php endforeach; ?>
						</select>
					</label>
						<input type="text" name="activity_other" value="<?=$player_data['activity_other']?>" />
	
					<label>
						<select name="how_id" id="how_id">
							<option value="0">- Seleccione -</option>
                            <?php foreach($how_id as $row): ?>
                            <option value="<?=$row['id']?>" <?php if($player_data['how_id']==$row['id']) { echo "selected"; } ?>><?=$row['how']?></option>
                            <?php endforeach; ?>
						</select>
					</label>
						<input type="text" name="confirmation_card" id="confirmation_card" value="<?=$player_data['confirmation_card']?>"/>
						<input type="hidden" name="how" value="<?=$player_data['how']?>>">
				</div>
			  	 <div class="tak_botones"><input value="Cancelar" type="reset" class="tak_cancelar" /><input value="Guardar cambios" type="submit" class="tak_guardarcambios" href="#"/></div>
				
		
        </div>
        		<audio id="beep-trhee" controls="controls" preload="auto">
                    <source src="audio/126418__cabeeno-rossley__button-select.wav"></source>
                    <source src="audio/126418__cabeeno-rossley__button-select.mp3"></source>
                </audio>
				<script>
				
					$(".tak_guardar_avatar,.tak_registrate2, .siavatar, .no_avatar").each(function(i) {
						if (i != 0) { 
							$("#beep-trhee").clone().attr("id", "beep-trhee" + i).appendTo($(this).parent()); 
						}
						$(this).data("beeper", i);
					}).mouseenter(function() {
						$("#beep-trhee" + $(this).data("beeper"))[0].play();
					});
					$("#beep-trhee").attr("id", "beep-trhee0");
					
	          </script>
        	
      </div>	
   </div>
   </form>