<?php

	/**
	 * Magebit_Editcustomoption
	 *
	 * Magento extension
	 *
	 * NOTICE OF LICENSE
	 * Magento is subject to the Open Software License (OSL 3.0)
	 *
	 * @author      Nagy Attila<nagyattila.dev@gmail.com>
	 * @category    Magebit
	 * @package     Magebit_Editcustomoption
	 * @copyright
	 * @link
	 * @license
	 * @version     0.1.0
	 */
	class Magebit_Editcustomoption_Block_Adminhtml_Loadoptions extends Mage_Adminhtml_Block_Template {


		/**
		 * Load product object
		 *
		 * @return  object
		 */
		public function loadProduct() {

			$post      = $this->getRequest()->getPost();
			$productId = $post['prodId'];
			$product   = FALSE;
			if( $productId )
				$product = Mage::getModel( "catalog/product" )->load( $productId );

			return $product;
		}

		/**
		 * Load order object
		 *
		 * @return  object
		 */
		public function loadOrder() {

			$post    = $this->getRequest()->getPost();
			$orderId = $post['orderId'];
			$order   = FALSE;
			if( $orderId )
				$order = Mage::getModel( 'sales/order' )->load( $orderId );

			return $order;
		}

	}