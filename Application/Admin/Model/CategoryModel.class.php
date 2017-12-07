<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/3
 * Time: 20:37
 */
namespace Admin\Model;

use Think\Model;

class CategoryModel extends Model
{
    /**
     * 储存递归分类返回的新的数组
     * @var array
     */
    public  $categoryTree = array();

    /**
     * 递归分类
     * @param $data  传入的数组
     * @param int $pid 父级id
     * @param int $level 分类等级
     * @return array 返回分类之后的数组
     */
    public function getTree($data, $pid = 0, $level = 0)
    {
        foreach ($data as $row) {
            //判断 父级id相等 将相应的数据存储到数组中
            if ($row['category_pid'] == $pid) {
                $row['level'] = $level;
                $this->categoryTree[] = $row;
                //继续判断 id 是否还是其他数据的父级id
                $this->getTree($data, $row['id'], $level+1);
            }
        }
        return $this->categoryTree;
    }
}