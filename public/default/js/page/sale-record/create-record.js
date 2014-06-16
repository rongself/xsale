/**
 * Created by Ron on 14-3-1.
 */
require(['knockout',
      'viewmodel/saleRecord',
      'viewmodel/saleProduct',
      'module/sku.autocomplete',
      'module/customer.autocomplete',
      'message',
      'module/number',
      'datetimepicker',
      'validation',
      'typeahead',
      'underscore']
    ,function(ko,SaleRecordViewModel,SaleProductViewModel,SkuAutoComplete,CustomerAutoComplete,message){
        saleRecord = new SaleRecordViewModel();
        saleProduct = new SaleProductViewModel();
        saleRecord.init();
        saleRecord.editItem = function (product){
            if(!saleProduct.sku()){
                saleRecord.removeItem(product);
                saleProduct.sku(product.sku());
                saleProduct.quantity(product.quantity());
                saleProduct.price(product.price());
                saleProduct.remark(product.remark());
            }else{
                message.info('请先保存正在添加的产品')
            }
        }

        $('#startTime').datetimepicker({pickTime: false,language: 'zh-CN'});
        $('#startTime').on('dp.change', function(e){
            saleRecord.orderTime(moment(e.date).format('YYYY-MM-DD'));
        });
        saleProduct.sku.extend({
            validation: { validator: uniqueInObservableArray, message: '该产品已存在于账单中', params: saleRecord.saleProducts()}
        });

        var skuAutoComplete = new SkuAutoComplete(function(selectedSKU,products){
            var selectedProduct = _.find(products,function(item){return item.sku == selectedSKU});
            if(selectedProduct.price){
                saleProduct.price(selectedProduct.price);
            }
            if(saleProduct.price()==null){
                $('#price').focus();
            }else{
                $('#submitTo').focus();
            }
            return selectedSKU;
        });
        var CustomerAutoComplete = new CustomerAutoComplete(function(seleted,customers){
            var selectedCustomer =  _.find(customers,function(item){return item.phoneNumber == seleted});
            if(selectedCustomer.name){
                saleRecord.customerName(selectedCustomer.name);
            }
            return seleted;
        });
        ko.applyBindings(saleRecord);
    });