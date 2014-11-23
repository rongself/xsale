({
    appDir: './default',
    baseUrl: "./js",
    dir: "./js-mini",
    modules: [
        {
            name: 'main'
        },
        {
            name:'page/index/index'
        },
        {
            name:'page/stock-record/create-record'
        }
    ],
    fileExclusionRegExp: /^(r|build)\.js$/,
    optimizeCss: 'standard',
    removeCombined: true,
    paths: {
        jquery: 'lib/jquery',
        knockout: 'lib/knockout',
        bootstrap: 'lib/bootstrap',
        custom: 'lib/custom',
        switch:'lib/bootstrap-switch.min',
        validation:'lib/knockout.validation',
        validationConfig:'module/knockout.validation.config',
        typeahead:'lib/typeahead.min',
        underscore:'lib/underscore.min',
        loadBar:'lib/jquery.loadingbar.min',
        knockoutMapping:'lib/knockout.mapping',
        checkedAll:'module/checked.all.handle',
        pace:'lib/pace.min',
        formPost:'module/formPost',
        imageUploader:'module/image.uploader',
        message:'module/message',
        datetimepicker:'lib/bootstrap-datetimepicker',
        moment:'lib/moment',
        'moment.zh-CN':'lib/moment.zh-CN',
        flot:'lib/jquery.flot',
        flotResize:'lib/jquery.flot.resize',
        date:'lib/date-utils',
        chart:'module/chart.helper',
        cookie:'lib/jquery.cookie',
        search:'module/search'
    }
})