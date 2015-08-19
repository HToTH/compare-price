<?php
class getprice
{


	function tmall($search)
	{
		//最低价
		$url_lowprice="https://list.tmall.com/search_product.htm?q=$search&sort=p&style=g&tmhkmain=0#J_Filter";
		$this->tmall=array($this->tmall_price($url_lowprice));
		$url_highprice="https://list.tmall.com/search_product.htm?q=$search&sort=pd&style=g&tmhkmain=0#J_Filter";
		$this->tmall=array($this->tmall_price($url_lowprice));
		array_push($this->tmall, $this->tmall_price($url_highprice));
		if(!empty($this->tmall[0][0]))
		{
			return $this->tmall;
		}
		else
		{
			return "商品没找到";
		}
	}

	function tmall_price($url)
	{
		$fp = @fopen("$url","r");
		if(!feof($fp))
		{
			$hello=stream_get_contents($fp,1024*1024);
			//print_r($hello);
			$hello=urlencode($hello);
			$rule = '/class%3D%22product%22(.*)class%3D%22product%22/s';
			preg_match($rule,$hello,$result);
			$goods_div=@urldecode($result[0]);
			$rule_price='/<\/b>(.*)<\/em>/';
			$rule_url = '/detail.tmall.com.*" /';
			preg_match($rule_price,$goods_div,$price);
			preg_match($rule_url,$goods_div,$url);
			$url=@explode('"', $url[0]);
			return @array($price[1],$url[0]);
		}
		fclose($fp);
	}

	function taobao($search)
	{

		//最低价
		$url_lowprice="https://s.taobao.com/search?q=$search&commend=all&ssid=s5-e&search_type=item&sourceId=tb.index&spm=a21bo.7724922.8452-taobao-item.2&initiative_id=tbindexz_20150819&sort=price-asc";
		$this->taobao=array($this->taobao_price($url_lowprice));
		$url_highprice="https://s.taobao.com/search?q=hello+kity&commend=all&ssid=s5-e&search_type=item&sourceId=tb.index&spm=a21bo.7724922.8452-taobao-item.2&initiative_id=tbindexz_20150819&sort=price-desc";
		$this->taobao=array($this->taobao_price($url_lowprice));
		array_push($this->taobao, $this->taobao_price($url_highprice));
		if(!empty($this->taobao[0][0]))
		{
			return $this->taobao;
		}
		else
		{
			return "商品没找到";
		}
	}

	function taobao_price($url)
	{
		$fp = @fopen("$url","r");
		if(!feof($fp))
		{
			$hello=stream_get_contents($fp,1024*1024);
			$hello=urlencode($hello);
			$price_rule = '/%22view_price%22%3A%22(.*)%22%2C%22/';
			$url_rule = '/item.taobao.com.*%22/';
			preg_match($price_rule,$hello,$result);
			preg_match($url_rule,$hello,$url_result);
			$price=explode("%22",$result[1]);
			$url2 = explode('"',urldecode($url_result[0]));
			return @array($price[0],$url2[0]);
		}
		fclose($fp);
	}
	
}

class getinfo extends getprice
{
	function post()
	{
	$all_goods="";//所有的商店的价格和url链接
	$goodsname = @$_POST['goodsname'];
	$goodsname = urlencode($goodsname);
	$taobao = parent::taobao($goodsname);
	$all_goods .=$this->confirm($taobao); 
	$tmall=parent::tmall($goodsname);
	$all_goods .=$this->confirm($tmall);
	echo $all_goods;
	//$goods=json_encode($goods);
	}
	//转换成字符串
	function confirm($goods)
	{
		$goods_re="";
		if(is_array($goods))
		{
		foreach ($goods as $key=>$value) {
			$goods_re.="!!".$value[0]."!!".$value[1];
		}

		return $goods_re;
		}
		else
		{
		return "!!".$goods;
		}

		}
}

$final=new getinfo;
$final->post();
?>