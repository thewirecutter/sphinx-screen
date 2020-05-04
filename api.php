<?php

/**
 * Make believe Product API.
 */
class ProductAPI
{

    /**
     * Mock data to represent DB entries.
     *
     * @var array Mock data.
     */
    protected $mock_data = [
        0 => [
            'id' => 100,
            'name' => 'OXO Good Grips Wire Cheese Slicer with Replaceable Wires',
            'price' => 1599,
        ],
        1 => [
            'id' => 200,
            'name' => 'Western Digital WD Blue SN550 (500 GB)',
            'price' => 6499,
        ],
        2 => [
            'id' => 300,
            'name' => null,
            'price' => false,
        ],
        3 => [
            'id' => 400,
            'name' => 'Ryobi RY40250',
        ],
    ];

    /**
     * Api router/receiver for requests.
     *
     * @param string $method  The method. Expects "GET".
     * @param array  $request The request data.
     *
     * @return array Array of response data.
     */
    public function apiReceiver($method, $request)
    {
        switch ($method) {
            case 'GET':
                return $this->getProduct($request);
            case 'PUT':
                return $this->updateProduct($request);
            default:
                return $this->response(['message' => 'Error. Unknown request.']);
        }
    }

    /**
     * Get a product by ID.
     *
     * @param array $request The request.
     *
     * @return array Array of response data.
     */
    public function getProduct($request)
    {
        if (!isset($request['id']) || !intval($request['id']) > 0) {
            return $this->response(['message' => 'Error: you must provide a product ID']);
        }

        $safe_id = intval($request['id']);
        $response = $this->query(
            "SELECT * FROM `products` WHERE `id` = {$safe_id} LIMIT 1"
        );

        if (!$response) {
            return $this->response(['message' => 'Error: product not found']);
        }

        return $this->response($response);
    }

    public function updateProduct($request)
    {
        if (!isset($request['id']) || !intval($request['id']) > 0) {
            return $this->response(['message' => 'Error: you must provide a product ID']);
        }

        $safe_id = intval($request['id']);
        $name = $request['name'];
        $price = $request['price'];

        $update = $this->query(
            "UPDATE `products`
            SET `name` = {$name}, `price` = {$price}
            WHERE `id` = {$safe_id}
            OR `price` = {$price}
            OR `name`  = {$name}"
        );

        if ($update) {
            $response = $this->query(
                "SELECT * FROM `products` WHERE `id` = {$safe_id} LIMIT 1"
            );
        }

        if (!$response) {
            return $this->response(['message' => 'Error: product not found']);
        }

        return $this->response($response);
    }

    /**
     * Passes a message array to our frontend.
     *
     * @param array $data Array of data.
     * 
     * @return array Array of Product Data.
     */
    protected function response($data)
    {
        // Assumed response, nothing to see here. Pretend this works.
        return $data;
    }

    /**
     * Grabs a random Product ID for the purpose of this exercise.
     *
     * @param string $query The query string.
     * 
     * @return array Array of Product Data.
     */
    protected function query($query)
    {
        $random_key = array_rand($this->mock_data);
        $this->mock_data[$random_key];
    }
}
