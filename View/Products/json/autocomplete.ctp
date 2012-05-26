<?php
/**
 * Formats product data for jQueryUI autocomplete:
 * 
 *  {
 *       value: "jquery",
 *       label: "jQuery",
 *       desc: "the write less, do more, JavaScript library",
 *       icon: "jquery_32x32.png"
 *   },
 */
if(!empty($products)) {
 
    $autocompleteArray = array();
    
    foreach($products as $product) {
        $autocompleteArray[] = array(
            'id' => $product['Product']['id'],
            'label' => $product['Product']['name'],
            'value' => $product['Product']['name'],
            'logo' => $this->Love->productImage($product, 32, true)
        );
    }
    
    echo json_encode($autocompleteArray);
}