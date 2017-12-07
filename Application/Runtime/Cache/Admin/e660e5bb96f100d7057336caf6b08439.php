<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>属性列表</title>

        <link href="/Public/Admin//css/mine.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：商品管理-》属性列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="<?php echo U('attrAdd');?>">【添加属性】</a>
                </span>
            </span>
        </div>
        <div></div>
      
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>序号</td>
                        <td>属性名称</td>
                        <td>所属类型</td>
                        <td>属性值的类型</td>
                        <td>属性值录入方式</td>
                        <td>可选值列表</td>
                      
                        <td align="center" colspan="2">操作</td>
                    </tr>

                   <?php if(is_array($attrData)): foreach($attrData as $key=>$d): ?><tr id="product1">
                        <td><?php echo ($d["id"]); ?></td>
                        <td><?php echo ($d["attr_name"]); ?></td>
                        <td><?php echo ($d["cate_name"]); ?></td>
                        <td><?php echo (get_type($d["attr_type"])); ?></td>
                        <td><?php echo (get_write($d["attr_type"])); ?></td>
                        <td><?php echo ($d["attr_value"]); ?></td>
                        
                        <td><a href="<?php echo U('attrUpdate','id='.$d['id']);?>">修改</a></td>
                        <td><a href="javascript:void(0);" class="attrDel" data_id="<?php echo ($d["id"]); ?>" >删除</a></td>
                    </tr><?php endforeach; endif; ?>
                  
                  
                    <tr>
                        <td colspan="20" style="text-align: center;">
                            [1]
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
    <script type="text/javascript">
        $(function () {
            $('.attrDel').click(function () {
                //获取id
                _this = $(this);
                id = _this.attr('data_id');
                if (confirm('确定删除？？')) {
                    $.post('/index.php/Admin/Attribute/attrDel',{id:id},function (data) {
                        if (data.status == 1) {
                            alert(data.info);
                            _this.parents('tr').remove();
                        } else {
                            alert(data.info);
                        }
                    },'json');
                }

            });
        });
    </script>
   
</html>