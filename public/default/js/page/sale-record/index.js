/**
 * Created by Ron on 14-5-2.
 */
require(['checkedAll','search'],function(checkedAllHandler,search){
    checkedAllHandler({deleteUrl:'/sale-record/delete-multiple'});
    search({
        setUrl:function(keyword){
            return '/sale-record/index/keyword/'+keyword
        }
    });
});
