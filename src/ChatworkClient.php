<?php
namespace Innotama\ChatworkWrapper;

use GuzzleHttp\Client;
use Innotama\ChatworkWrapper\Exceptions\TooManyRequestsException;
use Innotama\ChatworkWrapper\Model\Member;

class ChatworkClient
{
    private $apiKey;
    private $client;

    const BASE_URL = 'https://api.chatwork.com/v2/';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    const STATUS_TOO_MANY_REQUESTS = 429;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => static::BASE_URL,
        ]);
    }

    /**
     * 自分自身の情報にアクセスするAPIをコールします
     *
     * @see http://developer.chatwork.com/ja/endpoint_me.html#GET-me
     */
    public function me()
    {
        $response = $this->callApi(static::METHOD_GET, 'me');
        $member = new Member($response);

        return $member;
    }

    protected static $paramKeys = [
        self::METHOD_GET => 'query',
        self::METHOD_POST => 'form_params',
        self::METHOD_PUT => 'form_params',
        self::METHOD_DELETE => 'form_params',
    ];

    /**
     * APIをコールします
     *
     * @param $method
     * @param $endpoint
     * @param array $params
     * @return mixed
     * @throws TooManyRequestsException
     */
    protected function callApi($method, $endpoint, $params = [])
    {
        $response = $this->client->request($method, $endpoint, [
            'headers' => ['X-ChatWorkToken' => $this->apiKey],
            static::$paramKeys[$method] => $params,
        ]);

        // 実行回数制限を超過している
        if($response->getStatusCode() === static::STATUS_TOO_MANY_REQUESTS) {
            throw new TooManyRequestsException($response->getHeader('X-RateLimit-Reset'), $response->getHeader('X-RateLimit-Limit'));
        }

        return json_decode($response->getBody(), true);
    }
}