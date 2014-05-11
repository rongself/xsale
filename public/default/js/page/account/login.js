/**
 * Created by Ron on 14-5-4.
 */
require(['viewmodel/login','knockout','switch'],function(Login,ko,bootstrapSwitch){
    var login =new Login();
    ko.applyBindings(login);
    bootstrapSwitch.defaults.onText = '是';
    bootstrapSwitch.defaults.offText = '否';
    $("[name='switch-checkbox']").bootstrapSwitch();
});
