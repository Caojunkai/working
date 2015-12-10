jQuery(document).ready(function($){
    $(".but-1").bind("click",function(){
        $("#iframepage").attr("src","http://www.baidu.com");
    });
    $(".but-2").bind("click",function(){
        $("#iframepage").attr("src","http://www.weibo.com");
    })
});