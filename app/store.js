/**
 *
 */

(function() {
    var app = angular.module('store', ['store-products']);

    // fetch product list from server
    // @todo move this to directive
    // @todo investigate dry - use get to get update from server upon review submission?
    app.controller('StoreController', [ '$scope', '$http', function($scope, $http) {
        var store = this;

        store.products = []; // empty array on page load

        $http.get('/php/v1/getProducts').success(function(data) {
           store.products = data;
        });
    }]);

})();
