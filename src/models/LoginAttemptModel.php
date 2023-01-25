<?php

namespace App\Models;

use App\Helpers\Tools;
use Illuminate\Database\Eloquent\Model;

class LoginAttemptModel extends BaseModel
{
    protected $fillable = ['ip', 'date'];
    public $timestamps = false;

    public function __construct()
    {
        $this->table = 'loginAttempt';
        $this->primaryKey = 'id';
        Model::preventsSilentlyDiscardingAttributes(true);
    }

    public function addAttempt()
    {
        $data = [
            'ip' => Tools::getIp(),
            'date' => strtotime("now")
        ];
        LoginAttemptModel::create($data);
    }

    public function howManyAttempts($ip)
    {
        $lastFiveMinutes = strtotime("5 minutes ago");
        $result = LoginAttemptModel::selectRaw('COUNT(*) AS cnt, ip')->where('ip', '=', $ip)->where('date', '>', $lastFiveMinutes)
            ->groupBy('ip')->get();
        if (count($result) == 0) {
            return 0;
        }
        return $result[0]->attributes['cnt'];
    }
}
