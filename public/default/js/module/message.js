/**
 * Created by Administrator on 14-5-20.
 */
define(['jquery'],function($){
    return {
        show:function(message,type){
            if($('#messageAlert').get(0)!=null){
                $('#messageAlert').remove();
            }
            $('<div id="messageAlert" class="te-ce alert fade in alert-'+type+'"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+message+'</div>')
                .css({
                    position:'fixed',
                    top:'-54px',
                    left:'0px',
                    width:'100%',
                    'z-index':'1031',
                    margin:'0px'
                })
                .appendTo('body')
                .stop().animate({'top':-1},500)
                .delay(5000)
                .animate({'top':-54},500,function(){$(this).remove();});
        },
        error:function(message){
            this.show(message,'danger');
        },
        success:function(message){
            this.show(message,'success');
        },
        info:function(message){
            this.show(message,'info');
        },
        warning:function(message){
            this.show(message,'warning');
        }
    }
});