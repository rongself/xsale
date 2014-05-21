/**
 * Created by Ron on 14-5-5.
 */
define(['jquery','knockout','message'], function ($,ko,message) {
    return {
        submit: function (options) {
            var defaultOptions = {
                viewModel:'',
                url:'',
                data:'',
                success:'',
                fail:''
            };
            options = $.extend(defaultOptions,options);
            var model = ko.validatedObservable(options.viewModel);
            if(model.isValid()){
                $.ajax({
                    url: options.url,
                    type: 'POST',
                    data: options.data,
                    dataType:'json'
                })
                .done(function (result) {
                    if (result.success) {
                        if (typeof options.success == 'function') {
                            options.success();
                        }
                        model.errors.showAllMessages(false);
                    } else {
                        for (key in result.errors) {
                            if (typeof options.viewModel[key] == 'function' && typeof result.errors[key] != 'undefined') {
                                options.viewModel[key].setError(result.errors[key]);
                            } else {
                                message.error(result.errors[key]);
                            }
                        }
                    }
                }, 'json')
                .fail(function () {
                        message.error('网络传输错误,请稍后再试');
                        if (typeof options.fail == 'function') {
                            options.fail();
                        }
                    });
            }else{
                model.errors.showAllMessages();
            }
        }
    }
});