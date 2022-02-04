<?php
namespace heephp\template;

use heephp\sysExcption;
use heephp\trace;

class heephpTemplate implements templateInterface {

    private $_pagevar = [];

    public function assign($name,$value){
        $this->_pagevar[]=[$name=>$value];
    }

    public function fetch($basedir,$viewpage)
    {

        //取出变量
        foreach ($this->_pagevar as $k => $v) {
            foreach ($v as $a => $b) {
                $$a = $b;
            }
        }

        ob_start();

        include $basedir.$viewpage;

        $content = ob_get_contents();
        ob_end_clean();

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