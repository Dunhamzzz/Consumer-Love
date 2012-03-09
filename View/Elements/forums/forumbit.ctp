<tr>
    <td>
        <?php echo $this->Link->forum($product, $this->Love->productImage($product) . $product['Product']['name'], array('escape' => false)); ?>
    </td>
    <td>
        <?php echo $product['Product']['thread_count']; ?>
    </td>
</tr>