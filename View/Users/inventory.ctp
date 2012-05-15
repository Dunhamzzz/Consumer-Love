<?php echo $this->Html->script('jquery.inifinitescroll', array('inline' => false)); ?>
<h1><?php echo $title_for_layout; ?></h1>
<?php if (isset($privateInventory)): ?>
    <p><strong><?php echo $user['User']['username']; ?></strong> has set their inventory to private.</p>
<?php else: ?>
    <?php if (isset($userData) && $userData['id'] == $user['User']['id']): ?>
        <p><?php
        echo $this->Paginator->counter(array(
            'format' => 'You have %count% items in your inventory.'
        ));
        ?></p>
        <?php else: ?>
        <p><?php
        echo $user['User']['username'] . $this->Paginator->counter(array(
            'format' => ' has %count% items in their inventory.'
        ));
            ?></p>
            <?php endif; ?>
    <div class="products-list inventory-list">
            <?php foreach ($products as $product): ?>
            <div class="product" data-id="<?php echo $product['Product']['slug']; ?>">
                    <?php echo $this->Love->productImage($product); ?>
                <h2><?php echo $this->Link->product($product); ?></h2>
                    <?php if (isset($userData) && $userData['id'] == $user['User']['id']): ?>
                    <div class="inventory-options">
                        <?php
                        echo $this->Html->link(
                                'Remove', array('controller' => 'inventories', 'action' => 'remove', $product['Product']['id']), array('class' => 'remove')
                        );
                        ?>
                    </div>
        <?php endif; ?>
            </div>
    <?php endforeach; ?>
    </div>
    <?php echo $this->element('pagination/basic'); ?>
<?php endif; ?>
