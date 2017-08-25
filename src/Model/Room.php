<?php
namespace Innotama\ChatworkWrapper\Model;

class Room extends BaseModel
{
    protected static $fields = [
        'room_id' => self::VALUE_TYPE_INTEGER,
        'name' => self::VALUE_TYPE_STRING,
        'type' => self::VALUE_TYPE_STRING,
        'role' => self::VALUE_TYPE_STRING,
        'sticky' => self::VALUE_TYPE_BOOLEAN,
        'unread_num' => self::VALUE_TYPE_INTEGER,
        'mention_num' => self::VALUE_TYPE_INTEGER,
        'mytask_num' => self::VALUE_TYPE_INTEGER,
        'message_num' => self::VALUE_TYPE_INTEGER,
        'file_num' => self::VALUE_TYPE_INTEGER,
        'task_num' => self::VALUE_TYPE_INTEGER,
        'icon_path' => self::VALUE_TYPE_STRING,
        'description' => self::VALUE_TYPE_STRING,
        'last_update_time' => self::VALUE_TYPE_TIMESTAMP,
    ];

    const TYPE_MY = 'my';
    const TYPE_GROUP = 'group';
    const TYPE_DIRECT = 'direct';

    const ROLE_ADMIN = 'admin';
    const ROLE_MEMBER = 'member';
    const ROLE_READONLY = 'readonly';

    const ICON_PRESET_GROUP = 'group';
    const ICON_PRESET_CHECK = 'check';
    const ICON_PRESET_DOCUMENT = 'document';
    const ICON_PRESET_MEETING = 'meeting';
    const ICON_PRESET_EVENT = 'event';
    const ICON_PRESET_PROJECT = 'project';
    const ICON_PRESET_BUSINESS = 'business';
    const ICON_PRESET_STUDY = 'study';
    const ICON_PRESET_SECURITY = 'security';
    const ICON_PRESET_STAR = 'star';
    const ICON_PRESET_IDEA = 'idea';
    const ICON_PRESET_HEART = 'heart';
    const ICON_PRESET_MAGCUP = 'magcup';
    const ICON_PRESET_BEER = 'beer';
    const ICON_PRESET_MUSIC = 'music';
    const ICON_PRESET_SPORTS = 'sports';
    const ICON_PRESET_TRAVEL = 'travel';

}
