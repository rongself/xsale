/**
 * Created by Ron on 14-5-5.
 */
define(['jquery','knockout'], function ($,ko) {
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
                $.post(options.url, options.data, function (result) {
                    if (result.success) {
                        options.viewModel.reset();
                        model.errors.showAllMessages(false);
                        if (typeof options.success == 'function') {
                            options.success();
                        }else{
                            throw 'options "success" must a function';
                        }
                    } else {
                        for (key in result.errors) {
                            if (typeof options.viewModel[key] == 'function' && typeof result.errors[key] != 'undefined') {
                                options.viewModel[key].setError(result.errors[key]);
                            } else {
                                alert(result.errors[key]);
                            }
                        }
                    }
                }, 'json')
                    .fail(function () {
                        alert('网络传输错误,请稍后再试');
                        if (typeof options.fail == 'function') {
                            options.fail();
                        }else{
                            throw 'options "fail" must a function';
                        }
                    });
            }else{
                model.errors.showAllMessages();
            }
        }
    }
});