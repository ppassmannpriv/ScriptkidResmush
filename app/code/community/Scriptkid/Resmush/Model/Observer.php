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
      Mage::helper('resmush')->saveImageData($_imageData, $_imageFilepath);

      /* we have our temporary filepath now - from here we need to push through
       * the resmush api and replace the image with the compressed image.
       * Saving of the image should be handled by Magento.
       * clean this up dude! putting the actual file into the filepath needs to be a function.
       * single use principle!
       */
  }

  public function catalogCategorySaveAfter($observer)
  {
    $_categoryData = $observer->getEvent()->getCategory();

    if($_categoryData->getImage())
    {
      $_imageFilepath = Mage::getBaseDir('media').'catalog/category/'.$_categoryData->getImage();
    } else {
      $_imageFilepath = false;
    }

    if($_categoryData->getThumbnail())
    {
      $_thumbnailFilepath = Mage::getBaseDir('media').'catalog/category/'.$_categoryData->getThumbnail();
    } else {
      $_thumbnailFilepath = false;
    }

    /* We have the image and thumbnail paths now after save.
    *  From here we can push them to our webservice - which needs more stuff done
    *
    **/
  }

}
