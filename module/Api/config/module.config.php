<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Api\Controller\Notificacao' => 'Api\Controller\NotificacaoController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'api-notificacao' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/api/notificacao[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Api\Controller\Notificacao',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
