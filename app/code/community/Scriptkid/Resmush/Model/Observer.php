<?php

class Scriptkid_Resmush_Model_Observer
{

  /*
  *   Watches catalog_product_gallery_upload_image_after and has $this and $result in the event.
  *
  */
  public function catalogProductGalleryUploadImageAfter($observer)
  {
      $result = $observer->getEvent()->getResult();
      $_imageName = $_result['name'];
      $_imageFilepath = $_result['path'].$_result['file'];
      var_dump($result);
      die();
  }

}
