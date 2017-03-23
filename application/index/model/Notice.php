<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Notice extends Model
{
    protected $autoWriteTimestamp = true;

    public function initialize()
    {
        parent::initialize();
    }

    //全站通知，写入noticeList表中，nid为通知id
    public function announce($data)
    {
        //新增notice表
        $notice = new Notice;
        $notice->data($data);
        $notice->save();
        //取出nid
        $nid = $notice->nid;

        //写入noticeList表
        $noticeList = new NoticeList;

        $users = Db::name('user')->select();
        //遍历用户，写入noticeList的uid
        $list = [];
        foreach ($users as $user) {
            $list[] = [
                'uid' => $user['uid'],
                'nid' => $nid,
            ];
        }
        return $noticeList->saveAll($list, false);
    }

    //新注册用户写入通知noticeList
    public function regAnnounce($uid)
    {
        //获取当前生效的通知
        $notices = Db::name('notice')->where('end_time' , '>' , time())->select();

        //遍历写入数组
        $list = [];
        foreach ($notices as $notice) {
            $list[] = [
                'uid' => $uid,
                'nid' => $notice['nid'],
            ];
        }
        $noticeList = new NoticeList;
        $noticeList->saveAll($list , false);
    }

    //获取全站已发布的全站通知
    public function getAnnouncedNotice($uid = null)
    {

        if (is_null($uid)){
            //获取所有已经发布的通知
            $contents = Db::name('notice')->select();
        }else{
            //获取指定用户->发布的通知
            $contents = Db::name('notice')->where('sender_id' , $uid)->select();
        }


        if ($contents->isEmpty()){
            return false;
        }else{
            $contents->toArray();
            return $contents;
        }
    }

    //获取未读的通知内容
    public function getNotices($uid)
    {
        $content = [];
        $user = User::get($uid);
        //查询指定用户下的所有未读通知
        $nids = $user->notices()->where('status',0)->column('nid');
        foreach ($nids as $nid){
            //todo:返回的内容需要截取，需要增加处理类
            $content[] = Notice::get($nid);
        }
        foreach ($content as $key => $obj){
            $content[$key]->sender_id = User::get($content[$key]->sender_id)->uname;
        }
        return $content;
    }

    //获取所有通知记录
    public function getAllNotices($uid)
    {
        $content = [];
        $user = User::get($uid);
        //查询指定用户下的所有通知
        $nids = $user->notices()->column('nid');
        foreach ($nids as $nid){
            $content[] = Notice::get($nid);
        }
        foreach ($content as $key => $obj){
            $content[$key]->sender_id = User::get($content[$key]->sender_id)->uname;
            $content[$key]->status = NoticeList::get(['nid'=>$content[$key]->nid,'uid'=>$uid])->status;
        }
        return $content;
    }

    //标记通知状态，$action(0,设为已读；1,设为未读)
    public function setRead($action , $uid , $nid=null)
    {
        if (is_null($nid)){
            $result = NoticeList::where('uid', $uid)
                ->update(['status' => $action]);;
        }else{
            $result = NoticeList::where('uid', $uid)->where('nid' , $nid)
                ->update(['status' => $action]);;
        }
        return $result;
    }

    public function delNtc()
    {

    }

    public function upNtc()
    {

    }
}