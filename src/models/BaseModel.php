<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    protected $queryCount;
    protected $queryResult;

    protected static $modelLog;

    public function __construct() {}

    public function getCount() {
        return $this->queryCount;
    }

    public function getResult() {
        return $this->queryResult;
    }
}