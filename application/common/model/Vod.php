<?php
namespace app\common\model;
use think\Db;
use think\Cache;
use app\common\util\Pinyin;

class Vod extends Base {
    // 设置数据表（不含前缀）
    protected $name = 'vod';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';

    // 自动完成
    protected $auto       = [];
    protected $insert     = [];
    protected $update     = [];

    public function countData($where)
    {
        $total = $this->where($where)->count();
        return $total;
    }

    public function listData($where,$order,$page=1,$limit=20,$start=0,$field='*',$addition=1,$totalshow=1, \Closure $query = null)
    {
        if(!is_array($where)){
            $where = json_decode($where,true);
        }
        $where2='';
        if(!empty($where['_string'])){
            $where2 = $where['_string'];
            unset($where['_string']);
        }

        $limit_str = ($limit * ($page-1) + $start) .",".$limit;
        if($totalshow==1) {
            $total = $this->where($where)->count();
        }

        $list = Db::name('Vod');
        if ($order instanceof \Closure){
            call_user_func($order, $list);
        }
        if ($page instanceof \Closure){
            call_user_func($page, $list);
        }
        if ($limit instanceof \Closure){
            call_user_func($limit, $list);
        }
        if ($start instanceof \Closure){
            call_user_func($start, $list);
        }
        if ($field instanceof \Closure){
            call_user_func($field, $list);
        }
        if ($addition instanceof \Closure){
            call_user_func($addition, $list);
        }
        if ($totalshow instanceof \Closure){
            call_user_func($totalshow, $list);
        }
        if ($query){
            call_user_func($query, $list);
        }
        //$list = $list->field($field)->where($where)->where($where2)->order($order)->limit($limit_str)->select();
		if(stripos($order,'vod_store_num')!==false){
            $field .= ',vod_store_num';
            $sql = $list->field($field)->join('mac_ulog',' vod_id = mac_ulog.ulog_rid')->where($where)->where($where2)->order($order)->limit($limit_str)->fetchSql(true)->select();
            $sql1="left join (select sum(1) vod_store_num,ulog_rid from mac_ulog where ulog_type = 2 and ulog_mid = 1 and ulog_points=0 group by ulog_rid) as mac_ulog";
            $str=preg_replace("/INNER JOIN `mac_ulog`/",$sql1,$sql);
            $list=$list->query($str);
        }else{
            $list = $list->field($field)->where($where)->where($where2)->order($order)->limit($limit_str)->select();
        }
        //分类
        $type_list = model('Type')->getCache('type_list');
        //用户组
        $group_list = model('Group')->getCache('group_list');
        $pichost = $this->thost();
        foreach($list as $k=>$v){
            if($addition==1){
	            if(!empty($v['type_id'])) {
	                $list[$k]['type'] = $type_list[$v['type_id']];
	                $list[$k]['type_name'] = $type_list[$v['type_id']]['type_name'];
                    $list[$k]['type_1'] = $type_list[$list[$k]['type']['type_pid']];
	            }
	            if(!empty($v['group_id'])) {
	                $list[$k]['group'] = $group_list[$v['group_id']];
	            }
	            if(empty($v['vod_custom_tag'])) {
	                $list[$k]['vod_custom_tag'] = $v['vod_remarks'];
	            }	            
            }
			if(strpos($list[$k]['vod_pic'], 'http') ===0){}else{
				$list[$k]['vod_pic'] = $pichost . $list[$k]['vod_pic'] ;
			}
        }
        return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$list];
    }
    //apicloud 
    public function listDatae($where,$order,$page=1,$limit=20,$start=0,$field='*',$addition=1,$totalshow=1, \Closure $query = null)
    {
        if(!is_array($where)){
            $where = json_decode($where,true);
        }
        $where2='';
        if(!empty($where['_string'])){
            $where2 = $where['_string'];
            unset($where['_string']);
        }

        $limit_str = ($limit * ($page-1) + $start) .",".$limit;
        if($totalshow==1) {
            $total = $this->where($where)->count();
        }

        $list = Db::name('Vod');
        if ($order instanceof \Closure){
            call_user_func($order, $list);
        }
        if ($page instanceof \Closure){
            call_user_func($page, $list);
        }
        if ($limit instanceof \Closure){
            call_user_func($limit, $list);
        }
        if ($start instanceof \Closure){
            call_user_func($start, $list);
        }
        if ($field instanceof \Closure){
            call_user_func($field, $list);
        }
        if ($addition instanceof \Closure){
            call_user_func($addition, $list);
        }
        if ($totalshow instanceof \Closure){
            call_user_func($totalshow, $list);
        }
        if ($query){
            call_user_func($query, $list);
        }
        //$list = $list->field($field)->where($where)->where($where2)->order($order)->limit($limit_str)->select();
		if(stripos($order,'vod_store_num')!==false){
            $field .= ',vod_store_num';
            $sql = $list->field($field)->join('mac_ulog',' vod_id = mac_ulog.ulog_rid')->where($where)->where($where2)->order($order)->limit($limit_str)->fetchSql(true)->select();
            $sql1="left join (select sum(1) vod_store_num,ulog_rid from mac_ulog where ulog_type = 2 and ulog_mid = 1 and ulog_points=0 group by ulog_rid) as mac_ulog";
            $str=preg_replace("/INNER JOIN `mac_ulog`/",$sql1,$sql);
            $list=$list->query($str);
        }else{
            $list = $list->field($field)->where($where)->where($where2)->order($order)->limit($limit_str)->select();
        }
        //分类
        $type_list = model('Type')->getCache('type_list');
        //用户组
        $group_list = model('Group')->getCache('group_list');

        foreach($list as $k=>$v){
            if($addition==1){
	            if(!empty($v['type_id'])) {
	                $list[$k]['type'] = $type_list[$v['type_id']];
	                $list[$k]['type_name'] = $type_list[$v['type_id']]['type_name'];
                    $list[$k]['type_1'] = $type_list[$list[$k]['type']['type_pid']];
	            }
	            if(!empty($v['group_id'])) {
	                $list[$k]['group'] = $group_list[$v['group_id']];
	            }
				$tlist[$k]['vod_id'] = $list[$k]['vod_id'];
				$tlist[$k]['type_id'] = $list[$k]['type_id'];
				$tlist[$k]['vod_remarks'] = $list[$k]['vod_remarks'];
				$tlist[$k]['vod_name'] = $list[$k]['vod_name'];
				$tlist[$k]['vod_pic'] = $list[$k]['vod_pic'];
            }
        }
        return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$tlist];
    }
    public function listRepeatData($where,$order,$page=1,$limit=20,$start=0,$field='*',$addition=1)
    {
        if(!is_array($where)){
            $where = json_decode($where,true);
        }
        $limit_str = ($limit * ($page-1) + $start) .",".$limit;

        $total = $this
            ->join('tmpvod t','t.name1 = vod_name')
            ->where($where)
            ->count();

        $list = Db::name('Vod')
            ->join('tmpvod t','t.name1 = vod_name and t.tid1=type_id and t.year1=vod_year and t.area1 = vod_area')
            ->field($field)
            ->where($where)
            ->order($order)
            ->limit($limit_str)
            ->select();

        //分类
        $type_list = model('Type')->getCache('type_list');
        //用户组
        $group_list = model('Group')->getCache('group_list');

        foreach($list as $k=>$v){
            if($addition==1){
                if(!empty($v['type_id'])) {
                    $list[$k]['type'] = $type_list[$v['type_id']];
                    $list[$k]['type_1'] = $type_list[$list[$k]['type']['type_pid']];
                }
                if(!empty($v['group_id'])) {
                    $list[$k]['group'] = $group_list[$v['group_id']];
                }
            }
        }
        return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$list];
    }

    public function listCacheData($lp,\Closure $query = null)
    {
        if(!is_array($lp)){
            $lp = json_decode($lp,true);
        }

        $order = $lp['order'];
        $by = $lp['by'];
        $type = $lp['type'];
        $ids = $lp['ids'];
        $rel = $lp['rel'];
        $paging = $lp['paging'];
        $pageurl = $lp['pageurl'];
        $level = $lp['level'];
        $area = $lp['area'];
        $lang = $lp['lang'];
        $state = $lp['state'];
        $wd = $lp['wd'];
        $tag = $lp['tag'];
        $class = $lp['class'];
        $letter = $lp['letter'];
        $actor = $lp['actor'];
        $director = $lp['director'];
        $version = $lp['version'];
        $year = intval($lp['year']);
        $start = intval(abs($lp['start']));
        $num = intval(abs($lp['num']));
        $half = intval(abs($lp['half']));
        $weekday = $lp['weekday'];
        $tv = $lp['tv'];
        $timeadd = $lp['timeadd'];
        $timehits = $lp['timehits'];
        $time = $lp['time'];
        $hitsmonth = $lp['hitsmonth'];
        $hitsweek = $lp['hitsweek'];
        $hitsday = $lp['hitsday'];
        $hits = $lp['hits'];
        $not = $lp['not'];
        $cachetime = $lp['cachetime'];
        $isend = $lp['isend'];

        $page = 1;
        $where=[];
        $totalshow = 0;

        if(empty($num)){
            $num = 20;
        }
        if($start>1){
            $start--;
        }

        if(!in_array($paging, ['yes', 'no'])) {
            $paging = 'no';
        }

        $param = mac_param_url();

        if($paging=='yes') {
            $totalshow = 1;
            if(!empty($param['id'])){
                //$type = intval($param['id']);
            }
            if(!empty($param['level'])){
                $level = $param['level'];
            }
            if(!empty($param['ids'])){
                $ids = $param['ids'];
            }
            if(!empty($param['tid'])) {
                $tid = intval($param['tid']);
            }
            if(!empty($param['year'])){
                if(strlen($param['year'])==4){
                    $year = intval($param['year']);
                }
                elseif(strlen($param['year'])==9){
                    $s=substr($param['year'],0,4);
                    $e=substr($param['year'],5,4);
                    $s1 = intval($s);$s2 = intval($e);
                    if($s1>$s2){
                        $s1 = intval($e);$s2 = intval($s);
                    }

                    $tmp=[];
                    for($i=$s1;$i<=$s2;$i++){
                        $tmp[] = $i;
                    }
                    $year = join(',',$tmp);
                }
            }
            if(!empty($param['area'])){
                $area = $param['area'];
            }
            if(!empty($param['lang'])){
                $lang = $param['lang'];
            }
            if(!empty($param['tag'])){
                $tag = $param['tag'];
            }
            if(!empty($param['class'])){
                $class = $param['class'];
            }
            if(!empty($param['state'])){
                $state = $param['state'];
            }
            if(!empty($param['letter'])){
                $letter = $param['letter'];
            }
            if(!empty($param['version'])){
                $version = $param['version'];
            }
            if(!empty($param['actor'])){
                $actor = $param['actor'];
            }
            if(!empty($param['director'])){
                $director = $param['director'];
            }
            if(!empty($param['wd'])){
                $wd = $param['wd'];
            }
            if(!empty($param['by'])){
                $by = $param['by'];
            }
            if(!empty($param['order'])){
                $order = $param['order'];
            }
            if(!empty($param['page'])){
                $page = intval($param['page']);
            }

            foreach($param as $k=>$v){
                if(empty($v)){
                    unset($param[$k]);
                }
            }
            if(empty($pageurl)){
                $pageurl = 'vod/type';
            }
            $param['page'] = 'PAGELINK';

            if($pageurl=='vod/type' || $pageurl=='vod/show'){
                $type = intval( $GLOBALS['type_id'] );
                $type_list = model('Type')->getCache('type_list');
                $type_info = $type_list[$type];
                $flag='type';
                if($pageurl == 'vod/show'){
                    $flag='show';
                }
                $pageurl = mac_url_type($type_info,$param,$flag);
            }
            else{
                $pageurl = mac_url($pageurl,$param);
            }
        }

        $where['vod_status'] = ['eq',1];
        if(!empty($ids)) {
            if($ids!='all'){
                $where['vod_id'] = ['in',explode(',',$ids)];
            }
        }
        if(!empty($not)){
            $where['vod_id'] = ['not in',explode(',',$not)];
        }
        if(!empty($rel)){
            $tmp = explode(',',$rel);
            if(is_numeric($rel) || mac_array_check_num($tmp)==true  ){
                $where['vod_id'] = ['in',$tmp];
            }
            else{
                $where['vod_rel_vod'] = ['like', mac_like_arr($rel),'OR'];
            }
        }
        if(!empty($level)) {
            if($level=='all'){
                $level = '1,2,3,4,5,6,7,8,9';
            }
            $where['vod_level'] = ['in',explode(',',$level)];
        }
        if(!empty($year)) {
            $where['vod_year'] = ['in',explode(',',$year)];
        }
        if(!empty($area)) {
            $where['vod_area'] = ['in',explode(',',$area)];
        }
        if(!empty($lang)) {
            $where['vod_lang'] = ['in',explode(',',$lang)];
        }
        if(!empty($state)) {
            $where['vod_state'] = ['in',explode(',',$state)];
        }
        if(!empty($version)) {
            $where['vod_version'] = ['in',explode(',',$version)];
        }
        if(!empty($weekday)){
            $where['vod_weekday'] = ['in',explode(',',$weekday)];
        }
        if(!empty($tv)){
            $where['vod_tv'] = ['in',explode(',',$tv)];
        }
        if(!empty($timeadd)){
            $s = intval(strtotime($timeadd));
            $where['vod_time_add'] =['gt',$s];
        }
        if(!empty($timehits)){
            $s = intval(strtotime($timehits));
            $where['vod_time_hits'] =['gt',$s];
        }
        if(!empty($time)){
            $s = intval(strtotime($time));
            $where['vod_time'] =['gt',$s];
        }
        if(!empty($letter)){
            if(substr($letter,0,1)=='0' && substr($letter,2,1)=='9'){
                $letter='0,1,2,3,4,5,6,7,8,9';
            }
            $where['vod_letter'] = ['in',explode(',',$letter)];
        }
        if(!empty($type)) {
            if($type=='current'){
                $type = intval( $GLOBALS['type_id'] );
            }
            if($type!='all') {
                $tmp_arr = explode(',',$type);
                $type_list = model('Type')->getCache('type_list');
                $type = [];
                foreach($type_list as $k2=>$v2){
                    if(in_array($v2['type_id'].'',$tmp_arr) || in_array($v2['type_pid'].'',$tmp_arr)){
                        $type[]=$v2['type_id'];
                    }
                }
                $type = array_unique($type);
                $where['type_id'] = ['in', implode(',',$type) ];
            }
        }
        if(!empty($tid)) {
            $where['type_id|type_id_1'] = ['eq',$tid];
        }
        if(!in_array($GLOBALS['aid'],[13,14,15]) && !empty($param['id'])){
            //$where['vod_id'] = ['not in',$param['id']];
        }

        if(!empty($hitsmonth)){
            $tmp = explode(' ',$hitsmonth);
            if(count($tmp)==1){
                $where['vod_hits_month'] = ['gt', $tmp];
            }
            else{
                $where['vod_hits_month'] = [$tmp[0],$tmp[1]];
            }
        }
        if(!empty($hitsweek)){
            $tmp = explode(' ',$hitsweek);
            if(count($tmp)==1){
                $where['vod_hits_week'] = ['gt', $tmp];
            }
            else{
                $where['vod_hits_week'] = [$tmp[0],$tmp[1]];
            }
        }
        if(!empty($hitsday)){
            $tmp = explode(' ',$hitsday);
            if(count($tmp)==1){
                $where['vod_hits_day'] = ['gt', $tmp];
            }
            else{
                $where['vod_hits_day'] = [$tmp[0],$tmp[1]];
            }
        }
        if(!empty($hits)){
            $tmp = explode(' ',$hits);
            if(count($tmp)==1){
                $where['vod_hits'] = ['gt', $tmp];
            }
            else{
                $where['vod_hits'] = [$tmp[0],$tmp[1]];
            }
        }

        if(in_array($isend,['0','1'])){
            $where['vod_isend'] = $isend;
        }

        if(!empty($wd)) {
            $role = 'vod_name';
            if(!empty($GLOBALS['config']['app']['search_vod_rule'])){
                $role .= '|'.$GLOBALS['config']['app']['search_vod_rule'];
            }
            $where[$role] = ['like', '%' . $wd . '%'];
        }
        if(!empty($tag)) {
            $where['vod_tag'] = ['like',mac_like_arr($tag),'OR'];
        }
        if(!empty($class)) {
            $where['vod_class'] = ['like',mac_like_arr($class), 'OR'];
        }
        if(!empty($actor)) {
            $where['vod_actor'] = ['like', mac_like_arr($actor), 'OR'];
        }
        if(!empty($director)) {
            $where['vod_director'] = ['like',mac_like_arr($director),'OR'];
        }
        if(defined('ENTRANCE') && ENTRANCE == 'index' && $GLOBALS['config']['app']['popedom_filter'] ==1){
            $type_ids = mac_get_popedom_filter($GLOBALS['user']['group']['group_type']);
            if(!empty($type_ids)){
                if(!empty($where['type_id'])){
                    $where['type_id'] = [ $where['type_id'],['not in', explode(',',$type_ids)] ];
                }
                else{
                    $where['type_id'] = ['not in', explode(',',$type_ids)];
                }
            }
        }

        if($by=='rnd'){
            $data_count = mac_data_count(0,'all','vod');
            $data_min = mac_data_count(0,'min','vod');
            $maxi = $data_count-$lp['num'];
            if($maxi<0){ $maxi=0; }
            $randi = @mt_rand($data_min, $data_min + $maxi);
            if($randi<0) { $randi=0; }
            $where['vod_id'] = ['gt',$randi];
            $by='time';
            $order='asc';
        }
        if(!in_array($by, ['id', 'time','time_add','score','hits','hits_day','hits_week','hits_month','up','down','level','rnd'])) {
            $by = 'time';
        }
        if(!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }
        $order= 'vod_'.$by .' ' . $order.',vod_id desc';
        $where_cache = $where;
        if(!empty($randi)){
            unset($where_cache['vod_id']);
            $where_cache['order'] = 'rnd';
        }

        $cach_name = $GLOBALS['config']['app']['cache_flag']. '_' .md5('vod_listcache_'.http_build_query($where_cache).'_'.$order.'_'.$page.'_'.$num.'_'.$start.'_'.$pageurl);
        $res = Cache::get($cach_name);
        if($GLOBALS['config']['app']['cache_core']==0 || empty($res)) {
            $res = $this->listData($where, $order, $page, $num, $start,'*',1, $totalshow, $query);
            $cache_time = $GLOBALS['config']['app']['cache_time'];
            if(intval($cachetime)>0){
                $cache_time = $cachetime;
            }
            if($GLOBALS['config']['app']['cache_core']==1) {
                Cache::set($cach_name, $res, $cache_time);
            }
        }
        $res['pageurl'] = $pageurl;
        $res['half'] = $half;

        return $res;
    }

    public function infoData($where,$field='*',$cache=0)
    {
        if(empty($where) || !is_array($where)){
            return ['code'=>1001,'msg'=>'参数错误'];
        }

        $key = 'vod_detail_'.$where['vod_id'][1].'_'.$where['vod_en'][1];

        $info = Cache::get($key);


        if($GLOBALS['config']['app']['cache_core']==0 || $cache==0 || empty($info['vod_id'])) {
            $info = $this->field($field)->where($where)->find();

            if (empty($info)) {
                return ['code' => 1002, 'msg' => '获取数据失败'];
            }
            $info = $info->toArray();

            if (!empty($info['vod_play_from'])) {
                $info['vod_play_list'] = mac_play_list($info['vod_play_from'], $info['vod_play_url'], $info['vod_play_server'], $info['vod_play_note'], 'play');
            }
            if (!empty($info['vod_down_from'])) {
                $info['vod_down_list'] = mac_play_list($info['vod_down_from'], $info['vod_down_url'], $info['vod_down_server'], $info['vod_down_note'], 'down');
            }

            //分类
            if (!empty($info['type_id'])) {
                $type_list = model('Type')->getCache('type_list');
                $info['type'] = $type_list[$info['type_id']];
                $info['type_1'] = $type_list[$info['type']['type_pid']];
            }
            //用户组
            if (!empty($info['group_id'])) {
                $group_list = model('Group')->getCache('group_list');
                $info['group'] = $group_list[$info['group_id']];
            }
            if($GLOBALS['config']['app']['cache_core']==1) {
                Cache::set($key, $info);
            }
        }
        return ['code'=>1,'msg'=>'获取成功','info'=>$info];
    }

    public function saveData($data)
    {
        $validate = \think\Loader::validate('Vod');
        if(!$validate->check($data)){
            return ['code'=>1001,'msg'=>'参数错误：'.$validate->getError() ];
        }
        $key = 'vod_detail_'.$data['vod_id'];
        Cache::rm($key);
        $key = 'vod_detail_'.$data['vod_en'];
        Cache::rm($key);
        $key = 'vod_detail_'.$data['vod_id'].'_'.$data['vod_en'];
        Cache::rm($key);

        $type_list = model('Type')->getCache('type_list');
        $type_info = $type_list[$data['type_id']];
        $data['type_id_1'] = $type_info['type_pid'];

        if(empty($data['vod_en'])){
            $data['vod_en'] = Pinyin::get($data['vod_name']);
        }

        if(empty($data['vod_letter'])){
            $data['vod_letter'] = strtoupper(substr($data['vod_en'],0,1));
        }

        if(empty($data['vod_blurb'])){
            $data['vod_blurb'] = mac_substring( strip_tags($data['vod_content']) ,100);
        }

        if(empty($data['vod_play_url'])){
            $data['vod_play_url'] = '';
        }
        if(empty($data['vod_down_url'])){
            $data['vod_down_url'] = '';
        }

        if(!empty($data['vod_play_from'])) {
            $data['vod_play_from'] = join('$$$', $data['vod_play_from']);
            $data['vod_play_server'] = join('$$$', $data['vod_play_server']);
            $data['vod_play_note'] = join('$$$', $data['vod_play_note']);
            $data['vod_play_url'] = join('$$$', $data['vod_play_url']);
            $data['vod_play_url'] = str_replace( array(chr(10),chr(13)), array('','#'),$data['vod_play_url']);
        }
        else{
            $data['vod_play_from'] = '';
            $data['vod_play_server'] = '';
            $data['vod_play_note'] = '';
            $data['vod_play_url'] = '';
        }

        if(!empty($data['vod_down_from'])) {
            $data['vod_down_from'] = join('$$$', $data['vod_down_from']);
            $data['vod_down_server'] = join('$$$', $data['vod_down_server']);
            $data['vod_down_note'] = join('$$$', $data['vod_down_note']);
            $data['vod_down_url'] = join('$$$', $data['vod_down_url']);
            $data['vod_down_url'] = str_replace(array(chr(10),chr(13)), array('','#'),$data['vod_down_url']);
        }else{
            $data['vod_down_from']='';
            $data['vod_down_server']='';
            $data['vod_down_note']='';
            $data['vod_down_url']='';
        }

        if($data['uptime']==1){
            $data['vod_time'] = time();
        }
        if($data['uptag']==1){
            $data['vod_tag'] = mac_get_tag($data['vod_name'], $data['vod_content']);
        }
        unset($data['uptime']);
        unset($data['uptag']);

        if(!empty($data['vod_id'])){
            $where=[];
            $where['vod_id'] = ['eq',$data['vod_id']];
            $res = $this->allowField(true)->where($where)->update($data);
        }
        else{
            $data['vod_time_add'] = time();
            $data['vod_time'] = time();
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
        $list = $this->where($where)->select();
        $path = './';
        foreach($list as $k=>$v){
            if(file_exists($path.$v['vod_pic'])){
                unlink($path.$v['vod_pic']);
            }
            if(file_exists($path.$v['vod_pic_thumb'])){
                unlink($path.$v['vod_pic_thumb']);
            }
            if(file_exists($path.$v['vod_pic_slide'])){
                unlink($path.$v['vod_pic_slide']);
            }
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
            return ['code'=>1001,'msg'=>'设置失败：'.$this->getError() ];
        }

        $list = $this->field('vod_id,vod_name,vod_en')->where($where)->select();
        foreach($list as $k=>$v){
            $key = 'vod_detail_'.$v['vod_id'];
            Cache::rm($key);
            $key = 'vod_detail_'.$v['vod_en'];
            Cache::rm($key);
        }

        return ['code'=>1,'msg'=>'设置成功'];
    }

    public function updateToday($flag='vod')
    {
        $today = strtotime(date('Y-m-d'));
        $where = [];
        $where['vod_time'] = ['gt',$today];
        if($flag=='type'){
            $ids = $this->where($where)->column('type_id');
        }
        else{
            $ids = $this->where($where)->column('vod_id');
        }
        if(empty($ids)){
            $ids = [];
        }else{
            $ids = array_unique($ids);
        }
        return ['code'=>1,'msg'=>'获取成功','data'=> join(',',$ids) ];
    }
    public function thost()
    {
		if ( (! empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') || (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (! empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) {

        $_SERVER['REQUEST_SCHEME'] = 'https';

        } else {

        $_SERVER['REQUEST_SCHEME'] = 'http';

        }
		$host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .'/';
		return $host;
	}
}