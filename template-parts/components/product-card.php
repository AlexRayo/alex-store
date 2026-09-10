<?php
/**
 * Product Card Template Part
 *
 * @package AlexStore
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

if (empty($product) || !is_a($product, 'WC_Product')) {
    return;
}

echo alex_store_product_card($product);
