<?php
/**
 * ALIPAY API: alipay.user.contract.get request
 *
 * @author auto create
 * @since 1.0, 2016-01-14 17:21:12
 */
class AlipayUserContractGetRequest
{
	/** 
	 * 订购者支付宝ID。session与subscriber_user_id二选一即可。
	 **/
	private $subscriberUserId;

	private $apiParas = array();
	private $terminalType;
	private $terminalInfo;
	private $prodCode;
	private $apiVersion="1.0";
	private $notifyUrl;

	
	public function setSubscriberUserId($subscriberUserId)
	{
		$this->subscriberUserId = $subscriberUserId;
		$this->apiParas["subscriber_user_id"] = $subscriberUserId;
	}

	public function getSubscriberUserId()
	{
		return $this->subscriberUserId;
	}

	public function getApiMethodName()
	{
		return "alipay.user.contract.get";
	}

	public function setNotifyUrl($notifyUrl)
	{
		$this->notifyUrl=$notifyUrl;
	}

	public function getNotifyUrl()
	{
		return $this->notifyUrl;
	}

	public function getApiParas()
	{
		return $this->apiParas;
	}

	public function getTerminalType()
	{
		return $this->terminalType;
	}

	public function setTerminalType($terminalType)
	{
		$this->terminalType = $terminalType;
	}

	public function getTerminalInfo()
	{
		return $this->terminalInfo;
	}

	public function setTerminalInfo($terminalInfo)
	{
		$this->terminalInfo = $terminalInfo;
	}

	public function getProdCode()
	{
		return $this->prodCode;
	}

	public function setProdCode($prodCode)
	{
		$this->prodCode = $prodCode;
	}

	public function setApiVersion($apiVersion)
	{
		$this->apiVersion=$apiVersion;
	}

	public function getApiVersion()
	{
		return $this->apiVersion;
	}

}
