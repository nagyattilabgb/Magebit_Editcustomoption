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
	class Magebit_Editcustomoption_Block_Adminhtml_Sales_Order_View_Items_Renderer_Default extends
		Mage_Adminhtml_Block_Sales_Order_View_Items_Renderer_Default {

		/**
		 * check if custom option Edit button can be displayed
		 *
		 * @return  boolean
		 */
		public function canDisplayButton() {

			if( !$this->getItem() ) {
				return '';
			}

			$_item       = $this->getItem();
			$_product    = $_item->getProduct();
			$productType = $_item->getProductType();
			$hasOptions  = $_product->getHasOptions();
			if( $productType == 'simple' && !$_item->getParentItem() && $hasOptions ) {
				return TRUE;
			}
			else {
				return FALSE;
			}

		}

	}
