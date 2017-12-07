<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>权限列表</title>

        <link href="/Public/Admin//css/mine.css" type="text/css" rel="stylesheet" />
         <script src="/Public/Admin//js/jquery-1.7.2.min.js" type="text/javascript"></script>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：角色管理-》权限列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="<?php echo U('roleList');?>">【返回角色管理】</a>
                </span>
            </span>
        </div>
        <div></div>
      
        <div style="font-size: 13px; margin: 10px 5px;">
        <form action="" method="post" name='access'>
       
            <table id="menu_list" class="table_a" border="1" width="100%">
                <tbody>
                      <tr>
                        <td>当前角色：</td>
                         <td>
                           <?php echo ($roleData["role_name"]); ?>
                         </td>
                    </tr>
                  <?php if(is_array($menuData)): foreach($menuData as $key=>$d): ?><tr>
                        <input type="hidden" name="role_id" value="<?php echo ($roleData["id"]); ?>">
                        <td width="100"><input  class="checkpart"  type="checkbox" value="<?php echo ($d["id"]); ?>" name="menu_id[]" <?php if(in_array($d[id],$arr)): ?>checked<?php endif; ?> data_id="<?php echo ($d["id"]); ?>" /><?php echo ($d["menu_name"]); ?></td>
                         <td id="checkid_<?php echo ($d["id"]); ?>" >
                             <?php if(is_array($d['son'])): foreach($d['son'] as $key=>$dd): ?><div style="width:100px;float:left;"><input  type="checkbox"  data_id="<?php echo ($dd["id"]); ?>" name="menu_id[]" <?php if(in_array($dd[id],$arr)): ?>checked<?php endif; ?> value="<?php echo ($dd["id"]); ?>"/><?php echo ($dd["menu_name"]); ?></div><?php endforeach; endif; ?>
                         </td>
                    </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
            <table class="table_a" border="1" width="100%">
                <tbody>
                     <tr >
                        <td style="text-align: center;"><input id="checkall" type="checkbox" /> 全选|<input id="checkback" type="checkbox" />反选</td>
                        <td>&nbsp; <input type="submit" value="保存"/></td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>
        
    </body>
   
   <script type="text/javascript">
       $(function () {
           //全选
           $('#checkall').click(function () {
               if ($(this).is(':checked')) {
                   $('#menu_list :checkbox').each(function () {
                       if (!$(this).is(':checked')) {
                           $(this).attr('checked',true);
                       }
                       });
               } else {
                   $('#menu_list :checkbox').each(function () {
                       if ($(this).is(':checked')) {
                           $(this).attr('checked',false);
                       }
                   });
               }
           });
            //反选
           $('#checkback').click(function () {
               $('#menu_list :checkbox').each(function () {
                   if ($(this).is(':checked')) {
                       $(this).attr('checked',false);
                   } else {
                       $(this).attr('checked',true);
                   }
               });
           });
           //点击产品中心 对应的check全选
           $('.checkpart').click(function () {
               //点击 菜单 选择 对应下面的复选框 通过id获取 参数id
               //获取id
               id = $(this).attr('data_id');
               if ($(this).is(':checked')) {
                   $('#checkid_' + id + ' :checkbox').each(function () {
                       if (!$(this).is(':checked')) {
                           $(this).attr('checked', true);
                       }
                   });
               } else {
                   $('#checkid_' + id + ' :checkbox').each(function () {
                       if ($(this).is(':checked')) {
                           $(this).attr('checked', false);
                       }
                   });
               }
           });
       });
   </script>
</html>