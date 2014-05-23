/**
 * Created by Administrator on 14-5-22.
 */
require(['jquery','knockout','viewmodel/statistics','datetimepicker','chart','underscore'],function($,ko,Statistics,datetimepicker,chart,_){
    $('#startTime').datetimepicker();
    $('#endTime').datetimepicker();
    var profitLists = new Statistics();
    /* Bar Chart starts */
    var data = [];
    $.getJSON('/statistics/ajax-get-total-profit-weekly',function(returnData){
        var maxDate = _.max(returnData.priceData, function(item){ return item[0]; })[0];
        var minDate = _.min(returnData.priceData, function(item){ return item[0]; })[0];

        data['profitData'] = returnData.profitData;
        data['priceData'] = returnData.priceData;
        var chartIns = new chart({data:[{ data: data['profitData'], label: "利润"},{ data: data['priceData'], label: "销售额"}]});
        chartIns.apply();

        profitLists.profitSum(returnData.sum.totalProfit);
        profitLists.priceSum(returnData.sum.totalPriceAmount);
        profitLists.startTime(getDateFromUTC(maxDate));
        profitLists.endTime(getDateFromUTC(minDate));
    });

    function dailyFill(data,maxDate,minDate){
        var secondsOfDay = 24*60*60*1000;
        for(var i=minDate;i<maxDate;i+=secondsOfDay){
            if(_.find(data,function(item){return item[0]==i})==null){
                data.push([i,0]);
            }
        }
        return _.sortBy(data, function(num){ return num[0]; });
    }

    function weeklyFill(data,maxDate,minDate){
        var secondsOfWeek = 24*60*60*1000*7;
        minDate = getLastDayOfThisWeek(minDate);
        maxDate = getLastDayOfThisWeek(maxDate);
        for(var i=minDate;i<maxDate;i+=secondsOfWeek){
            if(_.find(data,function(item){return item[0]==i})==null){
                data.push([i,0]);
            }
        }
        return _.sortBy(data, function(num){ return num[0]; });
    }

    function getDateFromUTC(UTC){
        var dateTime = new Date(parseInt(UTC))
        var month = dateTime.getMonth()+1;
        var date = dateTime.getDate();
        var year = dateTime.getFullYear();
        return year+'/'+month+'/'+date
    }

    ko.applyBindings(profitLists,$('#profitList').get(0));
});