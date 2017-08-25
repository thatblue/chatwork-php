<?php
namespace Innotama\ChatworkWrapper\Model;

class Task extends BaseModel
{
    protected static $fields = [
        'task_id' => self::VALUE_TYPE_INTEGER,
        'message_id' => self::VALUE_TYPE_STRING, // 桁数が多いので文字列として扱う
        'body' => self::VALUE_TYPE_STRING,
        'limit_time' => self::VALUE_TYPE_TIMESTAMP,
        'status' => self::VALUE_TYPE_STRING,
    ];

    const STATUS_OPEN = 'open';
    const STATUS_DONE = 'done';

    /** @var Room このタスクの設定されているチャット(部屋)の情報 */
    protected $room;
    /** @var Member タスクをアサインしたユーザーの情報 */
    protected $assigned_by_account;

    public function __construct($values, $timezone = null)
    {
        parent::__construct($values, $timezone);

        foreach ($values as $key => $childValues) {
            // roomの値を取得して格納
            switch ($key) {
                case 'room':
                    $this->room = new Room($childValues, $timezone);
                    break;
                case 'assigned_by_account':
                    $this->assigned_by_account = new Member($childValues, $timezone);
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * このタスクが終了済みのものであるかを取得します
     *
     * @return bool
     */
    public function hasDone()
    {
        return $this->status === static::STATUS_DONE;
    }

    /**
     * タスクの設定されたチャット(部屋)の情報を取得します
     *
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * タスクを設定したユーザーの情報を取得します
     *
     * @return Member
     */
    public function getAssignedByAccount()
    {
        return $this->assigned_by_account;
    }


}
