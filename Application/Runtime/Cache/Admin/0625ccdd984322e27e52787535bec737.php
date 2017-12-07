<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>添加商品</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/Admin/css/mine.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
        <link href="/Public/Admin/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="/Public/Admin/umeditor/third-party/jquery.min.js"></script>
        <script type="text/javascript" src="/Public/Admin/umeditor/third-party/template.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="/Public/Admin/umeditor/umeditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="/Public/Admin/umeditor/umeditor.min.js"></script>
        <script type="text/javascript" src="/Public/Admin/umeditor/lang/zh-cn/zh-cn.js"></script>
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：商品管理-》添加商品信息</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="/index.php/Admin/Goods/goodsList">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>

        <div style="font-size: 13px;margin: 10px 5px">
            <form action="" method="post" enctype="multipart/form-data">
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td>商品名称</td>
                    <td><input type="text" name="goods_name" /></td>
                </tr>
                <tr>
                    <td>商品分类</td>
                    <td>
                        <select name="cate_id" id="cate">
                            <option value="0">请选择</option>
                           <?php if(is_array($cateData)): foreach($cateData as $key=>$d): ?><option value="<?php echo ($d["id"]); ?>" class="cate" ><?php echo ($d["cate_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>商品品牌</td>
                    <td>
                        <select name="brand_id" id="brand_id" >
                            <option value="0">请选择</option>
                           <!--<?php if(is_array($brandData)): foreach($brandData as $key=>$aa): ?>-->
                               <!--<option value="<?php echo ($aa["id"]); ?>"><?php echo ($aa["brand_name"]); ?></option>-->
                           <!--<?php endforeach; endif; ?>-->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>商品价格</td>
                    <td><input type="text" name="goods_price" /></td>
                </tr>
                <tr>
                    <td>商品图片</td>
                    <td><input type="file" name="goods_image" /></td>
                </tr>
                 <tr>
                    <td>商品数量</td>
                    <td><input type="text" name="goods_count" /></td>
                </tr>
                <tr>
                    <td>商品重量</td>
                    <td><input type="text" name="goods_weight" /></td>
                </tr>
                <tr>
                <tr>
                    <td>商品编号</td>
                    <td><input type="text" name="goods_number" /></td>
                </tr>
                    <td>商品排序</td>
                    <td><input type="text" name="goods_sort" /></td>
                </tr>
                <tr>
                    <td>商品详细描述</td>
                    <td >
                        <script type="text/plain" name="goods_description" id="myEditor" style="width:1000px;height:240px;"></script>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="添加">
                    </td>
                </tr>  
            </table>
            </form>
        </div>
    </body>
    <script type="text/javascript">
        //实例化编辑器
        var um = UM.getEditor('myEditor');
        $(function () {
            $('#cate').change(
                function () {
                    _this = $(this)
                    id = $(this).val();
//                    alert(id);
                    $('.newTag').remove();
                    str = '';
                    brandstr = '';
                    $.post('/index.php/Admin/Goods/goodsAttr',{id:id},function (data) {
                        if (data.status == 0) {
                            alert(data.info);
                        }
                        $.each(data.brandData,function (key,item) {
                            brandstr += '<option class="newTag" value="'+item.id+'">'+item.brand_name+'</option>';
                        });
                        $('#brand_id').html(brandstr);
                       $.each(data.cateData,function (key,item) {
                           var options = '';
                           if (item.attr_type == 0) {
                               str += '<tr class="newTag"><td>'+item.attr_name+'</td><td><input type="text" name="goods_attr['+item.id+']" value="" /></td></tr>';
                           } else {
                               tmp = item.attr_value.split(',');
                               for (var i = 0; i < tmp.length; i++) {
//                                   options += '<option value="'+tmp[i]+'">'+tmp[i]+'</option>';
                                   options += '<input type="checkbox" name="goods_attr['+item.id+'][]" value="'+tmp[i]+'">'+tmp[i];
                               }
//                               str += '<tr class="newTag"><td>'+item.attr_name+'</td><td><select name="goods_attr['+item.id+']" value="" >'+options+'</select><a href="javascript:void(0);" class="add_attr">[ + ]</a></td></tr>';

                               str += '<tr class="newTag"><td>'+item.attr_name+'</td><td>'+options+'</td></tr>';
                           }
                       })
                        $('#brand_id').parents('tr').after(str);
                    },'json');

                }
            );
        });
    </script>
</html>