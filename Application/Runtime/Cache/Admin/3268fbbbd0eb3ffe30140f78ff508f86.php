<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>会员列表</title>

        <link href="/Public/Admin/css/mine.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
            .num{
                width: 40px;
                height:20px;
            }
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：商品管理-》商品列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="<?php echo U('goodsAdd');?>">【添加商品】</a>
                </span>
            </span>
        </div>
        <div></div>
        
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <th>序号</th>
                        <th>商品名称</th>
                        <th>分类</th>
                        <th>品牌</th>
                        <th>库存</th>
                        <th>价格</th>
                        <th>缩略图</th>
                        <th>创建时间</th>
                        <th align="center" colspan="3">操作</th>
                    </tr>
                <?php if(is_array($goodsData)): foreach($goodsData as $key=>$dd): ?><tr id="product1">
                        <td><?php echo ($dd["id"]); ?></td>
                        <td><a href="<?php echo U('home/goods/goodsDetail/id/'.$dd['id']);?>" target="_blank"><?php echo ($dd["goods_name"]); ?></a></td>
                        <td><?php echo ($dd["cate_name"]); ?></td>
                        <td><?php echo ($dd["brand_name"]); ?></td>
                        <td><?php echo ($dd["goods_count"]); ?></td>
                        <td><?php echo ($dd["goods_price"]); ?></td>
                        <td><img src="/Public/Uploads/<?php echo ($dd["goods_smallpic"]); ?>" height="60" width="100"></td>
                        <td><?php echo ($dd["goods_addtime"]); ?></td>
                        <td><a href="/Admin/Goods/goodsUpdate/id/<?php echo ($dd["id"]); ?>">修改</a></td>
                        <td><a href="/Admin/Goods/goodsPic/id/<?php echo ($dd["id"]); ?>">图片管理</a></td>
                        <td><a class="goods_del" href="javascript:void(0)" data_del="<?php echo ($dd["id"]); ?>"><?php if($dd['goods_status'] == 1): ?>下架<?php else: ?>上架<?php endif; ?></a></td>
                    </tr><?php endforeach; endif; ?>
                    <tr>
                        <td colspan="20" style="text-align: center;">
                           <?php echo ($page); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
<script type="text/javascript" >
    $(function () {
        $('.goods_del').click(function () {
            _this = $(this);
            //获取id
            id = $(this).attr('data_del');
            //ajax 异步传入数据 用post方法 URL地址 data 数据 json格式 回调函数 返回数据格式json
            $.post('/Admin/Goods/goodsDel',{'id':id},function (data) {
                if (data.status == 1) {
                    _this.text(data.info);
                }
            }),'json';
        })
    })
</script>
</html>