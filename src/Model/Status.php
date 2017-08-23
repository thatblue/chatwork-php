<?php
namespace Innotama\ChatworkWrapper\Model;

class Status extends BaseModel
{
    protected static $fields = [
        'unread_room_num' => self::VALUE_TYPE_INTEGER,
        'mention_room_num' => self::VALUE_TYPE_INTEGER,
        'mytask_room_num' => self::VALUE_TYPE_INTEGER,
        'unread_num' => self::VALUE_TYPE_INTEGER,
        'mention_num' => self::VALUE_TYPE_INTEGER,
        'mytask_num' => self::VALUE_TYPE_INTEGER,
    ];
}
