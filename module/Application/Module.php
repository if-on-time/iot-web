<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\User;
use Application\Model\UserTable;
use Locale;

class Module {

    const PRIORIDADE_DISPATCH = 100;
    
    public function onBootstrap($e) {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        /** @var \Zend\EventManager\SharedEventManager $sharedEvents */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        //adiciona eventos ao módulo
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController',
                \Zend\Mvc\MvcEvent::EVENT_DISPATCH,
                array($this, 'mvcPreDispatch'),
                Module::PRIORIDADE_DISPATCH);
        
        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->setLocale(Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']))
                ->setFallbackLocale('en_US');
        
        // change layout dynamically
        // http://stackoverflow.com/questions/16277251/zendframework-2-error-in-loading-layout-for-different-modules
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Verifica se precisa fazer a autorização do acesso
     * @param MvcEvent $event Evento
     * @return boolean
     */
    public function mvcPreDispatch($event) {
        $di = $event->getTarget()->getServiceLocator();
        $routeMatch = $event->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName = $routeMatch->getParam('action');

        $authService = $di->get('Application\Service\Auth');
        if (!$authService->authorize($moduleName, $controllerName, $actionName)) {
            $redirect = $event->getTarget()->redirect();
            return $redirect->toUrl('/login');
        }
        return true;
    }

    public function getServiceConfig() {
      return array(
          'factories' => array(
               'Application\Model\UserTable' => function ($sm) {
                   $tableGateway = $sm->get('UserTable');
                   $table = new UserTable($tableGateway);
                   return $table;
               },
               'UserTable' => function ($sm) {
                   $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                   $resultSetPrototype = new ResultSet();
                   $model = new User();
                   $resultSetPrototype->setArrayObjectPrototype($model);
                   return new TableGateway($model->getTableName(), $dbAdapter, null, $resultSetPrototype);
               }
          ),
      );
   }

}
