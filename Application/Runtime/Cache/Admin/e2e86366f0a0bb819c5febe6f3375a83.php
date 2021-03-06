<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>添加商品</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/Admin/css/mine.css" type="text/css" rel="stylesheet">
        <link href="/Public/Admin/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
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
                    <a style="text-decoration: none" href="/Admin/Goods/goodsList">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>

        <div style="font-size: 13px;margin: 10px 5px">
            <form action="" method="post" enctype="multipart/form-data">
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td>商品名称</td>
                    <td><input type="text" name="goods_name" value="<?php echo ($goodsData["goods_name"]); ?>" /></td>
                </tr>
                <tr>
                    <td>商品类型</td>
                    <td>
                        <select name="cate_id" id="cate" cate_id="<?php echo ($goodsData["cate_id"]); ?>">
                            <option value="0">请选择</option>
                        <?php if(is_array($cateData)): foreach($cateData as $key=>$d): ?><option value="<?php echo ($d["id"]); ?>" <?php echo ($d['id'] ==$goodsData['cate_id'] ? selected:''); ?> ><?php echo ($d["cate_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>商品品牌</td>
                    <td>
                        <select name="brand_id" id="brand_id" brand_id="<?php echo ($goodsData["brand_id"]); ?>">
                            <option value="0">请选择</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>商品市场价格</td>
                    <td><input type="text" name="goods_mprice" value="<?php echo ($goodsData["goods_mprice"]); ?>" /></td>
                </tr>
                <tr>
                    <td>商品价格</td>
                    <td><input type="text" name="goods_price" value="<?php echo ($goodsData["goods_price"]); ?>" /></td>
                </tr>
                <tr>
                    <td>商品图片</td>
                    <td><input type="file" name="goods_image" /></td>
                </tr>
                 <tr>
                    <td>商品数量</td>
                    <td><input type="text" name="goods_count" value="<?php echo ($goodsData["goods_count"]); ?>" /></td>
                </tr>
                <tr>
                    <td>商品重量</td>
                    <td><input type="text" name="goods_weight" value="<?php echo ($goodsData["goods_weight"]); ?>" /></td>
                </tr>
                <tr>
                <tr>
                    <td>商品编号</td>
                    <td><input type="text" name="goods_number" value="<?php echo ($goodsData["goods_number"]); ?>" /></td>
                </tr>
                    <td>商品排序</td>
                    <td><input type="text" name="goods_sort" value="<?php echo ($goodsData["goods_sort"]); ?>" /></td>
                </tr>
                <tr>
                    <td>商品详细描述</td>
                    <td>
                        <script type="text/plain" name="goods_description"  id="myEditor" style="width:1000px;height:240px;"><?php echo ($goodsData["goods_description"]); ?></script>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" align="center">
                        <input type="hidden" value="<?php echo ($goodsData["id"]); ?>" id="goods_id"  name="id"/>
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
        //页面自动加载
        $(function () {
            id = $('#cate').val();                        //获取商品对应的商品类型id cate_id
            goods_id = $('#goods_id').val();              //获取商品的id
            brand_id = $('#brand_id').attr('brand_id');   //获取商品对应的品牌id brand_id
            str = '';                                     //保存cate属性 组合HTML
            brandstr = '';                                //保存brand下拉框 组合HTML
            /**
             * 页面自动加载，post传输数据goods_id cate 获取
             * 商品品牌表brand、商品类型属性表attribute、商品属性表goodsattr的数据
             * **/
            $.post('/Admin/Goods/getAttr',{id:id,goods_id:goods_id},function (data) {
                //放回data 是 brand、cate、goodsattr 组成的数据 组合
                /*
                * 循环遍历brand表返回的数据
                * */
                $.each(data.brandData,function (key,item) {
                    //判断如果item.id == brand_id的时候selected 默认选中
                    if (brand_id==item.id) {
                        brandstr += '<option class="newTag" selected value="'+item.id+'">'+item.brand_name+'</option>';
                    } else {
                        brandstr += '<option class="newTag" value="'+item.id+'">'+item.brand_name+'</option>';
                    }
                });
                //将brandstr 追加到brand select下面
                $('#brand_id').html(brandstr);
                /**
                * 循环遍历商品类型属性数据
                * */
                $.each(data.attrData,function (key,item) {
                    var options = '';              //保存复选框 option的HTML
                    /**
                     * 判断是复选框还是输入框 attr_type==0 是输入框
                     **/
                    if (item.attr_type == 0) {
                        //输入框
                        //循环遍历goods_id 对应的商品属性数据
                        $.each(data.goodsAttrData,function (i,n) {
                            //判断 如果商品类型属性id== 商品属性attr_id 添加默认值value
                            if (item.id == n.attr_id) {
                                str += '<tr class="newTag"><td>'+item.attr_name+'</td><td><input type="text" name="goods_attr['+n.id+']" value="'+n.goods_attr_val+'" /></td></tr>';
                            }
                        });
                    } else {
                        //复选框
                        tmp = item.attr_value.split(',');  //将复选框对应的值 拆分成数组
                        //循环遍历tmp
                        for (var i = 0; i < tmp.length; i++) {
                            /**
                             * 循环遍历goods_id 对应的商品属性数据
                             ***/
                            $.each(data.goodsAttrData,function (j,n) {
                                //判断 如果如果商品类型属性id== 商品属性attr_id 添加默认选中 checked
                                goodstmp = n.goods_attr_val.split(',');  //商品属性值拆分成数组
                                if (item.id == n.attr_id) {
                                    //判断商品类属性值查分tmp循环出来的值 是否在商品属性表的属性值拆分数组goodstmp中
                                    if (!($.inArray(tmp[i],goodstmp) == -1)) {
                                        options += '<input type="checkbox" checked="checked" name="goods_attr['+item.id+'][]" value="'+tmp[i]+'">'+tmp[i];
                                    } else {
                                        options += '<input type="checkbox"  name="goods_attr['+item.id+'][]" value="'+tmp[i]+'">'+tmp[i];
                                    }
                                }
                            });
                        }
                        //讲options拼接到str中
                        str += '<tr class="newTag"><td>'+item.attr_name+'</td><td>'+options+'</td></tr>';
                    }
                });
                //讲str 追加到brand下拉框后面
                $('#brand_id').parents('tr').after(str);
            },'json');
            /**
             * 添加change事件
             * **/
            $('#cate').change(
                function () {
                    _this = $(this);
                    id = $(this).val();            //获取当前商品类型的id  cate
                    $('.newTag').remove();         //删除之前追加到HTML中的数据
                    str = '';                      //存储添加到HTML中的 商品属性的HTML
                    brandstr = '';                 //存储添加到HTML中的 brand下拉列表
                    /**
                     * 将id goods_id 传递到PHP中处理数据，返回的是表brand 和attribute的数据
                     * **/
                    $.post('/Admin/Goods/getAttr',{id:id,goods_id:goods_id},function (data) {
                        if (data.status == 0) {
                            alert(data.info);
                        }
                        /**
                         * 循环遍历cate_id对应的品牌数据
                         * **/
                        $.each(data.brandData,function (key,item) {
                            brandstr += '<option class="newTag" value="'+item.id+'">'+item.brand_name+'</option>';
                        });
                        //将brandstr追加到brand  select下拉菜单中
                        $('#brand_id').html(brandstr);
                        /**
                         * 循环遍历cate_id对应的 attribute表数据
                         * **/
                        $.each(data.attrData,function (key,item) {
                            var options = '';
                            //判断要输出的表的类型 type=0 输入框，1 复选框
                            if (item.attr_type == 0) {
                                str += '<tr class="newTag"><td>'+item.attr_name+'</td><td><input type="text" name="goods_attr['+item.id+']" value="" /></td></tr>';

                            } else {
                                tmp = item.attr_value.split(',');
                                for (var i = 0; i < tmp.length; i++) {
                                    options += '<input type="checkbox" name="goods_attr['+item.id+'][]" value="'+tmp[i]+'">'+tmp[i];
                                }
                                str += '<tr class="newTag"><td>'+item.attr_name+'</td><td>'+options+'</td></tr>';
                            }
                        })
                        //将str追加到HTML中
                        $('#brand_id').parents('tr').after(str);
                    },'json');
                }
            );
        });
    </script>
</html>