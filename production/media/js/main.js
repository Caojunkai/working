jQuery(document).ready(function($){
    html = [];
    $("#loading").hide();
    $("#pro-iframepage").attr("height",$(".component").height());
    $(".pro-but-1").bind("click",function(){
        $("#pro-iframepage").attr("src","http://www.baidu.com");
    });
    $(".pro-but-2").bind("click",function(){
        $("#pro-iframepage").attr("src","http://www.weibo.com");
    });
    $(".pro-but-3").bind("click",function(){
        $("#pro-iframepage").attr("src","http://www.douban.com/");
    });
    $(".pro-but-4").bind("click",function(){
        $("#pro-iframepage").attr("src","http://www.douban.com/");
    });
    $(".pro-but-work").bind("click",function(){
        //$("#loading").height($(document.body).height());
        $(".pro-but-page-next").attr('value',1);
        $(".pro-but-page-pre").attr('value',0);
        if(html.length > 0){
            var i = 0;
            for(i;i < html.length;i++){
                html[i] = "";
            }
        }
        $("#loading").fadeIn();
        $.ajax({
            url:"index.php?option=com_production&task=global.showMachine&format=json",
            type:"post",
            dataType:"json",
            data:{
                id:$(this).val()
            },
            cache:false,
            success: function(data){
                var detail = $(".pro-detail");
                detail.empty();
                if(data != null && data != ""){
                    $.each(data,function(key,value){
                        //if (parseInt(key) > 19){
                        //    return false;
                        //}
                        var coding = value.coding;
                        var pageIndex = Math.floor(key/20);
                        if(html[pageIndex] == undefined){
                            html[pageIndex] = "";
                        }
                        if(coding == null){
                            coding = "空";
                        }
                        switch (value.state){
                            case "0" :
                                html[pageIndex] += "<span class='pro-sp off' data-id='"+value.id+"'>"+coding+"</span>";
                                break;
                            case "1" :
                                html[pageIndex] += "<span class='pro-sp normal' data-id='"+value.id+"'>"+coding+"</span>";
                                break;
                            case "2" :
                                html[pageIndex] += "<span class='pro-sp waring' data-id='"+value.id+"'>"+coding+"</span>";
                                break;
                            case "3" :
                                html[pageIndex] += "<span class='pro-sp error' data-id='"+value.id+"'>"+coding+"</span>";
                                break;
                            default :
                                html[pageIndex] += "<span class='pro-sp unknown' data-id='"+value.id+"'>"+coding+"</span>";
                        }
                    });
                    detail.html(html[0]);
                }else{
                    if(html.length > 0){
                        var i = 0;
                        for(i;i < html.length;i++){
                            html[i] = "";
                        }
                    }
                    $(".pro-detail").html("<p>没有数据</p>");
                }
                if($(".pro-left").height() > 500){
                    $("#pro-iframepage").height($(".pro-left").height());
                }
            },
            complete: function () {
                $("#loading").fadeOut();
            },
            error: function (data) {
                console.info("error: " + data.responseText);
            }
        })

    });
    $(".pro-sp").live("click",function(){
        alert($(this).data("id"));
    })
    $(".pro-but-page-next").bind("click",function(){
        var index = parseInt($(this).val());
        if(html[index] != undefined && html[index] != ""){
            $(".pro-detail").html(html[index]);
            $(".pro-but-page-pre").attr("value",index);
            $(this).attr("value",index+1);
        }else {
            alert("最后一页了");
        }
    })
    $(".pro-but-page-pre").bind("click", function () {
        var index = parseInt($(this).val())-1;
        if(html[index] != undefined && html[index] != ""){
            $(".pro-detail").html(html[index]);
            $(".pro-but-page-next").attr("value",index+1);
            $(this).attr("value",index);
        }else{
            alert("第一页了");
        }
    })
});