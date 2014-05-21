/**
 * Created by Ron on 14-5-7.
 */
define(['knockout','knockoutMapping','formPost','message','validation','validationConfig'], function(ko,koMapping,formPost,message) {
    return function(){
        var self = this;
        self.name = ko.observable().extend({
            required:{message: '用户姓名不能为空'}
        });

        self.reset = function(){
            self.name('');
        }

        self.submitAndContinue = function(callback){
            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/account/edit-account',
                data:{account:data},
                success:function(){
                    message.success('修改成功');
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.submit = function(){
            self.submitAndContinue(function(){
                location.reload();
            });
        }
    }
});