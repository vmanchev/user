<?php

namespace PhpwisdomUser;

use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'PhpwisdomUser\Form\Login'                => 'PhpwisdomUser\Form\Login'
            ),
            'factories' => array(
                'phpwisdomuser_module_options' => function ($sm) {
                    $config = $sm->get('Config');
                    return $config['phpwisdomuser'];
                },
                'phpwisdomuser_login_form' => function($sm) {
                    $options = $sm->get('phpwisdomuser_module_options');
                    $form = new Form\Login(null, $options);
                    return $form;
                }                  
            ),
        );
    }    
}
