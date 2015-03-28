define(["knockout","knockoutMapping","formPost","message","viewmodel/abstract","validation","validationConfig"],function(e,t,n,r,i){return function(){i.call(this);var s=this;s.id=e.observable(),s.sku=e.observable().extend({required:{message:"产品款号不能为空"},pattern:{message:"款号只能是字母,数字,_,-,#组合",params:"^[a-zA-Z0-9_#-]+$"}}),s.name=e.observable(),s.cost=e.observable().extend({required:{message:"进货价不能为空"},number:{message:"进货价必须为数字"}}),s.stock=e.observable().extend({required:{message:"库存不能为空"},number:{message:"库存必须位数字"},min:{params:0,message:"库存必须大于0"}}),s.pictures=e.observableArray(),s.price=e.observable().extend({number:{message:"零售价必须为数字"}}),s.description=e.observable(),s.reset=function(){s.sku(""),s.name(""),s.cost(""),s.stock(""),s.pictures.removeAll(),s.price(""),s.description("")},s.submitAndContinue=function(e){var i=t.toJSON(s);n.submit({viewModel:s,url:"/product/edit-product",data:{product:i},success:function(){r.success("保存成功"),typeof callback=="function"&&callback()}})},s.setDefaultValue()}});