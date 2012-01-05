<?php

/**
 * Custom helper for Consumer Love <3
 * @author Matthew Dunham
 *
 */
class LoveHelper extends AppHelper {

    public $helpers = array('Html', 'Text', 'Link');

    public function inventoryButton($productId, $inInventory = false) {
        return $this->Html->link(
                        '<span class="icon"></span> <span class="toggle-text">Inventory</span>', array('controller' => 'inventories', 'action' => 'toggle', $productId), array('class' => 'toggle-inventory cta' . ($inInventory ? ' in' : ''), 'escape' => false)
        );
    }

    /**
     * Returns a string based on an integer. Use {n} to denote the string.
     */
    public function plural($num, $none, $single, $plural) {

        switch ($num) {
            case 0:
                $string = $none;
                break;
            case 1:
                $string = $single;
                break;
            default:
                $string = $plural;
        }

        return str_replace('{n}', $num, $string);
    }

    // Returns a product image
    public function productImage($product, $size = 32, $url = false, $htmlAttrs = array()) {
        $product = $this->extractProduct($product);

        if ($url) {
            return '/files/product/logo/' . $product['id'] . '/' . $size . 'x' . $size . '_' . $product['logo'];
        } else {
            return '<span 
                        class="product-logo s' . $size . '"
                        style="background-image: url(/files/product/logo/' . $product['id'] . '/' . $size . 'x' . $size . '_' . $product['logo'] . ')"
                    ></span>';
        }
    }

    // Returns a list of categories a product is in.
    public function listProductCategories($product) {
        $categoryList = array();
        foreach ($product['Category'] as $category) {
            $categoryList[] = $this->Link->category($category);
        }

        return $this->Text->toList($categoryList);
    }

    /**
     * Get age from dob mysql date
     */
    public function age($dob) {
        $dobStamp = strtotime($dob);
        if ($dob < 0 || $dob === '0000-00-00') {
            return false;
        }
        $t = time();
        $age = ($dobStamp < 0) ? ( $t + ($dobStamp * -1) ) : $t - $dobStamp;
        return (int) floor($age / 31536000);
    }

    // Wrappers for extractRow()
    private function extractUser($user) {
        return $this->extractRow('User', $user);
    }

    private function extractProduct($product) {
        return $this->extractRow('Product', $product);
    }

    private function extractCategory($category) {
        return $this->extractRow('Category', $category);
    }

}