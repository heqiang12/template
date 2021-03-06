<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx19dffa4b721a3921", "309880e317999b4f15209f6c28f46ede");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  <h3></h3>
  <h1 onclick="sample()">分享朋友</h1>
  <h1 onclick="sample2()">分享朋友圈</h1>
</body>
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */

   function sample() {
   	alert(123);
   	var link = location.href.toString();
   	alert(link);
   	wx.config({
	    debug: true,
	    appId: '<?php echo $signPackage["appId"];?>',
	    timestamp: '<?php echo $signPackage["timestamp"];?>',
	    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
	    signature: '<?php echo $signPackage["signature"];?>',
	    jsApiList: [
	      // 所有要调用的 API 都要加到这个列表中
	      'updateAppMessageShareData','onMenuShareAppMessage'
	    ]
	  });
	  wx.ready(function () {
	    // 在这里调用 API
	    // wx.updateAppMessageShareData({ 
	    //     title: '开开开心', // 分享标题
	    //     desc: '哈哈哈哈，就是开心！！！', // 分享描述
	    //     // link: 'http://8.9.6.220/template/php/simple.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	    //     link: link,
	    //     imgUrl: '', // 分享图标
	    //     success: function () {
	    //       alert('updateAppMessageShareData success ');
	    //       // 设置成功
	    //     }
	    // });


	    wx.onMenuShareAppMessage({
			title: '测试', // 分享标题
			desc: '测试', // 分享描述
			link: 'http://8.9.6.220/template/php/simple.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: '', // 分享图标
			type: '', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () {
			// 用户点击了分享后执行的回调函数
			alert('onMenuShareAppMessage success');
			}
		});
	  });
	     }


	     function sample2() {
   	alert('圈');
   	var link = location.href.toString();
   	alert(link);
   	wx.config({
	    debug: true,
	    appId: '<?php echo $signPackage["appId"];?>',
	    timestamp: '<?php echo $signPackage["timestamp"];?>',
	    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
	    signature: '<?php echo $signPackage["signature"];?>',
	    jsApiList: [
	      // 所有要调用的 API 都要加到这个列表中
	      'updateTimelineShareData','onMenuShareTimeline'
	    ]
	  });
	  wx.ready(function () {
	    

      wx.updateTimelineShareData({ 
        title: '朋友圈测试', // 分享标题
        link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: '', // 分享图标
        success: function () {
          alert('朋友圈设置 success ');
        }
  });
	  });
	     }

      
</script>
</html>
