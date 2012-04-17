<li style="background-image: url(<?php echo $this->Love->productImage($product, 32, true); ?>);">
    <h3><?php echo $this->Link->forum($product, $product['Product']['name']); ?></h3>
    <p class="description"><?php echo $this->Text->truncate($product['Product']['description_formatted']); ?></p>
</li>