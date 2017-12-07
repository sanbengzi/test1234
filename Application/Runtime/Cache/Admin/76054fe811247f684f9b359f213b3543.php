<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>相册列表</title>

        <link href="/Public/Admin/css/mine.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：相册管理-》XX的相册列表</span>
              
            </span>
        </div>
        <div></div>
        
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <th>序号</th>
                        <th>大图</th>
                        <th>缩略图</th>
                        <th align="center">操作</th>
                    </tr>
                <?php if(is_array($datapic)): foreach($datapic as $key=>$data): ?><tr >
                        <td><?php echo ($data["id"]); ?></td>
                        <td><img src="/Public/Uploads/<?php echo ($data["pic_big"]); ?>" height="60" width="100"></td>
                        <td><img src="/Public/Uploads/<?php echo ($data["pic_small"]); ?>" height="60" width="100"></td>
                   
                        <td><a href="javascript:void(0);" class="pic_del" pic_id="<?php echo ($data["id"]); ?>">删除</a></td>
                    </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
         <form action="" method="post" enctype="multipart/form-data" >
         <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
             
                    <tr style="font-weight: bold;">
                        <td>选择图片</td>
                    </tr>
                  <tbody id="img_files">
                    <tr>
                        <td><a href="javascript:void(0);" id='add' style="font-weight: bold;">[+]</a><input type="file" name='image[]'/></td>
                    </tr>
                </tbody>

            </table>
             <input type="hidden" name="goods_id" value="<?php echo ($_GET['id']); ?>"/>
             <input type="submit" value="确认保存">
         </div>
         </form>
    </body>
<script type="text/javascript" >
    $(function () {
        //绑定id 添加点击事件 点击+添加
        $('#add').click(function () {
            //点击加好添加上传文件的
            var str = '<tr><td><a href="javascript:void(0);" class="img_del">[-]</a><input type="file" name="image[]"/></td></tr>';
            $('#img_files').append(str);
        });
        $('.img_del').live('click',function () {
            $(this).parents('tr').remove();

        });
        //绑定删除点击事件
        $('.pic_del').click(function () {
            //获取删除图片的id值
            _this = $(this);
            id = $(this).attr('pic_id');
            if (confirm('确认删除？')) {
                //传递要删除的id ajax异步 url json数据 回调函数 返回json数据
                $.post('/index.php/Admin/Goods/picDel',{'id':id},function(data){
                    //判断是否删除成功
                    if (data.status == 1) {
                        _this.parents('tr').remove();
                    }

                },'json');
            }
        });
    });
</script>
</html>