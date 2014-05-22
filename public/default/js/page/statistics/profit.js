/**
 * Created by Administrator on 14-5-22.
 */
require(['jquery','datetimepicker','flot'],function($,datetimepicker,flot){
    $('#startTime').datetimepicker();
    $('#endTime').datetimepicker();

    /* Bar Chart starts */

    $.getJSON('/statistics/ajax-get-total-profit-weekly',function(data){
        plotWithOptions(data);
    });

    var stack = 0, bars = true, lines = false, steps = false;
    function plotWithOptions(data) {
        var plot = $.plot($("#bar-chart"),
            [ { data: data, label: "利润"}], {
                series: {
                    lines: { show: true, fill: true},
                    points: { show: true }
                },
                grid: { hoverable: true, clickable: true, borderWidth:0 },
                colors: ["#1eafed", "#1eafed"],
                xaxis: {
                    mode: "time",
                    timeformat: "%y/%m/%d"
                }
            });
    }
    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            //display: 'none',
            top: y + 5,
            border: '1px solid #000',
            padding: '2px 8px',
            color: '#ccc',
            'background-color': '#000',
            opacity: 0.9,
            'z-index':101
        }).appendTo("body").css({
            left:function(){
                var tipWidth = parseInt($('#tooltip').outerWidth());
                if(x+5+tipWidth>=$('body').width())
                {
                    return x+5-tipWidth;
                }else{
                    return x+5;
                }
            }
        }).fadeIn(200);
    }

    var previousPoint = null;
    $("#bar-chart").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showTooltip(item.pageX, item.pageY,
                        item.series.label + ":" + getDateFromUTC(x) + " = " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;
            }
    });

    function getDateFromUTC(UTC){
        var dateTime = new Date(parseInt(UTC))
        var month = dateTime.getMonth()+1;
        var date = dateTime.getDate();
        var year = dateTime.getFullYear();
        return year+'/'+month+'/'+date
    }
});