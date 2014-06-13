/**
 * Created by Ron on 14-5-2.
 */
require(['checkedAll','search'],function(checkedAllHandler,search){
    checkedAllHandler({deleteUrl:'/account/delete-multiple'});
    search({
        setUrl:function(keyword){
            return '/account/index/keyword/'+keyword
        }
    });
});
