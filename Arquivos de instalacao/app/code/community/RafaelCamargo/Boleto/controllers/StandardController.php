<?php
/**
 * Short description
 *
 * Long description
 *
 * Baseado no módulo original Cushy_Boleto de Renan Gonçalves <renan.saddam@gmail.com>
 * Copyright 2012, Rafael Camargo <desbloqueio@terra.com.br>
 * Licensed under The MIT License
 * Redistributions of files must retain the copyright notice.
 *
 * @copyright       Copyright 2012, Rafael Camargo 
 * @category        Boleto_Rafael
 * @package         RafaelCamargo_Boleto
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class RafaelCamargo_Boleto_StandardController extends Mage_Core_Controller_Front_Action {
	
	protected $_method;

	public function viewAction() {
		if (!$this->_loadValidOrder()) {
			return false;
		}

		$dadosboleto = Mage::getModel('boleto/standard')->prepareValues();
		foreach ($dadosboleto as $key => $value) {
			$dadosboleto[$key] = utf8_decode($value);
		}
$nomebanco = Mage::getStoreConfig('payment/boleto_bancario/banconome');
		$path = BP . DS . 'skin' . DS . 'boletophp' . DS . 'include' . DS;
		ob_start();
			include $path . 'funcoes_' . $nomebanco . '.php';
			include $path . 'layout_' . $nomebanco . '.php';
		$content = ob_get_clean();

		$url = preg_replace('/index\.php\/$/', '', Mage::getUrl('/')) . 'skin/boletophp/';
		$content = str_ireplace(array('src=imagens', 'src="imagens'), array('src=' . $url . 'imagens', 'src="' . $url . 'imagens'), $content);
		$content = str_ireplace('<body', '<body onload="window.print();"', $content);


		echo $content;
		exit;
	}

	protected function _loadValidOrder($orderId = null) {
		if ($orderId == null) {
			$orderId = (int) $this->getRequest()->getParam('order_id');
		}
		if (!$orderId) {
			$this->_forward('noRoute');
			return false;
		}

		$order = Mage::getModel('sales/order')->load($orderId);
		if ($this->_canViewOrder($order)) {
			Mage::register('current_order', $order);
			return true;
		} else {
			$this->_redirect('sales/order/view/order_id/'.$orderId);
			return false;
		}
	}

	 
	protected function _canViewOrder($order) {
		$customerId = Mage::getSingleton('customer/session')->getCustomerId();
		$availableStates = Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates();
		$method = $order->getPayment()->getMethod();
		$nomebanco = Mage::getStoreConfig('payment/boleto_bancario/banconome');
		if ($order->getCustomerId() == $customerId && in_array($order->getState(), $availableStates, true) && strpos($method, 'boleto_') !== false) {
			$this->_method = $nomebanco;
			return true;
		}
		return false;
	}
	//Segunda via Admin
	public function adminViewAction() {
    if (!$this->_loadValidOrderAdmin()) {
        return false;
    }
 
    $dadosboleto = Mage::getModel('boleto/standard')->prepareValues();
		foreach ($dadosboleto as $key => $value) {
			$dadosboleto[$key] = utf8_decode($value);
		}
 
    $path = BP . DS . 'skin' . DS . 'boletophp' . DS . 'include' . DS;
    ob_start();
	$nomebanco = Mage::getStoreConfig('payment/boleto_bancario/banconome');
        include $path . 'funcoes_' . $nomebanco . '.php';
        include $path . 'layout_' . $nomebanco . '.php';
    $content = ob_get_clean();
 
    $url = preg_replace('/index\.php\/$/', '', Mage::getUrl('/')) . 'skin/boletophp/';
		$content = str_ireplace(array('src=imagens', 'src="imagens'), array('src=' . $url . 'imagens', 'src="' . $url . 'imagens'), $content);
		$content = str_ireplace('<body', '<body onload="window.print();"', $content);
 
    echo $content;
    exit;
}
 
protected function _loadValidOrderAdmin($orderId = null) {
    if ($orderId == null) {
        $orderId = (int) $this->getRequest()->getParam('order_id');
    }
    if (!$orderId) {
        $this->_forward('noRoute');
        return false;
    }
 
    $order = Mage::getModel('sales/order')->load($orderId);
    if ($this->_canViewOrderAdmin($order)) {
        Mage::register('current_order', $order);
        if (!$order->getCustomerId()) true;
        $customer = Mage::getModel('customer/customer')->load( $order->getCustomerId());
        Mage::register('order_customer', $customer);
        return true;
    } else {
        $this->_redirect('/sales_order/view');
        return false;
    }
}
 
protected function _canViewOrderAdmin($order) {
    $availableStates = Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates();
    $method = $order->getPayment()->getMethod();
	$nomebanco = Mage::getStoreConfig('payment/boleto_bancario/banconome');
    if (in_array($order->getState(), $availableStates, true) && strpos($method, 'boleto_') !== false) {
        $this->_method = $nomebanco;
        return true;
    }
    return false;
}
}