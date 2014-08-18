/**
 * Created by Ron on 14-5-7.
 */
define(['knockout','knockoutMapping','formPost','message','viewmodel/abstract','validation','validationConfig'], function(ko,koMapping,formPost,message,abstract) {
    return function(){
        abstract.call(this);
        var self = this;
        self.id = ko.observable();
        self.name = ko.observable().extend({
            required:{message: '用户姓名不能为空'}
        });

        self.reset = function(){
            self.name('');
        }
        self.selectedRole = ko.observable();
        self.role = ko.observable();
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
        self.setDefaultValue();
    }
});