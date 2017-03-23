<?php
namespace app\index\model;

use think\Model;

class Stuwork extends Model
{
    protected $autoWriteTimestamp = true;

    protected function initialize()
    {
        parent::initialize();
    }

    public function uploadMyHomework($data)
    {
        $stuWork = new Stuwork;
        $stuWork->save($data);
    }
}