<?php
// Inline Form for editing posts
echo $this->Form->create('Post', array('class' => 'inline-form post'));
echo $this->Form->input('id');
echo $this->Form->input('thread_id', array('type' => 'hidden', 'value' => $thread['Thread']['id']));
echo $this->Form->input('content', array('label' => false));
?>
<div class="inline-form-submit">
    <?php
    echo $this->Form->button('Cancel', arraY('class' => 'button'));
    echo $this->Form->submit('Submit', array('class' => 'cta', 'div' => false));
    echo $this->Form->end();
    ?>
</div>