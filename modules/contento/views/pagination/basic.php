<?php if($total_items): ?>
<div class="pagination" id="pagination">
	<strong><?=$current_first_item?></strong> - <strong><?=$current_last_item?></strong> de <strong><?=$total_items?></strong>
	<?php if($total_pages>1): ?>
	<a href="#" id="anterior" class="prev<?php if(!$previous_page): ?> disabled<?php endif; ?>" data-page="<?=$previous_page?>" data-tooltip="Anterior">Anterior</a>
	<a href="#" id="siguiente" class="next<?php if(!$next_page): ?> disabled<?php endif; ?>" data-page="<?=$next_page?>" data-tooltip="Siguiente">Siguiente</a>
	<?php endif; ?>
</div>
<?php endif; ?>