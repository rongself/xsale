define(['knockout','validation'], function(ko) {
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
        console.log(exists === null);
        return exists === null;
    };
    ko.validation.registerExtenders();
});