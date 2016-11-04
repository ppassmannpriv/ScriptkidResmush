<?php
class Scriptkid_Resmush_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_logfile;
  protected $_logLevel;

	public function __construct()
	{
		$this->_logfile = $this->setLogfile();
		$this->_logLevel = $this->setLogLevel();
	}

	public function setLogfile()
	{
		return 'scriptkid_resmush.log';
	}

	public function setLogLevel()
	{
		return 4;
	}

	public function setWebserviceUrl()
	{
		return 'http://api.resmush.it/ws.php';
	}

	public function saveImageData($_imageData, $_imageFilepath)
	{
		if(is_object($_imageData))
		{
			if(file_put_contents($_imageFilepath, fopen($_imageData->dest, 'r')) === false)
			{
				Mage::log('saveImageData() failed in Helper Data Class', $this->_logLevel, $this->_logfile);
				return false;
			} else {
				return true;
			}
		} else {
			Mage::log('saveImageData() failed in Helper Data Class - _imageData is not an object - check out the Webservice!', $this->_logLevel, $this->_logfile);
		}
	}
}
