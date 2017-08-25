<?php
namespace Innotama\ChatworkWrapper;

use GuzzleHttp\Client;
use Innotama\ChatworkWrapper\Exceptions\TooManyRequestsException;
use Innotama\ChatworkWrapper\Model\Member;
use Innotama\ChatworkWrapper\Model\Room;
use Innotama\ChatworkWrapper\Model\Status;
use Innotama\ChatworkWrapper\Model\Task;

class ChatworkClient
{
    private $apiKey;
    private $client;
    private $timezone;

    const BASE_URL = 'https://api.chatwork.com/v2/';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    const STATUS_TOO_MANY_REQUESTS = 429;

    const ARRAY_DELIMITER = ',';

    public function __construct($apiKey, $timezone = null)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => static::BASE_URL,
        ]);
        $this->timezone = $timezone ? $timezone : ini_get('date.timezone');
    }

    /**
     * 自分自身の情報にアクセスするAPIをコールします
     *
     * @see http://developer.chatwork.com/ja/endpoint_me.html#GET-me
     * @return Member
     */
    public function me()
    {
        $response = $this->callApi(static::METHOD_GET, 'me');
        $member = new Member($response, $this->timezone);

        return $member;
    }

    /**
     * 自分の未読数、タスク数を取得するAPIをコールします
     *
     * @see http://developer.chatwork.com/ja/endpoint_my.html#GET-my-status
     * @return Status
     */
    public function myStatus()
    {
        $response = $this->callApi(static::METHOD_GET, 'my/status');
        $status = new Status($response, $this->timezone);

        return $status;
    }

    /**
     * 自分のタスク一覧を取得するAPIをコールします
     *
     * @see http://developer.chatwork.com/ja/endpoint_my.html#GET-my-tasks
     * @return Task[]
     */
    public function myTasks()
    {
        $response = $this->callApi(static::METHOD_GET, 'my/tasks');

        $tasks = [];
        foreach ($response as $task) {
            $tasks[] = new Task($task, $this->timezone);
        }

        return $tasks;
    }

    /**
     * 自分のコンタクト一覧を取得するAPIをコールします
     *
     * @see http://developer.chatwork.com/ja/endpoint_contacts.html#GET-contacts
     * @return Member[]
     */
    public function contacts()
    {
        $response = $this->callApi(static::METHOD_GET, 'contacts');

        $contacts = [];
        foreach($response as $contact) {
            $contacts[] = new Member($contact, $this->timezone);
        }

        return $contacts;

    }

    /**
     * チャット一覧を取得します
     *
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms
     * @return array
     */
    public function getRooms()
    {
        $response = $this->callApi(static::METHOD_GET, 'rooms');

        $rooms = [];
        foreach ($response as $room) {
            $rooms[] = new Room($room, $this->timezone);
        }

        return $rooms;
    }

    /**
     * 新しくチャット(部屋)を作成します
     *
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#POST-rooms
     * @param array $membersAdminIds [required]
     * @param string $name [required]
     * @param null|string $description
     * @param null|string $iconPreset
     * @param array $membersMemberIds
     * @param array $membersReadOnlyIds
     * @return Room
     */
    public function postRooms(array $membersAdminIds, $name, $description = null, $iconPreset = null, array $membersMemberIds = [], array $membersReadOnlyIds = [])
    {
        // 必須パラメータ
        $params = [
            'members_admin_ids' => implode(static::ARRAY_DELIMITER, $membersAdminIds),
            'name' => $name,
        ];

        // 任意のパラメータ
        if($description) {
            $params['description'] = $description;
        }
        if($iconPreset) {
            $params['icon_preset'] = $iconPreset;
        }
        if($membersMemberIds) {
            $params['members_member_ids'] = implode(static::ARRAY_DELIMITER, $membersMemberIds);
        }
        if($membersReadOnlyIds) {
            $params['members_readonly_ids'] = implode(static::ARRAY_DELIMITER, $membersReadOnlyIds);
        }


        $response = $this->callApi(static::METHOD_POST, 'rooms', $params);

        return new Room($response, $this->timezone);
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
