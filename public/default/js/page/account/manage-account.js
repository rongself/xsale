/**
 * Created by Ron on 14-5-7.
 */
require(['viewmodel/manageAccount','knockout'],function(manageAccount,ko){
    var manageAccount = new manageAccount();
    ko.applyBindings(manageAccount);
});

