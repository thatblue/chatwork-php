<?php
namespace Innotama\ChatworkWrapper\Model;

use Carbon\Carbon;

class BaseModel
{
    protected $values;
    protected static $fields = [];

    const VALUE_TYPE_INTEGER = 'integer';
    const VALUE_TYPE_STRING = 'string';
    const VALUE_TYPE_TIMESTAMP = 'timestamp';

    /**
     * BaseModel constructor.
     * @param $values
     */
    public function __construct($values)
    {
        $this->values = [];
        foreach ($values as $key => $value) {
            if(isset(static::$fields[$key]) || in_array($key, static::$fields)) {
                if(isset(static::$fields[$key])) {
                    // データ型が設定してある場合
                    switch (static::$fields[$key]) {
                        case static::VALUE_TYPE_INTEGER:
                            $this->values[$key] = (int)$value;
                            break;
                        case static::VALUE_TYPE_TIMESTAMP:
                            $this->values[$key] = Carbon::createFromFormat('U', $this->values[$key]);
                            break;
                        case static::VALUE_TYPE_STRING:
                        default:
                            $this->values[$key] = $value;
                            break;
                    }
                } else {
                    // データ型の定義がない場合はそのままセット
                    $this->values[$key] = $value;
                }
            }
        }
    }

    /**
     * getter
     *
     * @param $name
     * @return mixed|null
     */
    function __get($name)
    {
        if(isset($this->values[$name])) {
            return $this->values[$name];
        }

        return null;
    }
}
