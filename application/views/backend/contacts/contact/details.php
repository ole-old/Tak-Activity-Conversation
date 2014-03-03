<div id="modal-container">
	<h3><?=__('Contacto')?></h3>
	<form id="modal-form" action="/admin/contacts/contact/details" method="post">
		<fieldset>
			<input type="hidden" name="id" value="<?=$data['id']?>" />
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h4><?=__('Detalle de contacto')?></h4>
			<dl>
				<dt><?=__('Nombre')?></dt>
				<dd><?=HTML::chars($data['fullname'])?></dd>
				<dt><?=__('Email')?></dt>
				<dd><a href="mailto:<?=HTML::chars($data['email'])?>"><?=HTML::chars($data['email'])?></a></dd>
				<dt><?=__('Mensaje')?></dt>
				<dd><?=HTML::chars($data['message'])?></dd>
				<dt><?=__('Fecha')?></dt>
				<dd><?=HTML::chars($data['datereg'])?></dd>
			</dl>
			<!--
			<div class="buttons">
				<a href="#" class="delete"><span><?=__('Delete')?></span></a>
			</div>
			-->
		</fieldset>
	</form>
</div>