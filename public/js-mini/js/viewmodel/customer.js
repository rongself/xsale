define(["knockout","knockoutMapping","formPost","message","validation","validationConfig"],function(e,t,n,r){return function(){var i=this;i.name=e.observable(),i.phoneNumber=e.observable().extend({required:{message:"客户手机号不能为空"},number:{message:"手机号格式不正确"},isPhoneNumberExists:i}),i.wechat=e.observable(),i.qq=e.observable(),i.isVip=e.observable(!1),i.remark=e.observable(),i.reset=function(){i.name(""),i.phoneNumber(""),i.wechat(""),i.qq(""),i.isVip(!1),i.remark("")},i.submitAndContinue=function(e){if(i.phoneNumber.isValidating())return $(".submitTo").button("loading"),setTimeout(function(){i.submitAndContinue(e)},50),!1;$(".submitTo").button("reset");var s=t.toJSON(i);n.submit({viewModel:i,url:"/customer/create-customer",data:{customer:s},success:function(){i.reset(),r.success("添加成功"),typeof e=="function"&&e()}})},i.submit=function(){i.submitAndContinue(function(){location.href="/customer/index"})}}});