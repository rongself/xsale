/**
 * Created by Ron on 14-3-1.
 */
require(['knockout',
      'viewmodel/saleRecord',
      'viewmodel/saleProduct',
      'module/sku.autocomplete',
      'validation',
      'typeahead',
      'underscore']
    ,function(ko,SaleRecordViewModel,SaleProductViewModel,SkuAutoComplete){
        saleRecord = new SaleRecordViewModel();
        saleProduct = new SaleProductViewModel();
        saleProduct.sku.extend({
            validation: { validator: uniqueInObservableArray, message: '该产品已存在于账单中', params: saleRecord.saleProducts()}
        });
        var skuAutoComplete = new SkuAutoComplete(function(selectedSKU,products){
            return selectedSKU;
        });
        ko.applyBindings(saleRecord);
    });