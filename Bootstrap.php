<?php

class ManipleForms_Bootstrap extends Zefram_Application_Module_Bootstrap
{
    protected function _initAutoloader()
    {
        Zend_Loader_AutoloaderFactory::factory(array(
            'Zend_Loader_StandardAutoloader' => array(
                'prefixes' => array(
                    'ManipleForms_' => __DIR__ . '/library/'
                ),
            ),
        ));
    }
    protected function _initView()
    {
        $bootstrap = $this->getApplication();
        $bootstrap->bootstrap('View');

        /** @var Zend_View $view */
        $view = $bootstrap->getResource('View');
        $view->addScriptPath(__DIR__ . '/views/scripts');
        $view->addHelperPath(__DIR__ . '/library/View/Helper/', 'ManipleForms_View_Helper_');
    }
}
