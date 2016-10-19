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

      $_imageData = $_helper->callWebservice($_imageFilepath);

      file_put_contents($_imageFilepath, fopen($_imageData->dest, 'r'));



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
    $_imageFilepath = Mage::getBaseDir('media').'catalog/category/'.$_categoryData->getImage();
    $_thumbnailFilepath = Mage::getBaseDir('media').'catalog/category/'.$_categoryData->getThumbnail();

    /* We have the image and thumbnail paths now after save.
    *  From here we can push them to our webservice - which needs more stuff done
    *
    **/

  }

}
