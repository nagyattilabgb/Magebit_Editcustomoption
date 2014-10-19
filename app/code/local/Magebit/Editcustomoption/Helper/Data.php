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
	class Magebit_Editcustomoption_Helper_Data extends Mage_Core_Helper_Abstract {

		/**
		 * build price html
		 * @param  string $price
		 * @return  string
		 */
		public function getPriceHtml( $price ) {

			$currency    = Mage::app()->getLocale()->currency( Mage::app()->getStore()->getCurrentCurrencyCode() )->getSymbol();
			$priceFormat = number_format( $price, '2', '.', '2' );

			return $currency.$priceFormat;
		}
	}