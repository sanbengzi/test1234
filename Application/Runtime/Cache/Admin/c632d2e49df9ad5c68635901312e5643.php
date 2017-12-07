<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>分类管理</title>

        <link href="/Public/Admin/css/mine.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：分类管理-》分类列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="<?php echo U('categoryAdd');?>">【添加分类】</a>
                </span>
            </span>
        </div>
        <div></div>
      
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>序号</td>
                        <td>分类名称</td>
                      
                        <td align="center" colspan="2">操作</td>
                    </tr>
                    <?php if(is_array($data)): foreach($data as $key=>$da): ?><tr id="product1">
                        <td><?php echo ($da["id"]); ?></td>
                        <td><?php echo ($da["category_name"]); ?></td>
                        <td><a href="#">修改</a></td>
                        <td><a href="#" onclick="del(1})" >删除</a></td>
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


   </script>
</html>