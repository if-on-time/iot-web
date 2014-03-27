<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

class IndexController extends ActionController {

    /**
     * Mapped as
     *    /
     */
    public function indexAction() {
        
        return new ViewModel(array(
            'list' => array()
        ));
    }

    /**
     * Mapped as
     *   /about
     */
    public function aboutAction() {
        // static about page
    }

    /**
     * @deprecated use Account#signup
     */
    public function signupAction() {
        
    }

}
