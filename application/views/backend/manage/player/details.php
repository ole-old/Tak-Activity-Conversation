<div id="modal-container">
	<h3><?=__('User details')?></h3>
	<form id="modal-form" action="/admin/manage/<?=$controller?>/details" method="post">
		<fieldset>
			<input type="hidden" name="id" value="<?=$dbdata['id']?>" />
			<input type="hidden" name="csrf_token" value="<?=Security::token()?>" />
			<h4><?=__('Player data')?></h4>
			<dl>
				<dt><?=__('ID')?></dt>
				<dd><?=HTML::chars($dbdata['id'])?></dd>
				<dt><?=__('Escuela')?></dt>
				<dd><?=HTML::chars($dbdata['title'])?></dd>
				<dt><?=__('Grado')?></dt>
				<dd><?=HTML::chars($dbdata['school_year_id'])?></dd>
				<dt><?=__('Username')?></dt>
				<dd><?=HTML::chars($dbdata['username'])?></dd>
				<dt><?=__('Respuesta 1')?></dt>
				<dd><?=HTML::chars($dbdata['answer1'])?></dd>
				<dt><?=__('Respuesta 2')?></dt>
				<dd><?=HTML::chars($dbdata['answer2'])?></dd>
				<dt><?=__('Respuesta 3')?></dt>
				<dd><?=HTML::chars($dbdata['answer3'])?></dd>
				<dt><?=__('Avatar')?></dt>
				<dd><?=HTML::chars($dbdata['avatar'])?></dd>
				<dt><?=__('Cumpleaños')?></dt>
				<dd><?=HTML::chars($dbdata['birthday'])?></dd>
				<dt><?=__('Nombre')?></dt>
				<dd><?=HTML::chars($dbdata['fullname'])?></dd>
				<dt><?=__('Email')?></dt>
				<dd><?=HTML::chars($dbdata['email'])?></dd>
				<dt><?=__('Sexo')?></dt>
				<dd><?=HTML::chars($dbdata['gender'])?></dd>
				<dt><?=__('CURP')?></dt>
				<dd><?=HTML::chars($dbdata['curp'])?></dd>
				<dt><?=__('Assignature')?></dt>
				<dd><?=HTML::chars($dbdata['assignature_id'])?></dd>
				<dt><?=__('Assignature other')?></dt>
				<dd><?=HTML::chars($dbdata['assignature_other'])?></dd>
				<dt><?=__('Activity')?></dt>
				<dd><?=HTML::chars($dbdata['activity_id'])?></dd>
				<dt><?=__('Activity other')?></dt>
				<dd><?=HTML::chars($dbdata['activity_other'])?></dd>
				<dt><?=__('Year other')?></dt>
				<dd><?=HTML::chars($dbdata['school_year_other'])?></dd>
				<dt><?=__('Como se entero')?></dt>
				<dd><?=HTML::chars($dbdata['how'])?></dd>
				<dt><?=__('Fecha de registro')?></dt>
				<dd><?=HTML::chars($dbdata['date_register'])?></dd>
				<dt><?=__('Score total')?></dt>
				<dd><?=HTML::chars($dbdata['total_score'])?></dd>
				<dt><?=__('Status')?></dt>
				<dd><?=Lookup::name('status', $dbdata['status'])?></dd>

			</dl>
			<!--
			<h4><?=__('SMS Prizes')?></h4>
			<dl>
			</dl>
			<h4><?=__('Today\'s games')?></h4>
			<dl>
			</dl>
			-->
			<div class="buttons">
				<a href="#" class="delete"><span><?=__('Delete')?></span></a>
			</div>
		</fieldset>
	</form>
</div>