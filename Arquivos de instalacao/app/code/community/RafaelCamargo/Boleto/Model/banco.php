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

class RafaelCamargo_Boleto_Model_banco
{

    public function toOptionArray()
    {
        return array(
		    array('value'=>'bb', 'label'=>Mage::helper('adminhtml')->__('Banco do Brasil')),
			array('value'=>'bradesco', 'label'=>Mage::helper('adminhtml')->__('Bradesco')),
			array('value'=>'cef', 'label'=>Mage::helper('adminhtml')->__('Caixa Economica Federal')),
			array('value'=>'cef_sinco', 'label'=>Mage::helper('adminhtml')->__('Caixa Economica Federal Sinco')),
			array('value'=>'hsbc', 'label'=>Mage::helper('adminhtml')->__('HSBC')),
			array('value'=>'itau', 'label'=>Mage::helper('adminhtml')->__('Itau')),
            array('value'=>'santander_banespa', 'label'=>Mage::helper('adminhtml')->__('Santander')),
            array('value'=>'sudameris', 'label'=>Mage::helper('adminhtml')->__('Sudameris')),
        );
    }

}
