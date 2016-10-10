<?php

class Scriptkid_Resmush_Model_Observer
{

  /*
  *   Watches catalog_product_gallery_upload_image_after and has $this and $result in the event.
  *
  */
  public function catalogProductGalleryUploadImageAfter($observer)
  {
      $_result = $observer->getEvent()->getResult();
      $_imageName = $_result['name'];
      $_imageFilepath = $_result['path'].$_result['file'];
      $_helper = Mage::helper('resmush/webservice');

      echo $_helper->callWebservice($_imageFilepath);
      die();

      /* we have our temporary filepath now - from here we need to push through
       * the resmush api and replace the image with the compressed image.
       * Saving of the image should be handled by Magento.
       */

  }

}
