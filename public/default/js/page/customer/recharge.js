require(['knockout',
    'viewmodel/saleRecord',
    'viewmodel/saleProduct',
    'module/customer.autocomplete',
    'message',
    'module/number',
    'datetimepicker',
    'validation',
    'typeahead',
    'underscore']
    ,function(ko,SaleRecordViewModel,SaleProductViewModel,CustomerAutoComplete,message){
        var CustomerAutoComplete = new CustomerAutoComplete(function(seleted,customers){
            var selectedCustomer =  _.find(customers,function(item){return item.phoneNumber == seleted&&item.isVip==true});
            if(selectedCustomer.name){
                saleRecord.customerName(selectedCustomer.name);
            }
            return seleted;
        });
    });