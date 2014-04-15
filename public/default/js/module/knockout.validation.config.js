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

    ko.validation.rules['isProductExists'] = {
        async: true,
        message: '该产品不存在于库存中',
        validator: function(val, parms, callback) {
            $.ajax({
                url: '/Product/ajaxIsProductExists',
                type: 'POST', // or whatever http method the server endpoint needs
                data: { sku: val } // args to send server
            })
            .done(function(response, statusText, xhr) {
                console.log(val);
                console.log(response);
                callback(false); // tell ko.validation that this value is valid
            })
            .fail(function(xhr, statusText, errorThrown) {
                callback(false); // tell ko.validation that his value is NOT valid
                // the above will use the default message. You can pass in a custom
                // validation message like so:
                // callback({ isValid: false, message: xhr.responseText });
            });
        }
    };
    ko.validation.registerExtenders();
});