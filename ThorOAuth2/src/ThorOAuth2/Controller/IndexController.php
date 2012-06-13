<?php

namespace ThorOAuth2\Controller;

use Zend\Mvc\Controller\ActionController,
Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
	public function indexAction()
	{
		return new ViewModel();
	}
}
