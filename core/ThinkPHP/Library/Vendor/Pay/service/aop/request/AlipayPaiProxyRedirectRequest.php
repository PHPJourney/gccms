<?php
/**
 * ALIPAY API: alipay.pai.proxy.redirect request
 *
 * @author auto create
 * @since 1.0, 2014-06-12 17:16:12
 */
class AlipayPaiProxyRedirectRequest
{
	/** 
	 * 跳转的地址
	 **/
	private $toUrl;

	private $apiParas = array();
	private $terminalType;
	private $terminalInfo;
	private $prodCode;
	private $apiVersion="1.0";
	
	public function setToUrl($toUrl)
	{
		$this->toUrl = $toUrl;
		$this->apiParas["to_url"] = $toUrl;
	}

	public function getToUrl()
	{
		return $this->toUrl;
	}

	public function getApiMethodName()
	{
		return "alipay.pai.proxy.redirect";
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
