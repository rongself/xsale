define(['jquery','message'],function($,message){
    return function(options){
        var defaultOptions = {
            checkbox:'#checkAll',
            handler:'#formControl',
            deleteUrl:''
        };
        options = $.extend(defaultOptions,options);
        $(options.checkbox).bind({
            'change':function(e){
                var self = this;
                if($(self).is(':checked')){
                    $('.ids').prop('checked',true);
                }else{
                    $('.ids').prop('checked',false);
                }
            }
        });

        $(options.handler).bind('change',function(){
            var ids = [];
            var self = this;
            $('.ids:checked').each(function(){
                ids.push($(this).val());
            });
            switch ($(self).val()) {
                case 'delete':
                    if(ids.length>0){
                        if(confirm('是否要删除这'+ids.length+'个项目?')){
                            $.post(options.deleteUrl,{ids:ids},function(result){
                                if(result.success){
                                    location.reload();
                                }else{
                                    message.error('服务器返回错误');
                                    $(self).val('handle');
                                }
                            },'json')
                                .fail(function(){
                                    message.error('Ajax传输失败');
                                    $(self).val('handle');
                                });
                        }else{
                            $(self).val('handle');
                        }
                    }else{
                        message.error('未选择任何项目');
                        $(self).val('handle');
                    }
                    break;
                default :
                    break;
            }
        });
    };
});
