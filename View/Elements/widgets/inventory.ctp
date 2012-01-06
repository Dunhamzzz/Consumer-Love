<h3>Your Inventory <span><?php echo $this->Link->inventory($userData, $userData['inventory_count']); ?></span></h3>
<?php if (!empty($inventory)): ?>
    <div class="product-icon-list">
        <?php foreach ($inventory as $product): ?>
            <?php echo $this->Link->product($product, $this->Love->productImage($product, 32, false), array('escape' => false, 'title' => $product['name'])); ?>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Nothing in your inventory!</p>
<?php endif; ?>