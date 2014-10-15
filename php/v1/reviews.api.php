<?php

class Reviews
{

    var $config;

    var $review;

    public function __construct()
    {
        require_once 'configuration.php';
        $this->config = new Configuration;
    }

    public function checkReview($review)
    {

        if (!isset($review->product_id)) {
            $review->product_id = '-1';
        }

        if (!isset($review->rating)) {
            $review->rating = 0;
        }

        if (!isset($review->review)) {
            $review->review = '';
        }

        if (!isset($review->author)) {
            $review->author = 'anonymous';
        }

        $this->review = $review;

        return $this;
    }

    public function storeReview()
    {
        $review = $this->review;

        $db = new mysqli('localhost', $this->config->username, $this->config->password, $this->config->database);

        if ($db->connect_error) {
            die('Connect error ('.$db->connect_errno .') ' . $db->connect_error);
            exit();
        }

        foreach($review as $key=>$field) {
            $review->$key = $db->real_escape_string($field);
        }

        $query = 'INSERT INTO `reviews`'
            .' (`rating`, `review`, `author`, `state`, `createdOn`, `product_id`)'
            .' VALUES ("' . $review->rating . '"'
                   .', "' . $review->review . '"'
                   .', "' . $review->author . '"'
                   .', "1"' // published by default
                   .', "' . date('Y-m-d H:i:s'). '"'
                   .', "' . $review->product_id .'"'
                   .')';

        $db->query($query) or die($db->error.__LINE__);

        $db->close();

        return $this;
    }
}