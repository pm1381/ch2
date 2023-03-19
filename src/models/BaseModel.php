<?php

namespace App\Models;

use App\Classes\Date;
use App\Classes\Redis;
use App\Helpers\Tools;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class BaseModel extends Model
{
    protected $queryCount;
    protected $queryResult;
    protected static $modelLog;

    public function __construct()
    {
    }

    public function getCount()
    {

        return $this->queryCount;
    }

    public function getResult()
    {

        return $this->queryResult;
    }

    public function redisStore($keyName, $modelName)
    {
        $redis = new Redis($keyName);
        $res = json_encode($modelName::all());
        $redis->store($res)->expireDate(60);
    }

    public function countQuery($whereQ = [])
    {
        $res = DB::table($this->table)->where(function ($query) use ($whereQ) {
            foreach ($whereQ as $key => $value) {
                $query->orWhere($key, 'LIKE', '%' . $value . "%");
            }
        })->get();

        return count($res);
    }

    protected function dataPure($itemsCollection)
    {
        $final = $itemsCollection;
        foreach ($final as $value) {
            if (Tools::checkObject($value, 'mobile')) {
                if (strlen($value->mobile) == 10) {
                    $value->mobile = "0" . $value->mobile;
                }
            }
            if (Tools::checkObject($value, 'created_at')) {
                $value->created_at = Date::M2J("Y-m-d , H:i:s", $value->created_at);
            }
        }
        return $final;
    }
}
