<?php


/**
 *
 */
class Client {

    private $baseUrl;
    private $token;  // Store the bearer token

    public function __construct($baseUrl, $token = null) {
        $this->baseUrl = $baseUrl;
        $this->token = $token;
    }

    public function get($endpoint, $params = []) {
        return $this->request('GET', $endpoint, $params);
    }

    public function post($endpoint, $data = []) {
        return $this->request('POST', $endpoint, [], $data);
    }

    private function request($method, $endpoint, $params = [], $data = []) {
        $url = $this->baseUrl . $endpoint;
        var_dump($url);
        // If there are parameters, append them to the URL
        if (!empty($params) && is_array($params)) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // If a token is provided, set the Authorization header
        if ($this->token) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer " . $this->token
            ]);
        }

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }

        curl_close($ch);
        return $response;
    }
}

