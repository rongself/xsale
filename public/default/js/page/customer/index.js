/**
 * Created by Ron on 14-5-2.
 */
require(['checkedAll','viewmodel/customer','knockout','search'],function(checkedAllHandler,Customer,ko,search){
    checkedAllHandler({deleteUrl:'/customer/delete-multiple'});
    var customer = new Customer();
    ko.applyBindings(customer);
    search({
        setUrl:function(keyword){
            return '/customer/index/keyword/'+keyword
        }
    });
});
