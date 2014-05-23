/**
 * Created by Administrator on 14-5-23.
 */
define(['knockout'], function(ko) {
    return function(){
        var self = this;
        self.profitSum = ko.observable(0);
        self.priceSum = ko.observable(0);
        self.profitRate = ko.computed(function(){
            return (self.profitSum()/self.priceSum()*100).toFixed(2);
        });
        self.startTime = ko.observable();
        self.endTime = ko.observable();
        self.list = ko.observableArray();

        self.reset = function(){
            self.profitSum(0);
            self.priceSum(0);
            self.profitRate(0);
            self.list.removeAll();
        }
    }
});
