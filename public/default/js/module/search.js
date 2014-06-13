/**
 * Created by Administrator on 14-6-13.
 */
define(['jquery','message'],function($,message){
    return function(options){
        var defaultOptions = {
            setUrl:function(){return ''}
        };
        options = $.extend(defaultOptions,options);
        $('#search').click(function(){
            var keyword = $('#keyword').val();
            if(keyword==''){
                message.info('请输入搜索关键词');
            }else{
                location.href= options.setUrl(keyword);
            }
            return false;
        });
    }
});