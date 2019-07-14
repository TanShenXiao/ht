/**
* {$comment}

* @access public
*/
public function {$name}()
{
    $is_remarks = input('is_remarks');
    //获取筛选
    $map = $this->getMap();
    $order = $this->getOrder();

    $data_list = {php}echo $data_list."\r\n\t\t\t->where(\$map)->order(\$order)".$data_last;{/php};

    if($is_remarks){
        $data_list['field_remarks'] = [
            //显示字段
            {foreach $field_remarks as $key => $item }

                {php}echo $item;{/php}
            {/foreach}

        ];
    }

    return $this->result($data_list,200,'获取成功','json');
}