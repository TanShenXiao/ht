/**
* {$comment}
* @access public
*/
public function {$name}()
{

    {foreach $public_variable as $key => $item }

    //{$item['describe']}//
    ${php}echo $key.' = '.$item['data'];{/php};

    {/foreach}

    $change_data = input();
    $validate = new Validate();
    $validate->rule([

    {foreach $rule as $key => $item }
        '{$key}' => '{$item}',
    {/foreach}

    ]);
    if(!$validate->check($change_data)){

        $this->error($validate->getError());

    }

    //数据分解
    $insert_data = [];
    foreach ($change_data as $key => $item){
        $arr = explode('_',$key,2);
        if(!isset($arr[1])) continue;
        if(key_exists($arr[0],$tables)){
            $table = $tables[$arr[0]];
            $insert_data[$table['table']]['data'][$arr[1]] = $item;
            $insert_data[$table['table']]['alias']= $arr[0];
        }
    }
    //开启事务插入数据
    Db::startTrans();
    $add_id = [];
    foreach ($insert_data as $key => $item){
        if(empty($item['data'])) continue;
        if(!Db::name($key)->insert($item['data'])){
            $this->error("表".$key."添加数失败。");
        }

        $last_id_name = $item['alias'].'_last_id';  //存储插入id
        $add_id[$last_id_name] = $$last_id_name =  Db::getLastInsID();
    }

    //更新字段之间的关系
    {foreach $relationship as $key => $item }

    if(isset({$item['variable'][0]}) and isset({$item['variable'][1]}) and !{php}echo $item['Db'];{/php}){
    $this->error("数据关系更新失败");
    }
    {/foreach}

    //字段关系结束
    Db::commit();

    return $this->result($add_id,1,'添加成功','json');
}