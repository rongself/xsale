/**
 * Created by Ron on 14-5-7.
 */
require(['viewmodel/resetPassword','knockout'],function(resetPassword,ko){
    var resetPassword = new resetPassword();
    ko.applyBindings(resetPassword);
});