<?php

namespace App\Models;

use App\Classes\Date;
use App\Classes\Redis;
use App\Entities\Admin as AdminClass;
use App\Helpers\Tools;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class Admin extends BaseModel
{
    protected $fillable = ['isSuper', 'name', 'mobile', 'password', 'token', 'created_at', 'updated_at', 'passCall'];
    public $timestamps = false;

    public function __construct()
    {
        $this->table = 'admin';
        $this->primaryKey = 'id';
        Model::preventsSilentlyDiscardingAttributes(true);
    }

    public function getAll($whereQ = [])
    {
        $skip = Tools::startSkip(LIMIT);
        $res = json_encode(
            DB::table($this->table)->where(function ($query) use ($whereQ) {
                foreach ($whereQ as $key => $value) {
                    $query->orWhere($key, 'LIKE', '%' . $value . "%");
                }
            })->skip($skip)->take(LIMIT)->orderBy('created_at', 'DESC')->get()
        );
        return $this->dataPure(json_decode(html_entity_decode($res)));
    }

    public function getById($id)
    {
        return Admin::where('id', '=', $id)->get()[0];
    }

    public function updateById(AdminClass $admin)
    {
        // updating all of data
        $data = [
            'name' => $admin->getName(),
            'isSuper' => strval($admin->getIsSuper()),
            'mobile' => $admin->getMobile(),
            'passCall' => strval($admin->getPassCall()),
            'updated_at' => Date::now(),
            'access' => json_encode($admin->getAccess())
        ];
        if ($admin->getPassword() != "") {
            $hashed = $admin->hashPassword();
            $data['password'] = $hashed;
        }
        $updateResult = Admin::where('id', $admin->getId())->update($data);

        $this->redisStore("admins", $this);

        return $updateResult;
    }

    public function updateAdmin(AdminClass $adminClass, array $data)
    {
        return DB::table($this->table)->where([
            ['id', '=', $adminClass->getId()]
        ])->update($data);
    }

    public function getByFieldName($fieldName, $value)
    {
        return Admin::where($fieldName, '=', $value)->get();
    }

    public function insert(AdminClass $admin)
    {
        $foundedId = $this->isAdminNew($admin);
        if ($foundedId == 0) {
            $hashed = $admin->hashPassword();
            $data = [
                'isSuper' => $admin->getIsSuper(),
                'passCall' => $admin->getPassCall(),
                'name' => $admin->getName(),
                'mobile' => $admin->getMobile(),
                'password' => $hashed,
                'created_at' => Date::now(),
                'access' => json_encode($admin->getAccess())
            ];
            $res = Admin::create($data); // returns 0 or 1 for insertion
            $this->redisStore("admins", $this);
            return $res;
        }
        return 0;
    }

    public function insertWithLastId(AdminClass $admin)
    {
        $foundedId = $this->isAdminNew($admin);
        if ($foundedId == 0) {
            $hashed = $admin->hashPassword();
            $data = [
                'isSuper' => $admin->getIsSuper(),
                'passCall' => $admin->getPassCall(),
                'name' => $admin->getName(),
                'mobile' => $admin->getMobile(),
                'password' => $hashed,
                'created_at' => Date::now(),
                'access' => json_encode($admin->getAccess())
            ];
            $admin = Admin::create($data);
            $this->redisStore("admins", $this);
            return $admin->id();
        }
        return $foundedId; // return the founded id from database;
    }

    public function deleteById($id)
    {
        $deleteResult = Admin::where('id', '=', $id)->delete();
        $this->redisStore("admins", $this);
        return $deleteResult;
    }

    public function isAdminNew(AdminClass $admin)
    {
        $res = Admin::where('mobile', $admin->getMobile())->select(['id'])->get();
        if (count($res) > 0) {
            return $res[0]['id']; //user id will be returned
        }
        return 0; // no user found
    }

    public function loginCheck(AdminClass $admin)
    {
        $res = Admin::where('mobile', $admin->getMobile())->limit(1)->select(['id', 'password', 'mobile'])->get();
        if (count($res) > 0) {
            if (password_verify($admin->getPassword(), $res[0]->password)) {
                return $res[0]->id;
            }
        }
        return 0;
    }

    public function getAccessAttribute($value)
    {
        return json_decode(html_entity_decode($value));
    }
}
