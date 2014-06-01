/**
 * Created by Ron on 14-5-23.
 */
define(['jquery','flot','underscore','flotResize'],function($,plot,_){
    return function(options){
        var self = this;
        var defaultOptions = {
            elem:'#bar-chart',
            data:[]
        };
        options = $.extend(defaultOptions,options);

        var stack = 1, bars = false, lines = true, steps = false;
        self.apply = function () {
            $.plot($(options.elem), options.data, {
                series: {
                    stack: stack,
                    lines: { show: lines, fill: true, steps: steps },
                    bars: { show: bars, barWidth: 0.8 },
                    points: { show: true }
                },
                grid: {
                    borderWidth: 0, hoverable: true, color: "#777"
                },
                colors:  ["#1eafed"],
                bars: {
                    show: true,
                    lineWidth: 0,
                    fill: true,
                    fillColor: { colors: [ { opacity: 0.9 }, { opacity: 0.8 } ] }
                },
                xaxis: {
                    mode: "time",
                    timeformat: "%y-%m-%d"
                }
            });
        }

        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css( {
                position: 'absolute',
                display: 'none',
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
        $(options.elem).bind("plothover", function (event, pos, item) {
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
        $(".stackControls input").click(function (e) {
            e.preventDefault();
            stack = $(this).val() == "With stacking" ? true : null;
            self.apply();
        });
        $(".graphControls input").click(function (e) {
            e.preventDefault();
            bars = $(this).val().indexOf("Bars") != -1;
            lines = $(this).val().indexOf("Lines") != -1;
            steps = $(this).val().indexOf("steps") != -1;
            self.apply();
        });
        function getDateFromUTC(UTC){
            var dateTime = new Date(parseInt(UTC))
            var month = dateTime.getMonth()+1;
            var date = dateTime.getDate();
            var year = dateTime.getFullYear();
            return year+'/'+month+'/'+date
        }

    }
});
