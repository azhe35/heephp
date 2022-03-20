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
        $content = $this->smarty->fetch($basetemplatedir.$viewpage);

        //html字符替换
        $html_replace = config('html_replace');
        if (is_array($html_replace) && count($html_replace) > 0) {
            foreach ($html_replace as $k => $v) {
                $content = str_replace($k, $v, $content);
            }
        }

        return $content;

    }
}