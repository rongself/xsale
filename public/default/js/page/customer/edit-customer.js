/**
 * Created by Ron on 14-5-3.
 */
require(['viewmodel/editCustomer','knockout','switch'],function(editCustomer,ko,bootstrapSwitch){
    var customer = new editCustomer();
    ko.applyBindings(customer);
    bootstrapSwitch.defaults.onText = '是';
    bootstrapSwitch.defaults.offText = '否';
    $("[name='switch-checkbox']").bootstrapSwitch();
});
