//返回顶部滚动效果


  function getScrollTop()

                  {

                      var scrollTop = 0;

                      if (document.documentElement && document.documentElement.scrollTop)

                      {

                          scrollTop = document.documentElement.scrollTop;

                      }

                      else if (document.body)

                      {

                          scrollTop = document.body.scrollTop;

                      }

                      return scrollTop;

                  }

                  

                  $(window).scroll(function () {

                      var height = getScrollTop();

                     // var top = getTop();

                      if (height > 480) {

                          jQuery(".back-top").stop().animate({ opacity: '1' }, 100);

                      }

                      else {

                          jQuery(".back-top").stop().animate({ opacity: '0' }, 100);

                      }

					  

					  

					  /*头部滚动显示*/

					  if (height >0 && height <80) {

                          jQuery("#header .user-header2 h1").stop().animate({ opacity: '0.4' }, 200);

                      }

					  else if(height >120 && height <170){

					     jQuery("#header .user-header2 h1").stop().animate({ opacity: '0.6' }, 200);

					  }

					  

					  else if(height >180 && height <260){

					     jQuery("#header .user-header2 h1").stop().animate({ opacity: '0.8' }, 200);

					  }

					  else if(height >280){

					     jQuery("#header .user-header2 h1").stop().animate({ opacity: '1' }, 100);

					  }

                      else if(height==0){

                          jQuery("#header .user-header2 h1").stop().animate({ opacity: '0' }, 300); 

                      }

                  }); 

   



/*会员中心*/

//会员中心 菜单显示隐藏



         $(".menu-bg").css("display","none");

        // $(".user-header dl").css("display","none");

		 $("#header .header_r a").click(function(){

			    $(".member-list-menu").stop().slideDown();

				$(".menu-bg").css("display","block");

		})

		$(".menu-bg").click(function(){

			   $(".member-list-menu").stop().slideToggle();

			   $(".menu-bg").css("display","none");

			})

			

/*会员中心 end*/

//会员中心 菜单显示隐藏


        // $(".user-header dl").css("display","none");

		 $("#header .header_r a").click(function(){

			    $(".member-list-menu2").css("display","block");

				$(".menu-bg3").css("display","block");

		})

		$(".menu-bg3").click(function(){

			   $(".member-list-menu2").css("display","none");

			   $(".menu-bg3").css("display","none");

			})

			

/*会员中心 end*/


//首页导航菜单（仿淘宝）

 $("#J_Shade").hide();

 // $(".taoplus .circle").removeClass("show").addClass("hide");

  $(".taoplus .tpbtn ul li").click(function(){

       $("#J_Shade").show();

	   var tem=$(".tpbtn div ul").attr("class");

	   if(tem=='aa'){

		     $(this).parents(".tpbtn").removeClass("off").addClass("on");

	         $(".taoplus .circle").removeClass("show").addClass("hide");

			 $("#J_Shade").hide();

		     $(".taoplus .tpbtn ul").removeClass("aa"); 

	   }

	   else{

			 $(this).parents(".tpbtn").removeClass("on").addClass("off");

	         $(".taoplus .circle").removeClass("hide").addClass("show");

		     $(".taoplus .tpbtn ul").addClass("aa");

		   } 

	  })

	

	$("#J_Shade").click(function(){

		  $(".taoplus .circle").removeClass("show").addClass("hide");

		  $(".taoplus .tpbtn").removeClass("off").addClass("on");

		  $(this).hide();

		  $(".taoplus .tpbtn ul").removeClass("aa");

		})



//取链接参数





/*商品列表页升降切换*/

$(".filter a").click(function(){

	  var tem=$(this).attr("class");

	  if(tem=="ect-colory"){

		    $(this).addClass("select");

		  }

	  if("tem=='ect-colory select'"){

		    $(this).removeClass("select");

		  }

	})



/*商品筛选页面*/

$(".touchweb-com_listType ul.ul1").find("li:last").css("border-bottom","none");


/*获取url 参数*/
function getUrlParams(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }
		

//设置url参数值，ref参数名,value新的参数值
        function changeURLPar(url, ref, value)
        {
            var str = "";
            if (url.indexOf('?') != -1)
                str = url.substr(url.indexOf('?') + 1);
            else
                return url + "?" + ref + "=" + value;
            var returnurl = "";
            var setparam = "";
            var arr;
            var modify = "0";
            if (str.indexOf('&') != -1) {
                arr = str.split('&');
                for (i in arr) {
                    if (arr[i].split('=')[0] == ref) {
                        setparam = value;
                        modify = "1";
                    }
                    else {
                        setparam = arr[i].split('=')[1];
                    }
                    returnurl = returnurl + arr[i].split('=')[0] + "=" + setparam + "&";
                }
                returnurl = returnurl.substr(0, returnurl.length - 1);
                if (modify == "0")
                    if (returnurl == str)
                        returnurl = returnurl + "&" + ref + "=" + value;
            }
            else {
                if (str.indexOf('=') != -1) {
                    arr = str.split('=');
                    if (arr[0] == ref) {
                        setparam = value;
                        modify = "1";
                    }
                    else {
                        setparam = arr[1];
                    }
                    returnurl = arr[0] + "=" + setparam;
                    if (modify == "0")
                        if (returnurl == str)
                            returnurl = returnurl + "&" + ref + "=" + value;
                }
                else
                    returnurl = ref + "=" + value;
            }
            return url.substr(0, url.indexOf('?')) + "?" + returnurl;
        }


        //删除参数值
        function delQueStr(url, ref) {
            var str = "";
            if (url.indexOf('?') != -1) {
                str = url.substr(url.indexOf('?') + 1);
            }
            else {
                return url;
            }
            var arr = "";
            var returnurl = "";
            var setparam = "";
            if (str.indexOf('&') != -1) {
                arr = str.split('&');
                for (i in arr) {
                    if (arr[i].split('=')[0] != ref) {
                        returnurl = returnurl + arr[i].split('=')[0] + "=" + arr[i].split('=')[1] + "&";
                    }
                }
                return url.substr(0, url.indexOf('?')) + "?" + returnurl.substr(0, returnurl.length - 1);
            }
            else {
                arr = str.split('=');
                if (arr[0] == ref) {
                    return url.substr(0, url.indexOf('?'));
                }
                else {
                    return url;
                }
            }
        }
		
		
/*倒计时*/
/*
function GetRTime(){
       var EndTime = new Date('2015/07/16 18:00:00');
       var NowTime = new Date();
       var t =EndTime.getTime() - NowTime.getTime();
       var d=Math.floor(t/1000/60/60/24);
       var h=Math.floor(t/1000/60/60%24);
       var m=Math.floor(t/1000/60%60);
       var s=Math.floor(t/1000%60);

       document.getElementById("t_h").innerHTML = h ;
       document.getElementById("t_m").innerHTML = m ;
       document.getElementById("t_s").innerHTML = s ;
   }
   setInterval(GetRTime,0);
*/
