/**
 *
 */

(function() {
    var app = angular.module('store-products', []);

    app.directive('productTitle', function() {
        return {
            restrict: 'E', // type of directive - element
            // restrict: 'A', // type of directive - attribute
            templateUrl: '/assets/angular/templates/product-title.html' // template to use
        };
    });

    app.directive('productPanels', function() {
        return {
            restrict: 'E',
            templateUrl: '/assets/angular/templates/product-panels.html',
            controller: function() {
                this.tab = 1;

                this.selectTab = function(setTab) {
                    this.tab = setTab;
                };

                this.isSelected = function(checkTab) {
                    return this.tab === checkTab;
                };
            },
            controllerAs: 'panel'
        };
    });

    app.directive('productGallery', function() {
        return {
            restrict: 'E',
            templateUrl: '/assets/angular/templates/product-gallery.html',
            controller: function() {
                this.current = 0;

                this.selectImage = function(setCurrent) {
                    this.current = setCurrent;
                };

                this.isCurrent = function(checkCurrent) {
                    return this.current === checkCurrent;
                };
            },
            controllerAs: 'gallery'
        };
    });

    app.directive('productReviews', function() {
        return {
            restrict: 'E',
            templateUrl: '/assets/angular/templates/product-reviews.html',
            controller: function($scope, $http) {
                this.review = {};

                this.review.product_id = $scope.product.id;


                this.addReview = function(product) {
                    this.review.createdOn = Date.now(); // add review date
                    product.reviews.push(this.review);

                   $http.post('/php/v1/postReview', this.review)
                        .success(function(data, status, headers, config)
                        {
                            console.log(status + ': ' + data);
                        })
                        .error(function(data, status, headers, config)
                        {
                            console.log('error');
                        });




                    // this.review = {}; // clear out form
                };
            },
            controllerAs: 'reviewCtrl'
        }
    })
})();