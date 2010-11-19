<?php
final  class Paginator {

    public static $Configuration=array(
            "ItemPerPage"=>4,
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
            $param="#";
            $prev='<li class="'.self::$Configuration['Desable']['Class'].'">
                    <a href="'.$param.'">'.self::$Configuration['Previous']['Text'] .'</a></li>';
        }
        else {
            $param=$currentpage-1;
            $prev='<li class="'.self::$Configuration['Previous']['Class'].'"><a href="'
                    .$url.$param.'">'.
                    self::$Configuration['Previous']['Text'] .'</a></li>';
        }
       $content.=$prev;

       //pages 1 2 3 ...
        $pagecount=ceil($total/self::$Configuration['ItemPerPage']);
        for($i=1; $i<$pagecount; $i++ ){
            $param=$i;
            if($currentpage==$i){
                $content.='<li class="'.self::$Configuration['Current']['Class'].'"><a href="#">'.$i.'</a></li>';
                continue;
            }
            $content.='<li><a href="'.$url.$param.'">'.$i.'</a></li>';   
        }

        //next
        if($currentpage==$pagecount){
            $param="#";
            $next='<li class="'.self::$Configuration['Desable']['Class'].'"><a href="'.$param.'">'
                    .self::$Configuration['Next']['Text'] .'</a></li>';
        }
        else {
            $param=$currentpage+1;
            $next='<li class="'.self::$Configuration['Next']['Class'].'"><a href="'
                    .$url.$param.'">'.
                    self::$Configuration['Next']['Text'] .'</a></li>';
        }
        $content.=$next;
        $paginatorstr=str_replace("{content}", $content, $paginatorstr);
        if($dump){
            echo $paginatorstr;
        }
        else{
           return $paginatorstr;
        }
    }
    
}

/*  Sample Style

 .pagination {
    margin-top:5px;
    padding-top:5px;
}
.pagination li{
    border:0; margin:0; padding:0;
    font-size:14px;
    list-style:none;
}
.pagination li a {
    color:#000000;
    display:block;
    float:left;
    padding:3px 6px;
    text-decoration:none;
    border:solid 1px #cccccc;
    margin-right:2px;
}
.pagination li a:hover{
    border:solid 1px #666666;
    color:#666666;
    background:#e5e4e4;
}
.pagination off {
    background-color: red;
}
.pagination .next {

}
.pagination .previous {

}
.pagination .current {

}


 */