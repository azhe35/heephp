<?php
namespace heephp;

class sysExcption extends \Exception
{
    private $traces=[];
    public function __construct($msg,$code=0,$traces=[])
    {
        parent::__construct($msg.' 代码：'.$code,is_int($code)?$code:404);
        $this->traces = $traces;

    }

    public function show(){
        if(!config('debug')){
            if(config('content-type')!='json')
                return '页面出错~<br><br><a href="http://www.heephp.com" target="_blank">heephp</a>';
            else
                return '{"success":false,"code":500,"msg":"页面出错~"}';
        }

        $msg = $this->message;
        $code = $this->code;
        $file = $this->getFile();
        $line = $this->getLine();
        $trace = $this->getTraceAsString();
        $traces = empty($this->traces)?$this->getTrace():$this->traces;

        if(config('content-type')!='json') {
            ob_start();
            include_once 'message/sysExcption.php';
            $content = ob_get_contents();
            ob_end_clean();

            return $content;
        }else
            return '{"success":false,"code":500,"msg":"'.$msg.'","line":'.$line.',"file":"'.$file.'"}';
    }

    public function __toString(){

        return $this->show();

    }

}