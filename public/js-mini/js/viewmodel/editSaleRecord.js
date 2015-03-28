define(["knockout","viewmodel/abstract","viewmodel/saleRecord","viewmodel/saleProduct","knockoutMapping","formPost","message","cookie"],function(e,t,n,r,i,s,o){return function(){t.call(this),n.call(this);var u=this;u.id=e.observable(""),u.ajaxInit=function(){$.getJSON("/sale-record/ajax-get-record",{id:u.id()},function(t){u.orderTime(moment(t.orderTime).format("YYYY-MM-DD")),t.customer&&(u.phoneNumber(t.customer.phoneNumber),u.customerName(t.customer.name));var n=t.orderCarts;for(var i in n){var s=new r(u);s.itemId=e.observable(),s.itemId(n[i].id),s.sku(n[i].product.sku),s.quantity(n[i].quantity),s.price(n[i].price),s.remark(n[i].product.remark),u.saleProducts.push(s)}})},u.submitAndContinue=function(e){if(!(u!=null&&typeof u.saleProducts()=="object"&&u.saleProducts().length>0))return o.warning("进货单中还未加入任何产品"),!1;var t=i.toJSON(u);s.submit({viewModel:u,url:"/sale-record/edit-record",data:{saleRecord:t},success:function(){o.success("进货单已成功提交"),typeof e=="function"&&e()}})},u.setDefaultValue(),u.ajaxInit()}});