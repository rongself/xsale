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
            return item.sku() === val;
        })
        return exists === null;
    };
    ko.validation.registerExtenders();
});