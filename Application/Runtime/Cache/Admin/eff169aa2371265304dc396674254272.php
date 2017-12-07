<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>权限菜单列表</title>

        <link href="/Public/Admin/css/mine.css" type="text/css" rel="stylesheet" />
        <script src="/Public/Admin/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <style type="text/css">
            a {
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：系统管理-》菜单列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="<?php echo U('menuAdd');?>">【添加菜单】</a>
                </span>
            </span>
        </div>
        <div></div>
        
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>序号</td>
                        <td>菜单名称</td>
                         <td>控制器名</td>
                          <td>方法名称</td>
                      
                        <td>是否显示</td>
      
                        <td align="center" colspan="2">操作</td>
                    </tr>
        <?php if(is_array($data)): foreach($data as $key=>$d): ?><tr >
                        <td><?php echo ($d["id"]); ?></td>
                        <td><a href="#"><?php echo (str_repeat('&nbsp&nbsp',$d["level"])); echo ($d["menu_name"]); ?></a></td>
                        <td><?php echo ($d["menu_controller"]); ?></td>
                        <td><?php echo ($d["menu_action"]); ?></td>
                         <td><?php echo (getStatus($d["is_show"])); ?></td>

                        <td><a href="<?php echo U('menuUpdate','id='.$d['id']);?>">修改</a></td>
                        <td><a href="javascript:;" class="menu_del" data_id="<?php echo ($d["id"]); ?>"> 删除</a></td>
                    </tr><?php endforeach; endif; ?>  
                   
                   
                   
                </tbody>
            </table>
        </div>
    </body>
    <script type="text/javascript">
     $(function () {
         $('.menu_del').click(function () {
             _this = $(this);
             id = _this.attr('data_id');
//             alert(id);
             if (confirm('确定删除？')) {
                 $.post('/index.php/Admin/System/menuDel',{'id':id},function (data) {
                     if (data.status == 1) {
                        _this.parents('tr').remove();
                     } else {
                         alert('删除失败！不可删除上级菜单或已删除');
                     }
                 },'json');
             }
         });
     });
    </script>
</html>