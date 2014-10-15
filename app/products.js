/**
 *
 */
(function() {
    var app = angular.module('store-products', []);

    app.directive('productTitle', function() {
        return {
            restrict: 'E', // type of directive - element
            // restrict: 'A', // type of directive - attribute
            templateUrl: '/app/templates/product-title.html' // template to use
        };
    });


    /**
     * Product Panels
     *
     * generate tabs and panels switching
     */
    app.directive('productPanels', function() {

        return {

            restrict: 'E', // element
            templateUrl: '/app/templates/product-panels.html', // use template file
            controller: function() { // build controller - no services
                this.tab = 1; // initial selected tab

                // function to select tab when clicked
                this.selectTab = function(setTab) {
                    this.tab = setTab;
                };

                // function to test for active tab
                this.isSelected = function(checkTab) {
                    return this.tab === checkTab;
                };
            },
            controllerAs: 'panel' // initialize controller as panel
        };
    });

    app.directive('productGallery', function() {
        return {
            restrict: 'E',
            templateUrl: '/app/templates/product-gallery.html',
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
            templateUrl: '/app/templates/product-reviews.html',
            controller: function($scope, $http) { // attached services scope and http
                this.review = {};

                this.review.product_id = $scope.product.id;

                // addReview
                this.addReview = function(product) {

                    // define createdOn as now
                    // this.review.createdOn = Date.now(); // no longer necessary - done serverside
                    product.reviews.push(this.review); // add review preview to page

                    // post review to server for storage
                    $http.post('/php/v1/postReview', this.review)
                        .success(function(data, status, headers, config)
                        {
                            console.log(status + ': ' + data);
                        })
                        .error(function(data, status, headers, config)
                        {
                            console.log('error');
                        });


                    // @todo: add call to update review based on stored values in the database in case of truncation or code sanitization


                    this.review = {}; // clear out form
                };
            },
            controllerAs: 'reviewCtrl' // initialize controller as reviewCtrl
        }
    })
})();