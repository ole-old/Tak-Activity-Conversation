<script src="assets/scripts/jquery_tools.js" type="text/javascript"></script>
<script src="assets/scripts/jquery.lightbox_me.js" type="text/javascript"></script> 
<script type="text/javascript" src="assets/scripts/jquery.jcarousel.min.js"></script>

<script type="text/javascript">

	function mycarousel_initCallback(carousel) {
	
		$('.jcarousel-control a').bind('click', function(){
		
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
		
		$('#mycarousel-next').bind('click', function(){
		
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
				$("#caso_" + avatar).addClass("	tag_seleccionado");
				$("#caso_" + (avatar + 1)).removeClass("tag_seleccionado");
			}
			return false;
		});
		
	};
	
	$(document).ready(function(){

		var existeUsuario = false;
	
		//term and conditions
		$('a.terms').click(function(){
			$(".div_terms").lightbox_me({centered: true});
		});
		
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
				centered: true
			});
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
				
				if( $(this).hasClass("required_checkbox") && !$(this).attr('checked') ){
					alert($(this).attr('alt'));
					$(this).focus();
					error = true;
					return false;
				}
				
				if( $('#terms2').attr('checked') || $('#terms3').attr('checked') ){
				} else {
					alert('Debes aceptar que eres mayor de edad o que tienes el consentimiento de tus padres');
					$(this).focus();
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
				
			});
			
			if(error){
				$("p.warning-text").fadeIn();
			}

			if(!existeUsuario){
				return !error;
			}
			
		});
		
		$('#username').keyup(function() {
			var $th = $(this);
			$th.val( $th.val().replace(/[^a-zA-Z0-9.]/g, function(str) { alert('Escribiste " ' + str + ' ".\n\nAmig@ sólo escribe con letras y números.'); return ''; } ) );
		});
		
		$('#password').keyup(function() {
			var $th = $(this);
			$th.val( $th.val().replace(/[^a-zA-Z0-9]/g, function(str) { alert('Escribiste " ' + str + ' ".\n\nAmig@ sólo escribe con letras y números.'); return ''; } ) );
		});
		
		$('#password_conf').keyup(function() {
			var $th = $(this);
			$th.val( $th.val().replace(/[^a-zA-Z0-9]/g, function(str) { alert('Escribiste " ' + str + ' ".\n\nAmig@ sólo escribe con letras y números.'); return ''; } ) );
		});

		$('#username').focusout(function(){
			
			$.post('validateUsername',{
				username: $(this).val()
		    },function(data) {
			    if(data==1){
				    existeUsuario = true;
				    $('#username').val("");
				    $("#lbl_username").fadeIn();
				    setTimeout(function(){
				    	$("#lbl_username").fadeOut();
					},3000);
			    }else{
			    	existeUsuario = false;
			    }
			});
			
		});
		
	});
</script>

<div class="div_terms">
	<a class="cerrar" href="#"></a>
	<div class="txt_terms"><?=$terms['content']?></div>
</div>

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
				
				<script>
				
					$("#mycarousel-prev, #mycarousel-next, .jcarousel-control a").each(function(i) {
						if (i != 0){
							$("#beep-two").clone().attr("id", "beep-two" + i).appendTo($(this).parent()); 
						}
						$(this).data("beeper", i);
					}).mouseenter(function() {
						$("#beep-two" + $(this).data("beeper"))[0].play();
					});
					
					$("#beep-two").attr("id", "beep-two0");
					
				</script>
				
			</div>
		</div>
		<a href="javascript:void(0);" class="tak_guardar_avatar">Guardar avatar</a>
	</div>
	
	<div class="tak_contenido">
	
		<div class="tak_registro">
		
			<h1>Reg&iacute;strate</h1>
			<p>Crea tu propia cuenta para empezar a jugar. Introduce un nombre que te guste donde dice USUARIO y una clave secreta en donde dice CONTRASE&Ntilde;A. 
			An&oacute;tala en un lugar seguro, que puedas consultar si se te llegara a olvidar. Para terminar, elige una mascota, un color y un fruta, y si quieres 
			tu avatar. Al terminar haz click en REG&Iacute;STRATE.</p>
			
			<div class="tak_formulario">
			
				<h2>Llena los datos</h2>
				<ul> 
					<li><span>Datos obligatorios</span> </li>
					<li>Usuario / Apodo</li>
					<li>Contrase&ntilde;a</li>
					<li>Repite tu contrase&ntilde;a</li>
					<li>Elige una mascota</li>
					<li>Elige un color</li>
					<li>Elige una fruta</li>
					<li>Elige tu avatar</li>
					<li>Le&iacute; y estoy de acuerdo con los t&eacute;rminos y condiciones del <b>Aviso de privacidad</b>, y de la protecci&oacute;n y uso de mis datos.</li>
					<li>Si eres menor de edad, necesitas el consentimiento de tus pap&aacute;s o tutores.</li>
				</ul>
				<div>
					<form id="frm_register" action="registro" method="post" class="validate">
						<input type="hidden" id="avatar_seleccionado" name="avatar" value="1" />
						<input type="text" id="username" name="username" value="<?=$data['username']?>" class="required" title="Escribe tu usuario/apodo" maxlength="16" />
						<span class="error" id="lbl_username" style="display:none;">El usuario ya existe, favor de elegir otro</span>
						<input type="password" id="password" name="password" class="required" title="Escribe tu contraseÃ±a" maxlength="16" />
						<input type="password" id="password_conf" name="password_conf" class="required" title="Repite tu contraseÃ±a" maxlength="16" />
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
						<table class="tak_ninonina" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="4">
									<a  class="siavatar" href="javascript:void(0);">S&iacute; </a>
								</td>
							</tr>
							<tr>
								<td>
									<table style="margin-top: 20px;">
										<tr>
											<td><input type="checkbox" name="terms" value="1" class="required_checkbox" alt="Lee y acepta el aviso de privacidad"></td>
											<td>S&iacute;, <a href="javascript:void(0);" class="terms" style="color: #555555; text-decoration: underline;">Ver aviso de privacidad</a></td>
										</tr>
									</table>
									<table style="margin-top: 90px;">
										<tr>
											<td><input type="radio" id="terms2" name="terms2" value="1" alt="Tengo el consentimiento de mis papÃ¡s o tutores"></td>
											<td>Tengo el consentimiento de mis pap&aacute;s o tutores</td>
										</tr>
										<tr>
											<td><input type="radio" id="terms3" name="terms2" value="1"  alt="Soy mayor de edad"></td>
											<td>Soy mayor de edad</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</form>		   
				</div>
				
				<audio id="beep-trhee" controls="controls" preload="auto">
					<source src="assets/audio/126418__cabeeno-rossley__button-select.wav"></source>
					<source src="assets/audio/126418__cabeeno-rossley__button-select.mp3"></source>
				</audio>
				
				<script>
				
					$(".tak_guardar_avatar,.tak_registrate2, .siavatar, .no_avatar").each(function(i){
					
						if (i != 0){
							$("#beep-trhee").clone().attr("id", "beep-trhee" + i).appendTo($(this).parent()); 
						}
						$(this).data("beeper", i);
						
					}).mouseenter(function() {
						$("#beep-trhee" + $(this).data("beeper"))[0].play();
					});
					
					$("#beep-trhee").attr("id", "beep-trhee0");
					
				</script>
				
			</div>
			
			<a class="tak_registrate2" href="javascript:void(0);" onclick="$('#frm_register').submit();">Guardar datos</a>
			
		</div>

	</div>
	
</div>