<?php
final  class Paginator {

    public static $Configuration=array(
            "Itemlimit"=>4,
            "Pagelimit"=>9,
            "Class"=>"pagination",
            "Previous"=>array("Text"=>"« Previous","Class"=>"previous"),
            "Next"=>array("Text"=>"Next »","Class"=>'next'),
            "Current"=>array("Class"=>"current"),
            "Desable"=>array("Class"=>"off")
        );
   
    public function  __construct() {  }

    public function Render($total,$url,$currentpage=1, $dump=true){       
        $paginatorstr='<ul class="'.self::$Configuration['Class'].'">{content}</ul>';
        $content="";
        //previous
        if($currentpage==1){
            $prev='<li><span  class="'.self::$Configuration['Desable']['Class'].'">'
            .self::$Configuration['Previous']['Text'] .'</span></li>';
        }
        else {
            $param=$currentpage-1;
            $prev='<li><a href="'.$url.$param.'"  class="'.self::$Configuration['Previous']['Class'].'">'
            .self::$Configuration['Previous']['Text'] .'</a></li>';
        }
       $content.=$prev;

       //pages 1 2 3 ...
        $pagecount=ceil($total/self::$Configuration['Itemlimit']);
        $pagelimit=self::$Configuration['Pagelimit'];
        $begin=1;
        if($currentpage>=6){
            $begin=$currentpage-3;
        }

        for($i=$begin; $i<$begin+$pagelimit; $i++ ){
            if($i>$pagecount){ break; }
            $param=$i;
            if($i==$currentpage){
                $content.='<li><span class="'.self::$Configuration['Current']['Class'].'">'.$i.'</span></li>';
                continue;
            }
            $content.='<li><a href="'.$url.$i.'">'.$i.'</a></li>';  
        }
        //next
        if($currentpage==$pagecount){
            $next='<li><span class="'.self::$Configuration['Desable']['Class'].'">'
            .self::$Configuration['Next']['Text'] .'</span></li>';
        }
        else {
            $param=$currentpage+1;
            $next='<li><a href="'.$url.$param.'" class="'.self::$Configuration['Next']['Class'].'">'
            .self::$Configuration['Next']['Text'] .'</a></li>';
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