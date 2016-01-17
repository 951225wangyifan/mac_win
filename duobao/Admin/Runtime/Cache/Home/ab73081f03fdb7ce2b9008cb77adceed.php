<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Insert title here</title>
	<link href="<?php echo (CSS_URL); ?>/admin_goods/css/calendar.css" rel="stylesheet">
			
	<link href="<?php echo (CSS_URL); ?>/admin_goods/css/default.css" rel="stylesheet">
	<link href="<?php echo (CSS_URL); ?>/admin_goods/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo (CSS_URL); ?>/editor/editor/themes/default/default.css" />
	<script charset="utf-8" src="<?php echo (CSS_URL); ?>/editor/editor/kindeditor-min.js"></script>
	<script charset="utf-8" src="<?php echo (CSS_URL); ?>/editor/editor/lang/zh_CN.js"></script>
	<script src="<?php echo (CSS_URL); ?>/editor/editor/kindeditor.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var editor = K.editor({
				allowFileManager : true
			});
			K('#image1').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#url1').val(),
						clickFn : function(url, title, width, height, border, align) {
							K('#url1').val(url);
							editor.hideDialog();
						}
					});
				});
			});
		});
	</script>
</head>
<body>
<script>
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="description"]', {
			allowFileManager : true
		});	
	});
</script>
<div class="main">
<div class="main_title">新增商品&nbsp&nbsp<a href="<?php echo u("Index/main");?>" class="back_list" >返回首页</a></div>
<div class="blank5"></div>
<form name="edit" action="<?php echo u("Goods/insert");?>" method="post" enctype="multipart/form-data">
<table class="form conf_tab" cellpadding=0 cellspacing=0 >
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title">商品名称:</td>
		<td class="item_input">
		<input type="text" class="textbox require" name="name" style="width:300px;height:20px;" /></td>
	</tr>
	<tr>
		<td class="item_title">期数:</td>
		<td class="item_input">
		<input type="text" class="textbox" name="periods" style="width:300px;height:20px;" /></td>
	</tr>
	<tr>
		<td class="item_title">总价:</td>
		<td class="item_input">
		<input type="text" class="textbox" name="total_price" style="width:300px;" /> <span class='tip_span'>单位（元）</span></td>
	</tr>
	<tr>
		<td class="item_title">商品图片:</td>
		<td class="item_input">
			<input type="text" id="url1" style="width:300px;" name = 'image' value="" /> <input type="button" id="image1" value="选择图片" />
			<span class='tip_span'>此图片作为顶部商品图片展示</span>
		</td>
	</tr>
	
	<tr>
		<td class="item_title">单价:</td>
		<td class="item_input"><input type="text" class="textbox" name="unit_price" style="width:300px;" /> <span class='tip_span'>每份价格</span></td>
	</tr>
	<tr>
		<td class="item_title">份数:</td>
		<td class="item_input"><input type="text" class="textbox" name="number" style="width:300px;" /> <span class='tip_span'>商品分为多少份购买</span></td>
	</tr>
	

	
	<tr>
		<td class="item_title">商品详情:</td>
		<td class="item_input">
			<textarea name="description" style="width:800px;height:400px;visibility:hidden;">此处填写商品图文详情！</textarea>
			<b class='tip_span'>图片像素要求： 800 * ?</b>
		</td>
	</tr>
</table>

<div class="blank5"></div>
	<table class="form" cellpadding=0 cellspacing=0>
		<tr>
			<td colspan=2 class="topTd"></td>
		</tr>
		<tr>
			<td class="item_title"></td>
			<td class="item_input">
			<input type="submit" class="button" value="添加" />
			<input type="reset" class="button" value="重置" />
			</td>
		</tr>
		<tr>
			<td colspan=2 class="bottomTd"></td>
		</tr>
	</table> 		 
</form>
</div>
</body>
</html>