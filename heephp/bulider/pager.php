<?php
namespace heephp\bulider;
class pager{

    public function __construct()
    {

    }

    public function bulider($page,$pagecount,$page_parm_postion=0,/*$urlparms,$pname,*/$other=''){
        //构造url
        $parms = PARMS;

        if(APPS)
            $path='/'.APP.'/'.CONTROLLER.'/'.METHOD;
        else
            $path='/'.CONTROLLER.'/'.METHOD;

        $firstpageparm=$prvpage2parm=$prvpage2parm=$prvpageparm=$nextpageparm=$nextpage2parm=$endpageparm=$parms;

        $firstpageparm[$page_parm_postion]=1;
        $prvpage2parm[$page_parm_postion]=($page-2);
        $prvpageparm[$page_parm_postion]=($page-1);
        $nextpageparm[$page_parm_postion]=($page+1);
        $nextpage2parm[$page_parm_postion]=($page+2);
        $endpageparm[$page_parm_postion]=$pagecount;

        $firstpage=url($path,$firstpageparm/*array_merge($urlparms,[$pname.'_1'])*/).'?'.$other;
        $prvpage2=url($path,$prvpage2parm/*array_merge($urlparms,[$pname.'_'.($page-2)])*/).'?'.$other;
        $prvpage=url($path,$prvpageparm/*array_merge($urlparms,[$pname.'_'.($page-1)])*/).'?'.$other;
        $nextpage=url($path,$nextpageparm/*array_merge($urlparms,[$pname.'_'.($page+1)])*/).'?'.$other;
        $nextpage2=url($path,$nextpage2parm/*array_merge($urlparms,[$pname.'_'.($page+2)])*/).'?'.$other;
        $endpage=url($path,$endpageparm/*array_merge($urlparms,[$pname.'_'.$pagecount])*/).'?'.$other;


        $pagerclass=' class="'.config('pagination.class').'"';
        $pageritemclass=' class="'.config('pagination.item_class').'"';
        $pagerlinkclass=' class="'.config('pagination.link_class').'"';
        $pagercurrtclass=' class="'.config('pagination.item_class').' '.config('pagination.currt_class').'"';


        $pager="<ul$pagerclass>";
        $pager.=($page!=1)?"<li$pageritemclass><a$pagerlinkclass href=\"$firstpage\">首页</a></li>":'';
        $pager.=($page!=1)?"<li$pageritemclass><a$pagerlinkclass href=\"$prvpage\">上一页</a></li>":'';
        $pager.=($page>2&&$pagecount>2)?"<li$pageritemclass><a$pagerlinkclass href=\"$prvpage2\">".($page-2).'</a></li>':'';
        $pager.=($page>1&&$pagecount>1)?"<li$pageritemclass><a$pagerlinkclass href=\"$prvpage\">".($page-1).'</a></li>':'';
        $pager.="<li$pagercurrtclass><a$pagerlinkclass href=\"#\">$page</a></li>";
        $pager.=$pagecount>$page?"<li$pageritemclass><a$pagerlinkclass href=\"$nextpage\">".($page+1).'</a></li>':'';
        $pager.=$pagecount>($page+1)?"<li$pageritemclass><a$pagerlinkclass href=\"$nextpage2\">".($page+2).'</a></li>':'';
        $pager.=$pagecount>$page&&$page<$pagecount?"<li$pageritemclass><a$pagerlinkclass href=\"$nextpage\">下一页</a></li>":'';
        $pager.=$pagecount>$page?"<li$pageritemclass><a$pagerlinkclass href=\"$endpage\">尾页</a></li>":'';
        $pager.='   第'.$page.'/'.$pagecount.'页';
        $pager.='</ul>';

        return $pager;
    }

}