define(["jquery"],function(e){return function(){function t(t){var n=t,r=parseInt(e(n).val(),10),i=parseInt(e(n).attr("data-min-number"),10),s=parseInt(e(n).attr("data-max-number"),10);r>=s&&e(n).val(s).trigger("change"),isNaN(r)&&e(n).val(i).trigger("change"),r<=i&&e(n).val(i).trigger("change")}e(".spinner .btn:first-of-type").on("click",function(){var t=e(this).parents(".spinner").children(".spinner input"),n=parseInt(t.val(),10)+1;return t.val(n).trigger("change"),!1}),e(".spinner .btn:last-of-type").on("click",function(){var t=e(this).parents(".spinner").children(".spinner input"),n=parseInt(t.val(),10)-1;return t.val(n).trigger("change"),!1}),e(".spinner input").on("change",function(){var t=e(this).val(),n=e(this).attr("data-min-number"),r=e(this).attr("data-max-number");r&&t>=r?e(this).parent().find(".btn:first-of-type").attr("disabled",!0):e(this).parent().find(".btn:first-of-type").attr("disabled",!1),n&&t<=n?e(this).parent().find(".btn:last-of-type").attr("disabled",!0):e(this).parent().find(".btn:last-of-type").attr("disabled",!1)}),e(".spinner input").on("blur",function(){t(this)}),t(e(".spinner input"))}()});