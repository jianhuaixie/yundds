<div id="content" class="footer mr-t20">

  <!--<div class="in">
    <div class="search_box">
      <form method="post" action="search.php" name="searchForm" id="searchForm_id">
        <input name="keywords" type="text" id="keywordfoot" />
        <button class="ico_07" type="submit" value="搜索" onclick="return check('keywordfoot')"> </button>
      </form>
    </div>
    <a href="./" class="homeBtn"> <span class="ico_05"> </span> </a> <a href="#top" class="gotop"> <span class="ico_06"> </span> <p> TOP </p>
    </a>
  </div>-->
  
  <div class="back-top">
     <a href="javascript:scroll(0,0)" class="gotop2">
      <img  src="themes/default/images/yun1/back-top.png"  />
      <!--<span></span>
      <p>回顶部</p>-->
     </a>
    </div>
</div>


<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script> 
<script type="text/javascript" src="__TPL__/js/lazyload/jquery.js"></script>
<script type="text/javascript" src="__TPL__/js/lazyload/jquery.lazyload.js"></script>
<script type="text/javascript" src="__PUBLIC__/imgView/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/imgView/js/jquery.panzoom.js"></script>
<script type="text/javascript" src="__PUBLIC__/imgView/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.json.js" ></script> 
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/jquery.more.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/utils.js" ></script> 
<script src="__TPL__/js/ectouch.js"></script> 
<script src="__TPL__/js/simple-inheritance.min.js"></script> 
<script src="__TPL__/js/code-photoswipe-1.0.11.min.js"></script> 
<script src="__PUBLIC__/bootstrap/js/bootstrap.min.js"></script> 
<script src="__TPL__/js/jquery.scrollUp.min.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/validform.js" ></script>
<script type="text/javascript" src="__TPL__/js/sara.js"></script>
<?php if ($_SESSION['user_id'] > 0): ?>
<script type="text/javascript">
function getQueryParams(qs) {
    qs = qs.split('+').join(' ');
    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;
    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }
    return params;
}
var query = getQueryParams(document.location.search);
//alert(query.u); 
var uid = query.u;
var url=window.location.href;
var temp=changeURLPar(url,"u",'<?php echo $_SESSION['user_id']; ?>');
// alert(temp);
//location.href=temp;
var sessionuid = '<?php echo $_SESSION['user_id']; ?>';
if (sessionuid != uid)
{
  location.href=temp;
}
</script>
<?php endif; ?>
<script language="javascript">
	/*弹出评论层并隐藏其他层*/
	function openSearch(){
		if($(".con").is(":visible")){
			$(".con").hide();	
			$(".search").show();
		}
	}
	function closeSearch(){
		if($(".con").is(":hidden")){
			$(".con").show();	
			$(".search").hide();
		}
	}
</script> 
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?5d74410ecd08fa640c2f30939878c4eb";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>