<?php

class Scriptkid_Resmush_Model_Webservice
{
  protected $_helper;
  protected $_webserviceUrl;
  protected $_logfile;
  protected $_logLevel;

  /*
  * Construct fixed data for the webservice - can later be made configurable
  *
  */
  public function __construct()
  {
    $this->_helper = Mage::helper('resmush');
    $this->_webserviceUrl = $this->_helper->setWebserviceUrl();
    $this->_logfile = $this->_helper->setLogfile();
		$this->_logLevel = $this->_helper->setLogLevel();
  }


  /*
  * Calls the API with the file as binary data. Returns json with result from
  * the resmush.it API
  */
  public function callWebservice($_imagePath = null)
  {

    if($_imagePath)
    {
      $_cUrlQuery = $this->buildQuery($_imagePath);
      $_cUrlResult = curl_exec($_cUrlQuery);
      curl_close($_cUrlQuery);
      Mage::log($_imagePath.' has been processed by the Webservice', 6, $this->_logfile);
      return json_decode($_cUrlResult);

    } else {
      Mage::log('No image-path given to callWebservice() in Webservice model', $this->_logLevel, $this->_logfile);
    }
  }

  /*
  * Builds our cURL query with the imagepath
  *
  */
  public function buildQuery($_imagePath)
  {
    if(!empty($_imagePath))
    {
      $_postData = $this->generatePostdata($_imagePath);

      $cUrl = curl_init();
      curl_setopt($cUrl, CURLOPT_URL, $this->_webserviceUrl);
      curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($cUrl, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($cUrl, CURLOPT_POST, 1);
      curl_setopt($cUrl, CURLOPT_POSTFIELDS, $_postData);

      return $cUrl;
    } else {
      Mage::log('No image-path given to buildQuery() in Webservice model', $this->_logLevel, $this->_logfile);
      return false;
    }

  }

  /*
  * Creates the post array for our cURL query
  *
  */
  public function generatePostdata($_imagePath)
  {
    if(!empty($_imagePath))
    {
      $_postData = array(
        'files' => '@'.$_imagePath
      );
      return $_postData;
    } else {
      Mage::log('No image-path given to generatePostdata() in Webservice model', $this->_logLevel, $this->_logfile);
      return false;
    }
  }

}
