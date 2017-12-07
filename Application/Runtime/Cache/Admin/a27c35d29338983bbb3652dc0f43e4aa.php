<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>增加商品属性</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/Admin//css/mine.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：商品管理-》添加属性</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="<?php echo U('attrList');?>">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>

        <div style="font-size: 13px;margin: 10px 5px">
            <form action="/index.php/Admin/Attribute/attrAdd.html" method="post" >
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td>属性名称</td>
                    <td><input type="text" name="attr_name" /></td>
                </tr>
                <tr>
                    <td>所属商品类型</td>
                    <td>
                        <select name="cate_id">

                            <option value="0">请选择</option>
                            <?php if(is_array($cateData)): foreach($cateData as $key=>$d): ?><option value="<?php echo ($d["id"]); ?>"><?php echo ($d["cate_name"]); ?></option><?php endforeach; endif; ?>
                           
                        </select>
                    </td>
                </tr>
                 <tr>
                    <td>属性值的类型</td>
                    <td><input type="radio" value="0" name="attr_type" id="attr_type1" />输入框<input type="radio" value="1" id="attr_type" name="attr_type" />复选框</td>
                </tr>
                 <!--<tr>-->
                    <!--<td>属性值录入方式</td>-->
                    <!--<td><input type="radio" value="0" name="attr_write" />手工录入<input type="radio" value="1" name="attr_write" />列表选择</td>-->
                <!--</tr>-->
                <tr id="tr_display" >
                 <!--<tr id="tr_display" >-->
                    <td>可选值列表</td>
                    <td><textarea name="attr_value" rows="10"></textarea></td>
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
//    $(function () {
////        alert(11);
//
//        $('#attr_type').click(function () {
//            if ($(this).is(':checked')) {
//                $('tr_display').show();
//            }
//        });
//        $('#attr_type1').click(function () {
//            if ($(this).is(':checked')) {
//                $('tr_display').hide();
//            }
//        });
//        if ($('#attr_type').is(':checked')) {
//            $('#tr_display').attr('display','block');
//        }
    });
</script>
</html>