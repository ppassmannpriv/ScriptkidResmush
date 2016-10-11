<?php
class Scriptkid_Resmush_Helper_Webservice extends Mage_Core_Helper_Abstract
{
  protected $_webserviceUrl;

  /*
  * Construct fixed data for the webservice - can later be made configurable
  *
  */
  public function __construct()
  {
    $this->_webserviceUrl = 'http://api.resmush.it/ws.php';
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

      return json_decode($_cUrlResult);

    } else {
      Mage::log('No image-path given to callWebservice() in Webservice helper', 4, 'scriptkid_resmush.log');
    }
  }

  /*
  * Builds our cURL query with the imagepath
  *
  */
  public function buildQuery($_imagePath)
  {
    $_postData = $this->generatePostdata($_imagePath);

    $cUrl = curl_init();
    curl_setopt($cUrl, CURLOPT_URL, $this->_webserviceUrl);
    curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($cUrl, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($cUrl, CURLOPT_POST, 1);
    curl_setopt($cUrl, CURLOPT_POSTFIELDS, $_postData);

    return $cUrl;
  }

  /*
  * Creates the post array for our cURL query
  *
  */
  public function generatePostdata($_imagePath)
  {

    $_postData = array(
      'files' => '@'.$_imagePath
    );
    return $_postData;
  }

  /*
  * Get the public Image URL to push to resmush
  * There probably is a Magento-way of doing this, need to look this up.
  * This aint working this way - need to push binary file.
  */
/*  public function _getImageUrl($_imagePath)
  {
    $_imageUrl = explode('media/tmp', $_imagePath);
    $_imageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'tmp'.end($_imageUrl);

    return $_imageUrl;
  }*/

}
