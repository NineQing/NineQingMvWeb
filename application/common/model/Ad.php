<?php
namespace app\common\model;
use think\Db;


class Ad extends  Base
{

    // 设置数据表（不含前缀）
    protected $name = 'ad';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    protected $autoWriteTimestamp = true;

    public function countData($where)
    {
        $total = $this->where($where)->count();
        return $total;
    }


    public function listData($where,$order,$page=1,$limit=20,$start=0,$field='*',$totalshow=1)
    {
        if(!is_array($where)){
            $where = json_decode($where,true);
        }
        $limit_str = ($limit * ($page-1) + $start) .",".$limit;
        if($totalshow==1) {
            $total = $this->where($where)->count();
        }
        $list = Db::name('Ad')->field($field)->where($where)->order($order)->limit($limit_str)->select();     
        foreach($list as $key=>$val){
            $list[$key]["opens"] = $val["opens"] ==0 ? "当前窗口":"新窗口";
            $info = model("Adtype")->where(["id"=>$val["typeid"]])->find();
            $list[$key]["typename"] = $info["typename"];
        }   
        return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$list];
    }


    public function infoData($where,$field='*',$cache=0){
        if(empty($where) || !is_array($where)){
            return ['code'=>1001,'msg'=>'参数错误'];
        }

        $info = $this->field($field)->where($where)->find();
        if (empty($info)) {
            return ['code' => 1002, 'msg' => '获取数据失败'];
        }
        $info = $info->toArray();

        return ['code'=>1,'msg'=>'获取成功','info'=>$info];
    }

    
    public function saveData($data)
    {
        $validate = \think\Loader::validate('Ad');
        if(!$validate->check($data)){
            return ['code'=>1001,'msg'=>'参数错误：'.$validate->getError() ];
        }
        if(!empty($data['id'])){
            $data['update_time'] = time();
            $where=[];
            $where['id'] = ['eq',$data['id']];
            $res = $this->allowField(true)->where($where)->update($data);
        }else{
            $data['create_time'] = time();
            $res = $this->allowField(true)->insert($data);
        }

        if(false === $res){
            return ['code'=>1002,'msg'=>'保存失败：'.$this->getError() ];
        }
        return ['code'=>1,'msg'=>'保存成功'];
    }


    
    public function delData($where)
    {
        $res = $this->where($where)->delete();
        if($res===false){
            return ['code'=>1001,'msg'=>'删除失败：'.$this->getError() ];
        }
        return ['code'=>1,'msg'=>'删除成功'];
    }

    public function fieldData($where,$col,$val)
    {
        if(!isset($col) || !isset($val)){
            return ['code'=>1001,'msg'=>'参数错误'];
        }

        $data = [];
        $data[$col] = $val;

        $res = $this->allowField(true)->where($where)->update($data);

        if($res===false){
            return ['code'=>1002,'msg'=>'设置失败：'.$this->getError() ];
        }

        return ['code'=>1,'msg'=>'设置成功'];
    }


}





?>