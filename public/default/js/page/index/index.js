/**
 * Created by Ron on 14-6-1.
 */
require(['jquery','knockout','chart','underscore'],function($,ko,chart,_){
    /* Bar Chart starts */
    var data = [];
    $.getJSON(
        '/statistics/ajax-get-total-profit-weekly',
        {startDate:moment().add(-31,'days').format('YYYY-MM-DD'),endDate:moment().format('YYYY-MM-DD')},
        function(returnData){
            var maxDate = _.max(returnData.priceData, function(item){ return item[0]; })[0];
            var minDate = _.min(returnData.priceData, function(item){ return item[0]; })[0];

            data['profitData'] = returnData.profitData;
            data['priceData'] = returnData.priceData;
            var chartIns = new chart({data:[{ data: data['profitData'], label: "利润"},{ data: data['priceData'], label: "销售额"}]});
            chartIns.apply();

            profitLists.profitSum(returnData.sum.totalProfit);
            profitLists.priceSum(returnData.sum.totalPriceAmount);
            profitLists.startTime(getDateFromUTC(minDate));
            profitLists.endTime(getDateFromUTC(maxDate));
            profitLists.list(returnData.profitList);
        }
    );

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
});