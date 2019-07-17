/**
* {$comment}
* @access public
*/
public function {$name}()
{
    $ids   = $this->request->isPost() ? input('post.ids/a') : input('param.ids');
    $ids   = (array)$ids;
    if(!$ids) $this->error('失败');

    $table = $this->tables;
    $table = array_shift($table);

    if(Db::name('{$table['table']}')->where(['{$table['pk']}' => $ids])->delete()){

        return $this->result([],200,'获取成功','json');

    }

    return $this->result([],1,'删除失败','json');

}