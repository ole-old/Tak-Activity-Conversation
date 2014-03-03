<table border="1">
	<tr>
		<th>Nombre</th>
		<th>Email</th>
		<th>Mensaje</th>
		<th>Fecha</th>
	</tr>
<?php
foreach($data as $dat){
?>
	<tr>
		<td><?=HTML::chars($dat['fullname'])?></td>
		<td><a href="mailto:<?=HTML::chars($dat['email'])?>"><?=HTML::chars($dat['email'])?></a></td>
		<td><?=HTML::chars($dat['message'])?></td>
		<td><?=HTML::chars($dat['datereg'])?></td>
	</tr>
<?php
}
?>
</table>
