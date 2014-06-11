/**
 * Created by Administrator on 14-6-10.
 */
define(['knockout'],function(ko){
    return function(){
        var self = this;
        self.setDefaultValue = function(){
            for(protype in self){
                if(ko.isWriteableObservable(self[protype])){
                    var $ele = $('#'+protype);
                    if($ele.length>0){
                        var value = $ele.attr('data-value');
                        if(value!=''){
                            if(value=='true'){
                                value = true;
                            }else if(value=='false'){
                                value = false;
                            }
                            self[protype](value);
                        }else{
                            self[protype]('');
                        }
                    }
                }
            }
        };

        self.ajaxInit = function(){

        }

        self.reset = function(){
            self.init();
        }
    }
});
