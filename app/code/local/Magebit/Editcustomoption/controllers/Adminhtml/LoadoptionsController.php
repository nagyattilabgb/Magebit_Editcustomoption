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
	class Magebit_Editcustomoption_Adminhtml_LoadoptionsController extends Mage_Adminhtml_Controller_Action {

		public function indexAction() {

			$this->loadLayout( FALSE );
			$this->renderLayout();

		}

		/**
		 * updating item custom options
		 *
		 */
		public function saveAction() {

			$post = $this->getRequest()->getParams();
			//echo "POST<pre>"; print_r($post); echo "</pre>";
			$order       = Mage::getModel( 'sales/order' )->load( $post['order_id'] );
			$product     = Mage::getModel( 'catalog/product' )->load( $post['product_id'] );
			$prodOptions = $product->getOptions();

			# loop through order items
			foreach( $order->getAllItems() as $item ) {
				# if item is the edited item
				if( $item->getProductId() == $post['product_id'] ) {
					$selectedOptions = $item->getProductOptions();
//echo "BEFORE<pre>"; print_r($selectedOptions); echo "</pre>";
					# loop through posted custom options
					foreach( $post['options'] as $optionId => $optionValueId ) {
						# if posted option is in product options array
						if( array_key_exists( $optionId, $selectedOptions['info_buyRequest']['options'] ) ) {
							$selectedOptions['info_buyRequest']['options'][$optionId] = $optionValueId;
						}
						# loop through product custom option options
						foreach( $selectedOptions['options'] as $k => $optionData ) {
							# if product custom option id = posted custom option id
							if( $optionData['option_id'] == $optionId ) {
								if( is_array( $optionValueId ) ) {
									$selectedOptions['options'][$k]['value']        = $selectedOptions['options'][$k]['print_value'] = '';
									$selectedOptions['options'][$k]['option_value'] = implode( ',', $optionValueId );
								}
								else
									$selectedOptions['options'][$k]['option_value'] = $optionValueId;

								foreach( $prodOptions as $optionKey => $optionVal ) {

									if( $optionKey == $optionId ) {
										foreach( $optionVal->getValues() as $valuesKey => $valuesVal ) {

											if( is_array( $optionValueId ) ) {
												if( in_array( $valuesKey, $optionValueId ) ) {
													$selectedOptions['options'][$k]['value'] .= $valuesVal->getTitle().',';
													$selectedOptions['options'][$k]['print_value'] .= $valuesVal->getTitle().',';
												}
											}
											else {
												if( $valuesKey == $optionValueId ) {
													$selectedOptions['options'][$k]['value']       = $valuesVal->getTitle();
													$selectedOptions['options'][$k]['print_value'] = $valuesVal->getTitle();
												}
											}

										}
									}
								}

							}
							if( substr( $selectedOptions['options'][$k]['value'], -1 ) == ',' ) {
								$selectedOptions['options'][$k]['value']       = rtrim( $selectedOptions['options'][$k]['value'], ',' );
								$selectedOptions['options'][$k]['print_value'] = rtrim( $selectedOptions['options'][$k]['print_value'], ',' );
							}
						}
					}
//echo "AFTER<pre>"; print_r($selectedOptions); echo "</pre>";die();
					$item->setProductOptions( $selectedOptions );
					try {
						$item->save();
						$message = 'Product - '.$product->getName().' - custom option(s) were updated successfully!';
						Mage::getSingleton( 'adminhtml/session' )->addSuccess( $message );

					}
					catch( Exception $e ) {
						$message = 'Product - '.$product->getName().' - custom option(s) were not saved!';
						Mage::getSingleton( 'adminhtml/session' )->addError( $message );
					}
				}
			}
			Mage::app()->getResponse()->setRedirect( Mage::helper( 'adminhtml' )->getUrl( "adminhtml/sales_order/view", array( 'order_id' => $post['order_id'] ) ) );

		}
	}