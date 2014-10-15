<?php

require_once 'API.class.php';

class MyAPI extends API
{
    var $config;

    public $products;

    public function __construct($request, $origin) {
        parent::__construct($request);

        require_once 'configuration.php';
        $this->config = new Configuration;

        switch($origin)
        {
            case 'http://'.$this->config->access_url:
            case 'https://'.$this->config->access_url:
            case $this->config->access_url:
                break;

            default:
                throw new Exception('Invalid access domain');
      }

    }

    /**
     * getProducts
     *
     * /getProducts
     */
    protected function getProducts() {
        if ($this->method == 'GET') {
            require_once 'products.api.php';

            $products = new Products();
            $data = $products->getProductList()
                             ->getProductImages()
                             ->getProductReviews()
                             ->getProducts();

            return $data;

        } else {
            return 'Only accepts GET requests';
        }

    }

    protected function postReview() {
        if ($this->method == 'POST') {
            require_once 'reviews.api.php';

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $review = new Reviews();
            $data = $review->checkReview($request)
                           ->storeReview();

            return $data;
//
            // $review = new Reviews();
//
            // $data = $review->checkReview($_POST);
                           // ->storeReview();

            // return $data;

        } else {
            return 'Only accepts POST requests';
        }
    }
 }