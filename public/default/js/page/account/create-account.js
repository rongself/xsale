/**
 * Created by Ron on 14-5-3.
 */
require(['viewmodel/account','knockout'],function(Account,ko){
    var account = new Account();
    ko.applyBindings(account);
});
