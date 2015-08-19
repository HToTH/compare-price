<?php
// $goodsname = @$_POST['goodsname'];
// echo json_encode($goodsname);
$fp = fopen("https://s.taobao.com/search?initiative_id=tbindexz_20150819&spm=a21bo.7724922.8452-taobao-item.2&sourceId=tb.index&search_type=item&ssid=s5-e&commend=all&imgfile=&q=hello+kity&suggest=history_1&_input_charset=utf-8&wq=hello&suggest_query=hello&source=suggest","r");
if(!feof($fp))
{
	$hello=stream_get_contents($fp,1024*1024);
	//echo $hello;
	$hello=urlencode($hello);
	$price_rule = '/%22view_price%22%3A%22(.*)%22%2C%22/';
	$url_rule = '/item.taobao.com.*%22/';
	preg_match($price_rule,$hello,$result);
	preg_match($url_rule,$hello,$url_result);
	$price=explode("%22",$result[1]);
	$url2 = explode('"',urldecode($url_result[0]));
	echo $price[0].$url2[0];
	//天猫
	// $rule = '/class%3D%22product%22(.*)class%3D%22product%22/s';
	// preg_match($rule,$hello,$result);
	// $goods_div=urldecode($result[0]);
	// $rule_price='/<\/b>(.*)<\/em>/';
	// $rule_url = '/detail.tmall.com.*" /';
	// preg_match($rule_price,$goods_div,$price);
	// preg_match($rule_url,$goods_div,$url);
	// $url=explode('"', $url[0]);
	// echo $price[1].$url[0];
}
fclose($fp);

function unescape($str) { //这个是解密用的  
         $str = rawurldecode($str);   
         preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U",$str,$r);   
         $ar = $r[0];   
         foreach($ar as $k=>$v) {   
                  if(substr($v,0,2) == "%u")   
                           $ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,-4)));   
                  elseif(substr($v,0,3) == "&#x")   
                           $ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,3,-1)));   
                  elseif(substr($v,0,2) == "&#") {   
                           $ar[$k] = iconv("UCS-2","GBK",pack("n",substr($v,2,-1)));   
                  }   
         }   
         return join("",$ar);   
}  


?>