<?php
$this->Paginator->options(array('update' => '#content'));
?><p class="pagination">
	<?php echo $this->Paginator->prev('<< previous', array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
 |
	<?php echo $this->Paginator->next('next >>', array(), null, array('class' => 'disabled'));?>
</p>