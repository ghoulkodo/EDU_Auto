<?php
namespace app\index\model;

use think\Model;
class Res extends Model
{
    protected $autoWriteTimestamp = true;
    protected function initialize()
    {
        parent::initialize();
    }

    public function upload($data)
    {
        $res = new Res;
        $res->save($data);
    }

    public function getRes()
    {
        return Res::all();
    }

    public function getResPath($fileNameUrl)
    {
        $res = Res::get(['filename' => $fileNameUrl]);
        return $res->path;
    }

    public function up()
    {

    }
}
//购物车的cookie实现
//$cart = ['gid' => 1];
//
//if ($tmp = get_cookie('cart')){
//    $ka = unserialize($tmp);
//    $ka[] = $cart;
//    $ka = serialize($ka);
//    set_cookie('cart' , $ka);
//}else{
//    $ka = serialize($cart);
//    set_cookie('cart' , $ka);
//}


