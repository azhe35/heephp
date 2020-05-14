<?php
namespace heephp;
use heephp\sysExcption;

class controller{

    protected $_pagevar = array();

    public function  __construct()
    {
        aop('controller_init');

    }

    public function assign($name,$value){
        $this->_pagevar[]=[$name=>$value];
    }

    public function fetch($viewpage=''){
        $viewpage=empty($viewpage)?METHOD:$viewpage;
        $viewPagePath = '';
        $otherdir = strpos($viewpage,'/')>-1;

        //判断是否是否使用独立目录
        $skindir = config('skin_dir');
        $skindir = empty($skindir)?'':($skindir.'/');

        //判断是否使用皮肤
        $skin = config('skin');
        $skin = empty($skin)?'':($skin.'/');

        if(!empty($skindir)){

            //如果使用了指定目录
            if($otherdir)
                $viewPagePath = './../'.$skindir.$skin. $viewpage . '.php';
            else
                $viewPagePath = './../'.$skindir.$skin. CONTROLLER . '/' . $viewpage . '.php';

        }else if(APPS) {
            //多应用
            if ($otherdir)
                $viewPagePath = './../app/' . APP . '/view/' .$skin. $viewpage . '.php';
            else
                $viewPagePath = './../app/' . APP . '/view/' .$skin. CONTROLLER . '/' . $viewpage . '.php';
        }else{
            //单应用
            if ($otherdir)
                $viewPagePath = './../app/view/' .$skin. $viewpage . '.php';
            else
                $viewPagePath = './../app/view/'.CONTROLLER.'/'.$skin.$viewpage.'.php';
        }
        if(!is_file($viewPagePath)){
            throw new sysExcption( '模板文件'.$viewPagePath.'不存在！');
            exit;
        }
        //取出变量
        foreach ($this->_pagevar as $k=>$v){
            foreach ($v as $a=>$b){
                $$a=$b;
            }
        }

        ob_start();

        include $viewPagePath;
        //调用调试
        trace::page_trace();

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function json($data){
        header("Content-Type: json/application; charset=UTF-8");
        echo json_encode($data);
    }

    public function file($file,$filename){
        $fileinfo=fopen($file,'r');
        header("Content-Type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Accept-Length:".filesize($file));
        header("Content-Disposition:attachment;filename=".$filename);
        echo fread($fileinfo,filesize($file));
        fclose($fileinfo);
    }

    public function rediect($path){
        ob_start();
        header('Location:'.url($path));
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function success($msg,$url,$stoptime=1){

        ob_start();

        include config('success_page');

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function error($msg,$url='',$stoptime=1){
        $url = empty($url)?$_SERVER["HTTP_REFERER"]:$url;

        ob_start();

        include config('error_page');

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function __get($name)
    {
        if($name=='pagevar'){
            return $this->_pagevar;
        }
    }


}