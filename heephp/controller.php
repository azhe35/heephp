<?php
namespace heephp;
use heephp\template\heephpTemplate;
use heephp\template\smartyTemplate;
use heephp\template\templateInterface;

class controller{

    //protected $_pagevar = [];
    private  $tempdriver;
    private $conf;//模板配置
    private $tempext;//模板扩展名

    public function  __construct()
    {
        $this->conf=config("template");
        $temptype = $this->conf['diver'];
        $this->tempext = $this->conf['ext'];

        if( $temptype=='heephp'){
            $this->tempdriver = new heephpTemplate();
        }else if($temptype=='smarty'){
            $this->tempdriver = new smartyTemplate();

        }else
        {
            throw new sysExcption("未知的模板引擎：".$temptype);
            return;
        }

        aop('controller_init');

    }

    public function assign($name,$value){
        //$this->_pagevar[]=[$name=>$value];
        $this->tempdriver->assign($name,$value);
    }

    public function fetch($viewpage='') {
        //判断是否是否使用独立目录
        $template_dir = $this->conf['dir'];
        $template_dir = empty($template_dir)?'':($template_dir.'/');



        if ($template_dir != '') {
            //if(APPS)
            //    $template_dir = './../../' . $template_dir . CONTROLLER . '/';
            //else
            $template_dir = './../' . $template_dir.config('skin').'/' ;

            $viewpage = empty($viewpage) ? CONTROLLER . '/'.METHOD : $viewpage;
        }else {
            if (APPS)
                $template_dir = './../app/' . APP . '/view/'. CONTROLLER . '/';
            else
                $template_dir = './../app/view/'. CONTROLLER . '/';

            $viewpage = empty($viewpage) ? METHOD : $viewpage;
        }

        $viewpage=$viewpage.'.'.$this->tempext;

        //调用调试
        trace::page_trace();

        if (!is_file($template_dir.$viewpage)) {
            throw new sysExcption('模板文件' . $template_dir.$viewpage . '不存在！');
        }

        return $this->tempdriver->fetch($template_dir,$viewpage);

    }



    public function json($data){
        header("Content-Type: json/application; charset=UTF-8");
        return json($data);
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

    public function redirect($path,$parms=[]){
        ob_start();
        header('Location:'.url($path,$parms,false));
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function success($msg,$url,$stoptime=1){

        if(config('content-type')=='json')
        {
            return ['success'=>true,'code'=>200,'msg'=>$msg];
        }
        ob_start();

        include config('success_page');

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function error($msg,$url='',$stoptime=1){
        if(config('content-type')=='json')
        {
            return ['success'=>false,'code'=>201,'msg'=>$msg];
        }

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

    /**
     * 是否是AJAx提交的
     * @return bool
     */
    protected function _isAjax(){
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 是否是GET提交的
     */
    protected function _isGet(){
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }
    /**
     * 是否是POST提交
     * @return int
     */
    protected function _isPost() {
        return ($_SERVER['REQUEST_METHOD'] == 'POST');
    }

    public function __call($name, $arguments)
    {
        if(!method_exists($this,'Empty'))
            if(config('debug'))
                throw new sysExcption('控制器：'.CONTROLLER.'方法：'.$name.' 不存在');
            else
                return '您访问的页面不存在！';
        else
            return $this->empty($name,$arguments);
    }


}