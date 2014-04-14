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

    existsInArray = function(val,array) {
        var exists = _.find(array, function(item) {
            return item.sku === val;
        })
        return exists !== null;
    };
    ko.validation.registerExtenders();
});