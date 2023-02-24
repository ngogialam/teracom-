<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

trait GuzzleRequest
{
    private $headers = [];

    /**
     * Make request to the api and parse response
     *
     * @param string $method
     * @param string $url
     * @param boolean $auth
     * @param array $query
     * @return mixed
     */
    public function makeRequest(string $method, string $url, bool $auth = false, array $query = []): mixed
    {
        if ($auth === true) {
            $authToken = $this->makeRequest('post', config('account-service.url.generate-token'), false, [
                'email' => config('account-service.email')
            ]);
            if (!empty($authToken->code) && $authToken->code !== 200) {
                return null;
            }
            $this->headers['Authorization'] = 'Bearer ' . $authToken->data->token;
        }
        $this->headers['Api-key'] = config('account-service.api_key');
        $this->headers['Accept'] = 'application/json';
        try {
            $client = new Client();
            $multipart = $query['multipart'] ?? [];
            unset($query['multipart']);
            $response = $client->request($method, $url, [
                'headers' => $this->headers,
                'query' => $query,
                'verify' => false,
                'multipart' => $multipart,
                'timeout' => 30,
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $requestUri = $e->getRequest()->getUri();
            $response = $e->getResponse();

            $code = $response->getStatusCode();
            $reason = $response->getReasonPhrase();
            $schema = $requestUri->getScheme();
            $host = $requestUri->getHost();
            $path = $requestUri->getPath();
            Log::error('[' . $code . ']' . '[' . $reason . ']' . ' ' . $schema . '://' . $host . $path);
            return json_decode($response->getBody()->getContents());
        }
    }
}
