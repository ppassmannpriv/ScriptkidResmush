<?php

require_once 'Mage/Adminhtml/controllers/Cms/Wysiwyg/ImagesController.php';

class Scriptkid_Resmush_Adminhtml_Cms_Wysiwyg_ImagesController extends Mage_Adminhtml_Cms_Wysiwyg_ImagesController
{

  public function uploadAction()
  {
    $_webservice = Mage::getModel('resmush/webservice');
    $_helper = Mage::helper('resmush');
    $_logfile = $_helper->setLogfile();
		$_logLevel = $_helper->setLogLevel();

    try {
        $result = array();
        $this->_initAction();
        $targetPath = $this->getStorage()->getSession()->getCurrentPath();

        $result = $this->getStorage()->uploadFile($targetPath, $this->getRequest()->getParam('type'));

        $_imageFilepath = $result['path'].'/'.$result['name'];
        $_imageData = $_webservice->callWebservice($_imageFilepath);
        $_helper->saveImageData($_imageData, $_imageFilepath);

    } catch (Exception $e) {
        Mage::log($e->getMessage(), $_logLevel, $logfile);
        $result = array('error' => $e->getMessage(), 'errorcode' => $e->getCode());
    }
    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
  }

}
