/**
 * Created by Ron on 14-5-7.
 */
define(['knockout','knockoutMapping','formPost','message','viewmodel/editAccount'], function(ko,koMapping,formPost,message,EditAccount) {
    return function(){
        EditAccount.call(this);
        var self = this;
        self.submitAndContinue = function(callback){
            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/account/manage-account',
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