/**
 *
 */

(function() {
    var app = angular.module('store', ['store-products']);

    // fetch product list from server
    app.controller('StoreController', [ '$scope', '$http', function($scope, $http) {
        var store = this;

        store.products = []; // empty array on page load

        $http.get('/php/v1/getProducts').success(function(data) {
           store.products = data;
        });
    }]);

})();
