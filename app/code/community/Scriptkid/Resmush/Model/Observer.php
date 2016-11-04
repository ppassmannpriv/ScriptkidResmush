<?php

class Scriptkid_Resmush_Model_Observer
{
  protected $_helper;
  protected $_logfile;
  protected $_logLevel;
  protected $_webservice;

  public function __construct()
  {
    $this->_webservice = Mage::getModel('resmush/webservice');
    $this->_helper = Mage::helper('resmush');
    $this->_logfile = $this->_helper->setLogfile();
		$this->_logLevel = $this->_helper->setLogLevel();
  }

  /*
  *   Watches catalog_product_gallery_upload_image_after and has $this and $result in the event.
  *
  */
  public function catalogProductGalleryUploadImageAfter($observer)
  {
      $_result = $observer->getEvent()->getResult();
      $_imageName = $_result['name'];
      $_imageFilepath = $_result['path'].$_result['file'];

      $_imageData = $this->_webservice->callWebservice($_imageFilepath);
      $this->_helper->saveImageData($_imageData, $_imageFilepath);


  }

  public function catalogCategorySaveAfter($observer)
  {
    $_categoryData = $observer->getEvent()->getCategory();

    if($_categoryData->getImage())
    {
      $_imageFilepath = Mage::getBaseDir('media').'/catalog/category/'.$_categoryData->getImage();
    } else {
      $_imageFilepath = false;
    }

    if($_categoryData->getThumbnail())
    {
      $_thumbnailFilepath = Mage::getBaseDir('media').'/catalog/category/'.$_categoryData->getThumbnail();
    } else {
      $_thumbnailFilepath = false;
    }

    if($_imageFilepath)
    {
      $_imageData = $this->_webservice->callWebservice($_imageFilepath);
      $this->_helper->saveImageData($_imageData, $_imageFilepath);
    }
    if($_thumbnailFilepath)
    {
      $_imageData = $this->_webservice->callWebservice($_thumbnailFilepath);
      $this->_helper->saveImageData($_imageData, $_thumbnailFilepath);
    }
  }

}
