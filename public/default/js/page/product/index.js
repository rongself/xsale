/**
 * Created by Ron on 14-5-2.
 */
require(['checkedAll','search'],function(checkedAllHandler,search){
    checkedAllHandler({deleteUrl:'/product/delete-multiple'});
    search({
        setUrl:function(keyword){
            return '/product/index/keyword/'+keyword;
        }
    });
});
