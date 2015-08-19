$(document).ready(function(){
		function over()
	{
		$("#bggroud").css({"overflow":"visible","height":"auto"});
	}
	$('.text').click(function(){
		$('.text').val("");
	});
	$("#button").click(function(){
		$("#search").animate({
			"margin-top": "-70px"},
			1000);
		$("#bggroud").animate({"height":"600px"},1000).delay(1000, 'over');
		
		
		//delay(1000, 'over');
		//ajax发送消息
		var goodsname=$('#goods').val();
		goodsname="goodsname="+goodsname;
		//ajax(goodsname,"name");
		$.ajax({
			url:"./php/getprice.php",
			data:goodsname,
			type:'post',
			cache:false,
			success:function(data)
			{
				alert(data);
				var price=data.split('!!');
				var reg = /[\u4e00-\u9fa5]/g;
				//判断淘宝
				if(reg.test(price[1])){
					  $("#taobao-l").text("商品没有找到");
					  $("#taobao-h").text("商品没有找到");
					  if(reg.test(price[2])){
							 $("#tmall-l").text("商品没有找到");
							  $("#tmall-h").text("商品没有找到");
							}
						else
							{
								$("#tmall-l").attr("href","//"+unescape(price[6]));
								$("#tmall-l").text(price[5]);
								$("#tmall-h").attr("href","//"+unescape(price[8]));
								$("#tmall-h").text(price[7]);
							}

					}
				else
				{
					$("#taobao-l").attr("href","//"+unescape(price[2]));
					$("#taobao-l").text(price[1]);
					$("#taobao-h").attr("href","//"+unescape(price[4]));
					$("#taobao-h").text(price[3]);
						if(reg.test(price[5])){
						 $("#tmall-l").text("商品没有找到");
						  $("#tmall-h").text("商品没有找到");
						}
						else
						{
							$("#tmall-l").attr("href","//"+unescape(price[6]));
							$("#tmall-l").text(price[5]);
							$("#tmall-h").attr("href","//"+unescape(price[8]));
							$("#tmall-h").text(price[7]);
						}

				}

				//判断天猫

				
				
			},
			 error: function (XMLHttpRequest, textStatus, errorThrown) { 
                                                alert(errorThrown); 
                          } 
		});
	
	});


	// function ajax(cmd,action){
 //    //1.创建对象
 //    var oAjax = null;
 //    if(window.XMLHttpRequest){
 //        oAjax = new XMLHttpRequest();
 //    }else{
 //        oAjax = new ActiveXObject("Microsoft.XMLHTTP");
 //    }
        
 //    //2.连接服务器  
 //    oAjax.open('post', "./php/getprice.php", true);   //open(方法, url, 是否异步)
      
 //    //3.发送请求 
 //    oAjax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 //        //判断发送的请求给谁
 //    oAjax.send("goodsname="+cmd+"&action="+action);
	// //4.接收返回
	// oAjax.onreadystatechange = function(){  //OnReadyStateChange事件
 //        if(oAjax.readyState == 4){  //4为完成
 //            if(oAjax.status == 200){    //200为成功
 //                var responseText=oAjax.responseText;
 //                alert(responseText);
 //           		 }
 //                else{

 //                    alert('无法找到主机');
 //            }
 //        }
 //    }
	// }
})