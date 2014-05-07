/**
 * Created by Ron on 14-5-7.
 */
require(['viewmodel/changePassword','knockout'],function(changePassword,ko){
    var changePassword = new changePassword();
    ko.applyBindings(changePassword);
});