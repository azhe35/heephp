<?php
namespace heephp\template;

use heephp\config;
use heephp\sysExcption;
use heephp\trace;

include ("smarty/libs/Smarty.class.php");

class smartyTemplate implements templateInterface
{
    private  $smarty;

    function __construct()
    {
        $this->smarty = new \Smarty();
        $this->smarty->setCompileDir(ROOT.'/runtime/templates/compile/');
        $smarty_config_dir = config('template.smarty_config_dir');
        $this->smarty->setConfigDir(ROOT.(empty($smarty_config_dir)?'/app/config/':$smarty_config_dir));
        $this->smarty->setCacheDir(ROOT.'/runtime/templates/cache/');

    }

    function assign($name, $value)
    {
        $this->smarty->assign($name, $value);
    }

    function fetch($basetemplatedir,$viewpage)
    {
        $this->smarty->setTemplateDir($basetemplatedir);
        $this->smarty->display($viewpage);
    }
}