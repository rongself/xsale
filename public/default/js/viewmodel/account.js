/**
 * Created by Ron on 14-5-3.
 */
define(['knockout','knockoutMapping','formPost','message','validation','validationConfig'], function(ko,koMapping,formPost,message) {
    return function(){
        var self = this;
        var RoleType = function(name,id){
            this.roleName = name;
            this.roleId = id;
        }
        self.name = ko.observable().extend({
            required:{message: '用户姓名不能为空'}
        });
        self.roleOptions = ko.observableArray([
            new RoleType('超级管理员','super-admin'),
            new RoleType('管理员','admin')
        ]);
        self.selectedRole = ko.observable();
        self.role = ko.computed(function(){
            if(self.selectedRole())
            return self.selectedRole().roleId;
        });
        self.username = ko.observable().extend({
            required:{message: '登录名不能为空'},
            isUsernameExists:self
        });
        self.password = ko.observable().extend({
            required:{message: '请输入密码'}
        });
        self.confirm = ko.observable().extend({
            required:{message: '请再次输入密码'},
            areSame: self.password
        });

        self.reset = function(){
            self.name('');
            self.username('');
            self.password('');
            self.confirm('');
        }

        self.submitAndContinue = function(callback){
            if(self.username.isValidating()){
                $('.submitTo').button('loading');
                setTimeout(function(){
                    self.submitAndContinue(callback);
                },50);
                return false;
            }else{
                $('.submitTo').button('reset');
            }
            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/account/create-account',
                data:{account:data},
                success:function(){
                    self.reset();
                    message.success('添加成功');
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.submit = function(){
            self.submitAndContinue(function(){
                location.href = '/account/index';
            });
        }
    }
});
