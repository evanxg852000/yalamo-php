<?php
$PAGINATORCONFIG=array(
"item_per_page"=>4,
"page_limit"=>9,
"css_class"=>"pagination",
"previous"=>array("Text"=>"« Previous","css_class"=>"previous"),
"next"=>array("Text"=>"Next »","css_class"=>'next'),
"current"=>array("css_class"=>"current"),
"Desable"=>array("css_class"=>"off")
);

final  class Paginator {
    private $configuration;
    public function  __construct() {
        global $PAGINATORCONFIG;
        $this->configuration=& $PAGINATORCONFIG;

    }

    public function Render($total,$url,$currentpage=1, $dump=true){       
        $paginatorstr='<ul class="'.$this->configuration['css_class'].'">{content}</ul>';
        $content="";
        //previous
        if($currentpage==1){
            $prev='<li><span  class="'.$this->configuration['Desable']['css_class'].'">'
            .$this->configuration['previous']['Text'] .'</span></li>';
        }
        else {
            $param=$currentpage-1;
            $prev='<li><a href="'.$url.$param.'"  class="'.$this->configuration['previous']['css_class'].'">'
            .$this->configuration['previous']['Text'] .'</a></li>';
        }
       $content.=$prev;

       //pages 1 2 3 ...
        $pagecount=ceil($total/$this->configuration['item_per_page']);
        $pagelimit=$this->configuration['page_limit'];
        $begin=1;
        if($currentpage>=6){
            $begin=$currentpage-3;
        }

        for($i=$begin; $i<$begin+$pagelimit; $i++ ){
            if($i>$pagecount){ break; }
            $param=$i;
            if($i==$currentpage){
                $content.='<li><span class="'.$this->configuration['current']['css_class'].'">'.$i.'</span></li>';
                continue;
            }
            $content.='<li><a href="'.$url.$i.'">'.$i.'</a></li>';  
        }
        //next
        if($currentpage==$pagecount){
            $next='<li><span class="'.$this->configuration['Desable']['css_class'].'">'
            .$this->configuration['next']['Text'] .'</span></li>';
        }
        else {
            $param=$currentpage+1;
            $next='<li><a href="'.$url.$param.'" class="'.$this->configuration['next']['css_class'].'">'
            .$this->configuration['next']['Text'] .'</a></li>';
        }
        $content.=$next;
        $paginatorstr=str_replace("{content}", $content, $paginatorstr);
        if($dump){
            echo $paginatorstr;
        }
           return $paginatorstr;
    }
    
}

/*Pagination  default Style

.pagination {
    margin-top:5px;
    padding-top:5px;
}
.pagination li{
    border:0; margin:0; padding:0;
    font-size:14px;
    list-style:none;
}
.pagination li a,.pagination li span {
    color:#000000;
    display:block;
    float:left;
    padding:4px 6px;
    text-decoration:none;
    font-weight: bold;
    border:solid 2px #cccccc;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    margin-right:2px;
}
.pagination li a:hover{
    border-color: #666666;
    color:#666666;
    background:#e5e4e4;
}

.pagination .previous {

}
.pagination .next {

}
.pagination .current{
    background-color: #cccccc;
    border-color: #4F5155;
}
.pagination .off  {
    background-color: #cccccc;
}

 */