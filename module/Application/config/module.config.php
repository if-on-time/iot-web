<?php

namespace Application;

use Application\Service\Auth;

// module/Application/conﬁg/module.config.php:

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/[page/:page]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                        'module'     => 'application',
                    ),
                ),
            ),
            'about' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/about',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'about',
                        'module'     => 'application',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Auth',
                        'action'     => 'login',
                        'module'     => 'application',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Auth',
                        'action'     => 'logout',
                        'module'     => 'application',
                    ),
                ),
            ),
            'signup' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/signup',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'signup',
                        'module'     => 'application',
                    ),
                ),
            ),
            'notificacao-index' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/notificacao',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Notificacao',
                        'action'     => 'index',
                        'module'     => 'application',
                    ),
                ),
            ),
            // rota simplificada para escrever menos :)
            'notificacao-tv' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/tv',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Notificacao',
                        'action'     => 'index',
                        'module'     => 'application',
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        'controller'    => 'Index',
                        'action'        => 'index',
                        '__NAMESPACE__' => 'Application\Controller',
                        'module'     => 'application'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array( //permite mandar dados pela url 
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'Session' => function($sm) {
                //return new \Zend\Session\Container('ZF2napratica');
                return new \Zend\Session\Container('ifontime');
            },
            'Application\Service\Auth' => function($sm) {
                $dbAdapter = $sm->get('DbAdapter');
                return new Auth($dbAdapter);
            },
        ),
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
                'text_domain' => __NAMESPACE__,
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Auth' => 'Application\Controller\AuthController',
            'Application\Controller\Account' => 'Application\Controller\AccountController',
            'Application\Controller\Notificacao' => 'Application\Controller\NotificacaoController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
