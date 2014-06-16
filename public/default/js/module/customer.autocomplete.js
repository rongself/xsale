define(['jquery','typeahead','underscore','lib/json2'],function($){
    return function(updaterCallback){
        //for customer autocomplete
        var customers = [];
        $('#phone_number').typeahead({
            items:5,
            source: function (query, process) {
                if(typeof customers == 'object' && customers.length <= 0){
                    $.getJSON('/Customer/get-customers-json',{query:query},function(data){
                        customers = data;
                        var results = _.map(customers, function (customer) {
                            return customer.phoneNumber;
                        });
                        process(results);
                    });
                }else{
                    var results = _.map(customers, function (customer) {
                        return customer.phoneNumber;
                    });
                    process(results);
                }
            },
            highlighter: function (selectedSKU) {
                var customer = _.find(customers, function (item) {
                    return item.phoneNumber == selectedSKU;
                });
                var customerName = customer.name?customer.name+":":''
                if(customer.isVip){
                    return '<div>'+customerName+customer.phoneNumber+' <span style="color:#ac2925;"> (VIP)</span></div>';
                }else{
                    return customerName+customer.phoneNumber;
                }

            },
            updater: function(selectedItem){
                return updaterCallback(selectedItem,customers);
            }
        });
    }
});
