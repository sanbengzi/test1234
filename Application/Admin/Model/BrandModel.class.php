<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/5/31
 * Time: 17:52
 */
namespace Admin\Model;

use Think\Model;

class BrandModel extends Model
{
    protected $_validate = array(
        array('brand_name','require','商品名不能为空！！'),
    );
}
