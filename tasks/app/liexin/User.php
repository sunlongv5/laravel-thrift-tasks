<?php
namespace  Liexin;
use Request;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'crm';
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;



    /**
     * 获取主键值
     *
     * @return string
     */
    public function getIdAttribute() {
        return isset(app('request')->user) ? strval(app('request')->user->userId) : 0;

    }


    public function getUserInfoAttribute(){
        $emptyObject =  new \stdClass();
        return isset(app('request')->user) ? app('request')->user : $emptyObject;
    }



}