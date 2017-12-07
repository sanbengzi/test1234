<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>角色列表</title>

        <link href="/Public/Admin//css/mine.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：角色管理-》角色列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="<?php echo U('roleAdd');?>">【添加角色】</a>
                </span>
            </span>
        </div>
        <div></div>
      
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>序号</td>
                        <td>角色名称</td>
                        <td>是否启用</td>
                      
                        <td style="text-align: center;" colspan="3">操作</td>
                    </tr>

                    <?php if(is_array($data)): foreach($data as $key=>$role_data): ?><tr id="product1">
                        <td><?php echo ($role_data["id"]); ?></td>
                        <td><a href="#"><?php echo ($role_data["role_name"]); ?></a></td>
                        <td><?php echo (getStatus($role_data["role_status"])); ?></td>
                        <td><a href="<?php echo U('system/accessList','id='.$role_data['id']);?>">权限管理</a></td>
                        <td><a href="<?php echo U('system/roleUpdate','id='.$role_data['id']);?>">修改</a></td>
                        <td><a href="javascript:void(0);" class="roleDel" data_id="<?php echo ($role_data["id"]); ?>" >删除</a></td>
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
//           alert(111);
           $('.roleDel').click(function () {
               _this = $(this);
               id = _this.attr('data_id');
//             alert(id);
               if (confirm('确定删除？')) {
                   $.post('/index.php/Admin/System/roleDel',{'id':id},function (data) {
                       console.log(data);
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