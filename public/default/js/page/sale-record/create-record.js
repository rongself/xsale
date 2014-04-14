/**
 * Created by Ron on 14-3-1.
 */
require(['knockout',
      'viewmodel/saleRecord',
      'viewmodel/saleProduct',
      'module/sku.autocomplete',
      'typeahead',
      'underscore',
      'module/image.uploader']
    ,function(ko,SaleRecordViewModel,SaleProductViewModel,SkuAutoComplete){
        saleRecord = new SaleRecordViewModel();
        saleProduct = new SaleProductViewModel();

        saleProduct.sku.extend({
            validation: { validator: uniqueInObservableArray, message: '该产品已存在于进货单中', params: saleRecord.saleProducts()}
        });

        saleProduct.sku.extend({
            validation: { validator: existsInArray, message: '该产品不存在于库存中', params: products}
        });
        //ko.applyBindings(saleRecord);
        var skuAutoComplete = new SkuAutoComplete(function(selectedSKU,products){
            return selectedSKU;
        });

    });
