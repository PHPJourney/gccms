<?php
/**
 * ALIPAY API: alipay.security.risk.filesuploading request
 *
 * @author auto create
 * @since 1.0, 2016-01-27 16:30:09
 */
class AlipaySecurityRiskFilesuploadingRequest
{
	/** 
	 * 文件上传参数
	 **/
	private $filesuoloadingtest;
	
	/** 
	 * testtesttest
	 **/
	private $normalparamtest;

	private $apiParas = array();
	private $terminalType;
	private $terminalInfo;
	private $prodCode;
	private $apiVersion="1.0";
	private $notifyUrl;

	
	public function setFilesuoloadingtest($filesuoloadingtest)
	{
		$this->filesuoloadingtest = $filesuoloadingtest;
		$this->apiParas["filesuoloadingtest"] = $filesuoloadingtest;
	}

	public function getFilesuoloadingtest()
	{
		return $this->filesuoloadingtest;
	}

	public function setNormalparamtest($normalparamtest)
	{
		$this->normalparamtest = $normalparamtest;
		$this->apiParas["normalparamtest"] = $normalparamtest;
	}

	public function getNormalparamtest()
	{
		return $this->normalparamtest;
	}

	public function getApiMethodName()
	{
		return "alipay.security.risk.filesuploading";
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
