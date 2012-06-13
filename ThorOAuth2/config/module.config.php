<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'controller' => array(
    	'classes' => array(
    		'thor_oauth2_index' => 'ThorOAuth2\Controller\IndexController',
    		'thor_oauth2_authorization' => 'ThorOAuth2\Controller\AuthorizationController',
    	),
    ),
    'service_manager' => array(
        'aliases' => array(
            'zfcuser_zend_db_adapter' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
    'router' => array(
        'routes' => array(
            'thor_oauth2' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/oauth',
                    'defaults' => array(
                        'controller' => 'thor_oauth2_index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'thor_oauth2_authorization' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authorization',
                            'defaults' => array(
                                'controller' => 'thor_oauth2_authorization',
                                'action'     => 'request',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'di' => array(
        'instance' => array(
        ),
    ),
);
