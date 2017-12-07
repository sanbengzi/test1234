<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>增加品牌</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/Admin/css/mine.css" type="text/css" rel="stylesheet">
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：品牌管理-》添加品牌信息</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="/index.php/Admin/Brand/brandList">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>

        <div style="font-size: 13px;margin: 10px 5px">
            <form action="<?php echo U('brandAdd');?>" method="post" >
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td>品牌名称</td>
                    <td><input type="text" name="brand_name" /></td>
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
                    <td>品牌排序</td>
                    <td><input type="text" name="brand_sort" /></td>
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
</html>