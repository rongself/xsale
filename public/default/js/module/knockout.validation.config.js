define(['knockout','validation','underscore'], function(ko) {
    ko.validation.rules.pattern.message = 'Invalid.';
    ko.validation.configure({
        registerExtenders: true,
        messagesOnModified: true,
        insertMessages: true,
        parseInputAttributes: true,
        messageTemplate: null
    });

    uniqueInObservableArray = function(val,observableArray) {
        var exists = ko.utils.arrayFirst(observableArray, function(item) {
            console.log(item.sku()+'==='+val);
            return item.sku() === val;
        })
        return exists === null;
    };

    var isAjaxPending = false;
    $('body').ajaxStart(function(){
        isAjaxPending = true;
    });
    $('body').ajaxStop(function(){
        isAjaxPending = false;
    });
    var startAjax = function(val,callback){
        if(isAjaxPending){
            setTimeout(startAjax(val,callback),1000);
            return false;
        }
        $.ajax({
            context:document.body,
            url: '/Product/ajax-is-product-exists',
            type: 'POST', // or whatever http method the server endpoint needs
            data: { sku: val }, // args to send server
            dataType:'json'
        })
            .done(function(response, statusText, xhr) {
                if(response.result==true){
                    callback(true);
                }else{
                    callback(false);
                }
                // tell ko.validation that this value is valid
            })
            .fail(function(xhr, statusText, errorThrown) {
                callback(false); // tell ko.validation that his value is NOT valid
                // the above will use the default message. You can pass in a custom
                // validation message like so:
                // callback({ isValid: false, message: xhr.responseText });
            });
    }
    ko.validation.rules['isProductExists'] = {
        async: true,
        message: '该产品不存在于库存中,也许你需要先进货:)',
        validator: function(val, parms, callback) {
            startAjax(val,callback);
        }
    };
    ko.validation.rules['isPhoneNumberExists'] = {
        async: true,
        message: '该手机号已存在',
        validator: function(val, parms, callback) {
            $.ajax({
                url: '/customer/ajax-is-phoneNumber-exists',
                type: 'POST',
                data: { phoneNumber: val },
                dataType:'json'
            })
                .done(function(response, statusText, xhr) {
                    if(response.result==true){
                        callback(false);
                    }else{
                        callback(true);
                    }

                })
                .fail(function(xhr, statusText, errorThrown) {
                    callback(false);
                });
        }
    };
    ko.validation.rules['isUsernameExists'] = {
        async: true,
        message: '该登录名已存在',
        validator: function(val, parms, callback) {
            $.ajax({
                url: '/account/ajax-is-username-exists',
                type: 'POST',
                data: { account: val },
                dataType:'json'
            })
                .done(function(response, statusText, xhr) {
                    if(response.result==true){
                        callback(false);
                    }else{
                        callback(true);
                    }
                })
                .fail(function(xhr, statusText, errorThrown) {
                    callback(false);
                });
        }
    };

    ko.validation.rules['areSame'] = {
        getValue: function (o) {
            return (typeof o === 'function' ? o() : o);
        },
        validator: function (val, otherField) {
            return val === this.getValue(otherField);
        },
        message: '两次输入的密码不相同'
    };
    ko.validation.registerExtenders();
});