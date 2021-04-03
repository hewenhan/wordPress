<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
 


var wxConfig = function (data) {
	var config = data;
	config.jsApiList = ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone', 'scanQRCode'];
	config.debug = true;
	wx.config(config);
};

var getJsApiSign = function () {
	var url = 'https://service.hewenhan.me/api/getJsSdkSign'
	$.ajax({
		type: "get",
		url: url,
		data: data,
		dataType: "jsonp",
		success: function (json) {
			wxConfig(json);
		},
		error: function (err) {
			console.log(err);
		}
	});
};

$(document).ready(function () {
	getJsApiSign();
});
</script>
<!-- end Simple Custom CSS and JS -->
