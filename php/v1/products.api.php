<?php

/**
 * class document
 */

class Products
{
    /**
     * config
     * @var object
     */
    private $config;

    /**
     * products list
     * @var array
     */
    private $products = null;


    /**
     * contstructor
     */
    public function __construct()
    {
        require_once 'configuration.php';
        $this->config = new Configuration;
    }




    /**
     * getProducts
     *
     * get list of products and return to caller
     *
     * @return array multidimensional array of products
     */
    public function getProducts()
    {
        return $this->products;
    }


    public function getProductList()
    {
        $db = new mysqli('localhost', $this->config->username, $this->config->password, $this->config->database);

        if ($db->connect_error) {
            die('Connect Error (' . $db->connect_errno . ') '
            . $db->connect_error);
            exit();
        }

        $query = "SELECT * "
                ."FROM products";

        $result = $db->query($query) or die($db->error.__LINE__);

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) {
                $this->products[] = $row;
            }
        } else {
            $this->products[] = 'No Results';
        }

        $db->close();

        return $this;
    }


    /**
     * [getProductImages description]
     * @return [type] [description]
     */
    public function getProductImages()
    {

        $products = $this->products;

        foreach($products as $index=>$product)
        {
            $db = new mysqli('localhost', $this->config->username, $this->config->password, $this->config->database);

            if ($db->connect_error) {
                die('Connect Error (' . $db->connect_errno . ') '
                . $db->connect_error);
                exit();
            }

            $query = "SELECT * "
                    ."FROM images "
                    ."WHERE product_id = ".$product['id'];


            $result = $db->query($query) or die($db->error.__LINE__);

            if ($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()) {
                    $products[$index]['images'][]['full'] = $row['filename'];
                }
            } else {
                $products[$index]['images']['full'] = 'No Images';
            }

            $db->close();
        }



        $this->products = $products;

        return $this;
    }


    public function getProductReviews()
    {
        $products = $this->products;

        foreach($products as $index=>$product)
        {
            $db = new mysqli('localhost', $this->config->username, $this->config->password, $this->config->database);

            if ($db->connect_error) {
                die('Connect Error (' . $db->connect_errno . ') '
                . $db->connect_error);
                exit();
            }

            $query = "SELECT * "
                    ."FROM reviews "
                    ."WHERE product_id = ".$product['id']." "
                    ."AND state = 1";


            $result = $db->query($query) or die($db->error.__LINE__);

            if ($result->num_rows > 0)
            {
                $i = 0;
                while($row = $result->fetch_assoc()) {

                    $products[$index]['reviews'][$i]['rating'] = $row['rating'];
                    $products[$index]['reviews'][$i]['review'] = $row['review'];
                    $products[$index]['reviews'][$i]['author'] = $row['author'];
                    $i++;
                }
            } else {
                $products[$index]['images']['full'] = 'No Images';
            }

            $db->close();
        }

        $this->products = $products;

        return $this;
    }





}