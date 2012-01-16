<?php $escapedTerm = $this->Html->tag('strong', $term, array('escape' => true)); ?>
<div class="speech-arrow"></div>
<?php if (!empty($products)): ?>
    <p><strong><?php echo __('Matching Products'); ?></strong></p>
    <ul class="suggestions">
        <?php foreach ($products as $product): ?>
            <?php $inventoryCount = $this->Love->plural($product['Product']['inventory_count'], '', '1 user', '{n} users'); ?>
            <li><?php
        echo $this->Link->product(
                $product, $this->Love->productImage($product) . $product['Product']['name'] . '<span class="inventory-count">' . $inventoryCount . '</span>', array('escape' => false)
        );
            ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (!empty($categories)): ?>
    <p><strong><?php echo __('Matching Categories'); ?></strong></p>
    <ul class="suggestions basic">
        <?php foreach ($categories as $category) : ?>
            <?php $productCount = $this->Love->plural($category['Category']['product_count'], 'empty!', '1 product', '{n} products'); ?>
            <li><?php
        echo $this->Link->category(
                $category, $category['Category']['name'] . '<span class="inventory-count">' . $productCount . '</span>', array('escape' => false)
        );
            ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (empty($products) && empty($categories)) : ?>
    <p class="suggest-cta">We couldn't find anything called <?php echo $escapedTerm; ?>, but you can <?php echo $this->Html->Link('setup a new page here', array('controller' => 'products', 'action' => 'suggest', '?' => 'suggestion=' . $term)) ?>. </p>
<?php else: ?>
    <p class="suggest-cta">Not the <?php echo $escapedTerm; ?> you were looking for? <?php echo $this->Html->Link('Setup a new page here', array('controller' => 'products', 'action' => 'suggest', '?' => $term)) ?>.</p>
<?php endif; ?>