/**
* {$comment}
* @access public
*/
public function {$name}($id = '')
{

     $data = {php}echo $data_list."\r\n\t\t\t->where(['".$master_table[0].".id' => \$id])->find()";{/php};

    {foreach $public_variable as $key => $item }

    //{$item['describe']}//
    ${php}echo $key.' = '.$item['data'];{/php};

    {/foreach}

    if($this->request->isPost()){
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
        $update_data = [];
            foreach ($change_data as $key => $item){
            $arr = explode('_',$key,2);
            if(!isset($arr[1])) continue;
            if(key_exists($arr[0],$tables)){

            $table = $tables[$arr[0]];
            if($table['pk'] == $arr[1]){
            $update_data[$table['table']]['where'] = [$table['pk'] => $item];
            }else{
            $update_data[$table['table']]['data'][$arr[1]] = $item;
            }
            $update_data[$table['table']]['alias']= $arr[0] ;

            }
        }
        //开启事务插入数据
        Db::startTrans();
        foreach ($update_data as $key => $item){
            if(empty($item) or empty($item['where'])) continue;

            if(!Db::name($key)->where($item['where'])->update($item['data'])){ //有的表可能没有更改会导致失败这个先注释掉
                //$this->error("表".$key."修改数据失败。");
            }
        }
        Db::commit();

        return $this->result([],200,'获取成功','json');
    }

    return $this->result($data,200,'修改成功','json');
}