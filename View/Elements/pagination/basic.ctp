<?php
$this->Paginator->options(array('update' => '#content'));
?><div class="pagination <?php echo isset($class) ? $class : '';?>">
    <?php 
        echo $this->Paginator->prev('<< Previous', array('class' => 'btn prev'), null, array('class'=>'btn prev disabled'));
        echo $this->Paginator->numbers(array(
            'class' => 'btn',
            'separator' => null
        ));
        echo $this->Paginator->next('Next >>', array('class' => 'btn next'), null, array('class' => 'btn next disabled'));
    ?>
</div>