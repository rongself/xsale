/**
 * Created by Ron on 14-3-30.
 */
define(['knockout','validation','validationConfig'], function(ko) {
    return function() {
        var self = this;
        self.id = ko.observable();
        self.url = ko.observable();
        self.type = ko.observable();
    }
});