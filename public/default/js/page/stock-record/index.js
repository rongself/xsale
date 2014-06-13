/**
 * Created by Ron on 14-5-2.
 */
require(['checkedAll','message','search'],function(checkedAllHandler,message,search){
    checkedAllHandler({deleteUrl:'/stock-record/delete-multiple'});
    search({
        setUrl:function(keyword){
            return '/stock-record/index/keyword/'+keyword
        }
    });
});
