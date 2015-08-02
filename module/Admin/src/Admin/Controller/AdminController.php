<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController {
     const ROUTE_LOGIN        = 'zfcuser/login';

	public function loginAction() {
		if( isset($_SESSION['super_admin_id']) ) {
			header('Location: http://cresttechnosoft.com/zend_site/KSL/admin');
			exit;
		}
	}
	
	public function indexAction() {
		if (!$this->zfcUserAuthentication()->hasIdentity()) {
			return $this->redirect()->toRoute(static::ROUTE_LOGIN);
		}
		
		return new ViewModel(array(
			
		));
	}

	public function getAdminTable() {
		if (!$this->adminTable) {
			$sm = $this->getServiceLocator();
			$this->adminTable = $sm->get('Admin\Model\AdminTable');
		}
		return $this->adminTable;
	}
}
