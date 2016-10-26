<?php

require_once 'Mage/Adminhtml/controllers/Cms/Wysiwyg/ImagesController.php';

class Scriptkid_Resmush_Adminhtml_Cms_Wysiwyg_ImagesController extends Mage_Adminhtml_Cms_Wysiwyg_ImagesController
{

  public function uploadAction()
  {
    try {
        $result = array();
        $this->_initAction();
        $targetPath = $this->getStorage()->getSession()->getCurrentPath();

        $result = $this->getStorage()->uploadFile($targetPath, $this->getRequest()->getParam('type'));

        $_imageFilepath = $result['path'].'/'.$result['name'];
        $_webservice = Mage::getModel('resmush/webservice');
        $_imageData = $_webservice->callWebservice($_imageFilepath);
        file_put_contents($_imageFilepath, fopen($_imageData->dest, 'r'));

    } catch (Exception $e) {
        $result = array('error' => $e->getMessage(), 'errorcode' => $e->getCode());
    }
    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
  }

}
