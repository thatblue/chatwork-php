<?php
namespace Innotama\ChatworkWrapper\Model;

class Member extends BaseModel
{
    protected static $fields = [
        'account_id' => self::VALUE_TYPE_INTEGER,
        'room_id' => self::VALUE_TYPE_INTEGER,
        'name' => self::VALUE_TYPE_STRING,
        'chatwork_id' => self::VALUE_TYPE_STRING,
        'organization_id' => self::VALUE_TYPE_INTEGER,
        'organization_name' => self::VALUE_TYPE_STRING,
        'department' => self::VALUE_TYPE_STRING,
        'title' => self::VALUE_TYPE_STRING,
        'url' => self::VALUE_TYPE_STRING,
        'introduction' => self::VALUE_TYPE_STRING,
        'mail' => self::VALUE_TYPE_STRING,
        'tel_organization' => self::VALUE_TYPE_STRING,
        'tel_extension' => self::VALUE_TYPE_STRING,
        'tel_mobile' => self::VALUE_TYPE_STRING,
        'skype' => self::VALUE_TYPE_STRING,
        'facebook' => self::VALUE_TYPE_STRING,
        'twitter' => self::VALUE_TYPE_STRING,
        'avatar_image_url' => self::VALUE_TYPE_STRING,
    ];
}
