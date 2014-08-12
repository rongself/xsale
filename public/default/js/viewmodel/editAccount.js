/**
 * Created by Ron on 14-5-7.
 */
define(['knockout','knockoutMapping','formPost','message','viewmodel/abstract','validation','validationConfig'], function(ko,koMapping,formPost,message,abstract) {
    return function(){
        abstract.call(this);
        var self = this;
        var RoleType = function(id){
            this.roleName = function(){
                switch (id){
                    case 'super-admin':
                        return '超级管理员';
                        break;
                    case 'admin':
                        return '管理员';
                        break
                    default :
                        return 'unknow type';
                        break;
                }
            }();
            this.roleId = id;
        }
        self.id = ko.observable();
        self.name = ko.observable().extend({
            required:{message: '用户姓名不能为空'}
        });

        self.reset = function(){
            self.name('');
        }
        self.roleOptions = ko.observableArray([
            new RoleType('super-admin'),
            new RoleType('admin')
        ]);
        self.selectedRole = ko.observable();
        self.role = ko.computed({
            read:function(){
                if(self.selectedRole())
                    return self.selectedRole().roleId;
            },
            write:function(value){
                self.selectedRole(new RoleType(value));
            },
            owner:self
        });
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