<aside>
    <h3><?php echo $this->Link->Product($product, $this->Love->productImage($product, 32) . $product['Product']['name'], array('escape' => false)); ?></h3>
    <?php if (isset($userData) && $inventory): ?>
        <?php echo $this->element('products/vote'); ?>
    <?php endif; ?>
    <dl>
        <dt><a title="Click to find out how we work out a products popularity on Consumer Love">Popularity</a></dt>
        <?php if($product['Product']['inventory_count'] > 0) :?>
            <dd class="love"><?php echo round($product['Product']['love_count'] / $product['Product']['inventory_count'] *100); ?>% Love it</dd>
            <dd class="hate"><?php echo round($product['Product']['hate_count'] / $product['Product']['inventory_count'] *100); ?>% Hate it</dd>
            <dd><?php echo($product['Product']['inventory_count'] - $product['Product']['love_count'] -$product['Product']['hate_count']);?> Indifferent</dd>
        <?php else: ?>
        <dd><em>No Users!</em></dd>
        <?php endif; ?>
        <dt>Users</dt>
        <dd><?php
    echo $this->Html->link($product['Product']['inventory_count'], array('controller' => 'products', 'action' => 'users', 'productSlug' => $product['Product']['slug']), array('class' => 'num-products'));
    ?>
        </dd>
        <dt>Categories</dt>
        <dd><?php echo $this->Love->listProductCategories($product); ?></dd>
        <?php if (!empty($product['Product']['website_url'])) : ?>
            <dt>Website</dt>
            <dd><?php echo $this->Html->link($product['Product']['website_url'], $product['Product']['website_url']); ?></dd>
        <?php endif; ?>
        <?php if (!empty($product['Product']['twitter'])) : ?>
            <dt>Twitter</dt>
            <dd><?php echo $this->Html->link('@' . $product['Product']['twitter'], 'http://www.twitter.com/' . $product['Product']['twitter']); ?>
            <?php endif; ?>
    </dl>
</aside>