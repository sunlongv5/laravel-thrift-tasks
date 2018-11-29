<?php
namespace Events\Models;

use Events\Models\MongoModel;
use Gdmin\Fields\ObjectIdField;
use Gdmin\Fields\CharField;
use Gdmin\Fields\NumberField;
use Gdmin\Fields\StringField;
use Gdmin\Fields\TimeField;
use Gdmin\Fields\DictField;
use Gdmin\Fields\FloatField;
use Gdmin\Fields\ListField;
use MongoDB\BSON\ObjectID as MongoId;
use Gdmin\Fields\MongoDateTimeField;

class AdminManagerModel extends MongoModel
{
    protected $connection = 'mongodb';
    protected $collection = 'admin_mysql';
    protected $primaryKey = "_id";

    public static function getFields()
    {
        return [
            '_id' => new ObjectIdField(new MongoId(str_repeat('0', 24)), '自增id'),
            'host' => new StringField('', '域名'),
            'path' => new StringField('', 'path'),
            'method' => new StringField('', '请求方法'),
            'query_time' => new FloatField(0, '请求时间'),
            'status' => new NumberField(0, '状态'),
            'sql' => new StringField('', 'sql语句'),
            'crts' => new TimeField(null, '创建时间'),
            'upts' => new TimeField(null, '更新时间'),
        ];
    }



}