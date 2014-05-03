/**
 * Created by Ron on 14-5-2.
 */
require(['checkedAll','viewmodel/customer','knockout'],function(checkedAllHandler,Customer,ko){
    checkedAllHandler({deleteUrl:'/customer/delete-multiple'});
    var customer = new Customer();
    ko.applyBindings(customer);
});
