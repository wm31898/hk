<?php
namespace app\logic;

use Yii;


class CreateSignLogic{

	protected $signKey = 'TF#@UL%2hk7434sdert8&88';
	
	public function setKey($key){
		$this->signKey = $key;
        return $this;
	}
	
	public function getKey(){
		return $this->signKey;
	}

    public function createSign($data){
        $data = $this->enResponseData($data);
		//var_dump($data);
		//var_dump($this->signKey.$data.$this->signKey);
        return strtoupper(md5($this->signKey.$data.$this->signKey));
    }
	
	public function enResponseData($response){
        if (isset($response['sign']))
            unset($response['sign']);
        ksort($response);
        //return json_encode($response, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        return $this->formatBizQueryParaMap($response);
    }
	
	public function formatBizQueryParaMap($paraMap, $urlEncode = false){
        $buff = "";
        foreach ($paraMap as $k => $v)
        {
            if($urlEncode)
            {
                $v = urlencode($v);
            }
            //$buff .= $k . "=" . $v . "&";
            $buff .= $k .$v;
        }
        $reqPar="";
        if (strlen($buff) > 0)
        {
            //$reqPar = substr($buff, 0, strlen($buff)-1);
            $reqPar = $buff;
        }
        return $reqPar;
    }
}
