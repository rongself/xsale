/**
 * Created by Ron on 14-5-3.
 */
require(['viewmodel/customer','knockout'],function(Customer,ko){
    var customer = new Customer();
    ko.applyBindings(customer);
});
