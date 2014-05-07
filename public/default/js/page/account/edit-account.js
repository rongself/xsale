/**
 * Created by Ron on 14-5-7.
 */
require(['viewmodel/editAccount','knockout'],function(editAccount,ko){
    var editAccount = new editAccount();
    ko.applyBindings(editAccount);
});

