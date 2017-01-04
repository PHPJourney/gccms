<!DOCTYPE HTML>
<html>
	<head>
		<title>You Can't do this 500</title>
		<style type="text/css">
			html,body { height:100%;overflow:hidden}
			body{margin:0;padding:0}
			.img{background:url("//coinfactory.co/Public/images/24Z58PICWHs_1024.jpg")center center no-repeat;width:100%;height:100%;position:absolute;z-index:1;left:0;top:0;border-style:none;}
			h1{position:absolute;z-index:0;left:0;top:0;}
		</style>
	</head>
	<body>
		<h1><?php echo strip_tags($e['message']);?></h1>
		<a href="/"><img class="img" usemap="#planetmap"></a>
	</body>
</html>
<script type="text/javascript">
console.info("<?php echo strip_tags($e['message']);?>");
<?php if(isset($e['file'])) {?>
console.info("File:<?php echo $e['file']?>");
console.info("LINE: <?php echo $e['line'];?>");
<?php }?>
<?php if(isset($e['trace'])) {?>
console.log("TRACE");
console.info("<?php echo nl2br($e['trace']);?>");
<?php }?>
</script>