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
class RafaelCamargo_Boleto_Model_Standard extends Mage_Payment_Model_Method_Abstract {
protected $_code = 'boleto_bancario';
	public function prepareValues() {
		$order = Mage::registry('current_order');
		$address = $order->getBillingAddress();
		// Valores padrão
		$default = array(
			'nosso_numero' => $order->getIncrementId(),
			'numero_documento' => $order->getIncrementId(),
			'data_vencimento' => date('d/m/Y', time() + (Mage::getStoreConfig('payment/' . $this->_code . '/vencimento') * 86400)),
			'data_documento' => date('d/m/Y'),
			'data_processamento' => date('d/m/Y'),
			'valor_boleto' => number_format($order->getGrandTotal() + Mage::getStoreConfig('payment/' . $this->_code . '/valor_adicional'), 2, ',', ''),
			'valor_unitario' => number_format($order->getGrandTotal() + Mage::getStoreConfig('payment/' . $this->_code . '/valor_adicional'), 2, ',', ''),
			'sacado' => $address->getFirstname() . ' ' . $address->getLastname(),
			'endereco1' => implode(' ', $address->getStreet()),
			'endereco2' => $address->getCity() . ' - ' . $address->getRegion() . ' - CEP: ' . $address->getPostcode(),
			'identificacao' => Mage::getStoreConfig('payment/' . $this->_code . '/identificacao'),
			'cpf_cnpj' => Mage::getStoreConfig('payment/' . $this->_code . '/cpf_cnpj'),
			'endereco' => Mage::getStoreConfig('payment/' . $this->_code . '/endereco'),
			'cidade_uf' => Mage::getStoreConfig('payment/' . $this->_code . '/cidade_uf'),
			'cedente' => Mage::getStoreConfig('payment/' . $this->_code . '/cedente'),
			'agencia' => Mage::getStoreConfig('payment/' . $this->_code . '/agencia'),
			'agencia_dv' => Mage::getStoreConfig('payment/' . $this->_code . '/agencia_dv'),
			'conta' => Mage::getStoreConfig('payment/' . $this->_code . '/conta'),
			'conta_dv' => Mage::getStoreConfig('payment/' . $this->_code . '/conta_dv'),
			'carteira' => Mage::getStoreConfig('payment/' . $this->_code . '/carteira'),
			'carteira_descricao' => Mage::getStoreConfig('payment/' . $this->_code . '/carteira_descricao'),
			// Dados opcionais
			'especie' => Mage::getStoreConfig('payment/' . $this->_code . '/especie'),
			'especie_doc' => Mage::getStoreConfig('payment/' . $this->_code . '/especie_doc'),
			'aceite' => Mage::getStoreConfig('payment/' . $this->_code . '/aceite'),
			'quantidade' => Mage::getStoreConfig('payment/' . $this->_code . '/quantidade'),
			// Dados personalizados santander
			'codigo_cliente' => Mage::getStoreConfig('payment/' . $this->_code . '/codigo_cliente'),
			'ponto_venda' => Mage::getStoreConfig('payment/' . $this->_code . '/ponto_venda'),
			// Dados personalizados Bradesco
			'conta_cedente' => Mage::getStoreConfig('payment/' . $this->_code . '/conta_cedente'),
			'conta_cedente_dv' => Mage::getStoreConfig('payment/' . $this->_code . '/conta_cedente_dv'),
			// Dados personalizados Caixa Economica Federal
			'conta_cedente_caixa' => Mage::getStoreConfig('payment/' . $this->_code . '/conta_cedente_caixa'),
			'conta_cedente_dv_caixa' => Mage::getStoreConfig('payment/' . $this->_code . '/conta_cedente_dv_caixa'),
			'inicio_nosso_numero' => Mage::getStoreConfig('payment/' . $this->_code . '/inicio_nosso_numero'),
			// Dados personalizados Caixa Economica Federal Sinco
			'campo_fixo_obrigatorio' => '1',
			// Dados personalizados Banco do Brasil
			'convenio' => Mage::getStoreConfig('payment/' . $this->_code . '/convenio'),
			'contrato' => Mage::getStoreConfig('payment/' . $this->_code . '/contrato'),
			'variacao_carteira' => Mage::getStoreConfig('payment/' . $this->_code . '/variacao_carteira'),
			'formatacao_convenio' => Mage::getStoreConfig('payment/' . $this->_code . '/formatacao_convenio'),
			'formatacao_nosso_numero' => Mage::getStoreConfig('payment/' . $this->_code . '/formatacao_nosso_numero'),
			// Dados personalizados HSBC
			'codigo_cedente' => Mage::getStoreConfig('payment/' . $this->_code . '/codigo_cedente')
			
			
		);

		// Instruções
		$instrucoes = explode("\n", Mage::getStoreConfig('payment/' . $this->_code . '/instrucoes_boleto'));
		for ($i = 0; $i < 4; $i++) {
			$instrucao = isset($instrucoes[$i]) ? $instrucoes[$i] : '';
			$default['instrucoes' . ($i + 1)] = $instrucao;
		}

		// Informações Extras
		$info = sprintf(Mage::getStoreConfig('payment/' . $this->_code . '/informacoes'),$order->getIncrementId());
		$informacoes = explode("\n", $info);
		for ($i = 0; $i < 3; $i++) {
			$informacao = isset($informacoes[$i]) ? $informacoes[$i] : '';
			$default['demonstrativo' . ($i + 1)] = $informacao;
		}


		return $this->_prepareValues($order, $default);
	}

	
	protected function _prepareValues(Mage_Sales_Model_Order $order, $values) {
		return $values;
	}
}