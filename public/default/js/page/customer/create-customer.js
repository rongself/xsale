/**
 * Created by Ron on 14-5-3.
 */
require(['viewmodel/customer','knockout','switch'],function(Customer,ko,bootstrapSwitch){
    var customer = new Customer();
    bootstrapSwitch.defaults.onText = '是';
    bootstrapSwitch.defaults.offText = '否';
    $("[name='switch-checkbox']").bootstrapSwitch();
    ko.applyBindings(customer);
});
