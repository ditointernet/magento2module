<?php

namespace Dito\Magento2module\Block;

class Product extends Magento2module
{

	/**
     * @return array
     */
    public function getProductData()
    {
		$productArray = array();
		$product = $this->registry->registry('current_product');

		$productArray['sku_produto'] = $product->getSku();
        $productArray['id_produto'] = $product->getId();
        $productArray['nome_produto'] = $product->getName();
        $productArray['image'] = $this->getImageHelper()->init($product, 'product_page_image_large')->resize(438)->getUrl();
		$productArray['product_url'] = $product->getProductUrl();
		$productArray['preco_produto'] = floatval($product->getPrice());
		$productArray['preco_final_produto'] = floatval($product->getFinalPrice());
		$productArray['preco_especial_produto'] = floatval($product->getSpecialPrice());


        $categoryIds   = $product->getCategoryIds();
        $categoryNames = [];
        $categories = $this->getCategoryCollection($categoryIds);
        foreach ($categories as $category) {
        	$categoryNames[] = $category->getName();
        }
        $productArray['categorias_produto'] = join(', ', $categoryNames);

        return $productArray;
	}
}