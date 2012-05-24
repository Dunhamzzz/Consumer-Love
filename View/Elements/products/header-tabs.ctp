<div class="tab-list-wrapper">
    <ul class="product-tabs tabs" style="background-image: url(<?php echo $this->Love->productImage($product, 32, true); ?>);">
        <?php if ($current == 'overview'): ?>
            <li class="overview ui-tabs-selected">
                <span><?php echo $product['Product']['name']; ?></span>
            </li>
        <?php else: ?>
            <li class="overview">
                <?php echo $this->Link->product($product); ?>
            </li>
        <?php endif; ?>
        <?php if ($current == 'forum'): ?>
            <li class="ui-tabs-selected">
                <span><?php echo __('Forum'); ?></span>
            <?php else: ?>
            <li><?php echo $this->Link->forum($product, __('Forum')); ?></li>
        <?php endif; ?>

        <?php if ($current == 'gallery'): ?>
            <li class="ui-tabs-selected">
                <span><?php echo __('Gallery'); ?></span>
            <?php else: ?>
            <li><?php echo $this->Link->gallery($product, __('Gallery')); ?></li>
        <?php endif; ?>

        <?php if ($current == 'reviews'): ?>
            <li class="ui-tabs-selected">
                <span><?php echo __('Reviews'); ?></span>
            <?php else: ?>
            <li><?php echo $this->Link->reviews($product, __('Reviews')); ?></li>
        <?php endif; ?>
    </ul>
</div>