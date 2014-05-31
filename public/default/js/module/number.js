/**
 * Created by Ron on 14-5-31.
 */
define(['jquery'],function($){
    return function(){
        $('.spinner .btn:first-of-type').on('click', function() {
            var $input = $(this).parents('.spinner').children('.spinner input');
            var newVal = parseInt($input.val(), 10) + 1;
            $input.val(newVal).trigger('change');
            return false;
        });
        $('.spinner .btn:last-of-type').on('click', function() {
            var $input = $(this).parents('.spinner').children('.spinner input');
            var newVal = parseInt($input.val(), 10) - 1;
            $input.val(newVal).trigger('change');
            return false;
        });
        $('.spinner input').on('change',function(){
            var value = $(this).val();
            var min = $(this).attr('data-min-number');
            var max = $(this).attr('data-max-number');

            if(max&&value>=max){
                $(this).parent().find('.btn:first-of-type').attr('disabled',true);
            }else{
                $(this).parent().find('.btn:first-of-type').attr('disabled',false);
            }
            if(min&&value<=min){
                $(this).parent().find('.btn:last-of-type').attr('disabled',true);
            }else{
                $(this).parent().find('.btn:last-of-type').attr('disabled',false);
            }
        });
        $('.spinner input').on('blur',function(){check(this);});

        function check(input){
            var self = input;
            var value = parseInt($(self).val(),10);
            var min = parseInt($(self).attr('data-min-number'),10);
            var max = parseInt($(self).attr('data-max-number'),10);
            if(value>=max){
                $(self).val(max).trigger('change');
            }
            if(isNaN(value)){
                $(self).val(min).trigger('change');
            }
            if(value<=min){
                $(self).val(min).trigger('change');
            }
        }
        check($('.spinner input'));
    }();
});
