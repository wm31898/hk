<?php
/**
 * Created by PhpStorm.
 * User: china
 * Date: 2016/12/1
 * Time: 16:51
 */

namespace app\component;


class HttpClient
{
    public $port = 80;
    public $header = [];
    public $type;
    public function __construct($type='text')
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }
    /**
     * @param array $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    var $curl_timeout = 30; //curl超时时间

	public function httpRequest($url, $data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_TIMEOUT, $this->curl_timeout);
		//curl_setopt($curl, CURLOPT_PORT, $this->getPort());
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		if (!empty($data)){
			$hd[] = 'HEADER_LOGINID:';
			$hd[] = 'HEADER_CHANNELID:php';
			if(isset($data['timestamp']) && $data['timestamp']!=''){
				$hd[] = 'HEADER_TIMESTAMP:'.$data['timestamp'];
			}
			if(isset($data['requestId']) && $data['requestId']!=''){
				$hd[] = 'HEADER_REQUESTID:'.$data['requestId'];
			}
			if(isset($data['sign']) && $data['sign']!=''){
				$hd[] = 'HEADER_SIGN:'.$data['sign'];
			}
			$this->header = array_merge($this->header,$hd);
			
		    if ($this->type == 'json')
            {
                $data = json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
				$this->header = array_merge($this->header,['Content-Type: application/json', 'Content-Length:'.strlen($data)]);
                //$this->header = $this->header+['Content-Type: application/json', 'Content-Length:'.strlen($data)];
            }
			
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header);

			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);

        //$info = curl_getinfo($curl);
        //$this->printTime($info);

		curl_close($curl);
		return $output;
	}

    /**
     * @Author pwr at 2018-01-24
     * @name printTime
     * @todo 查看curl的请求信息
     */
    public function printTime($curlInfo) {
        $total_time = $curlInfo['total_time'];      //获得用秒表示的上一次传输总共的时间，包括DNS解析、TCP连接等。
        $namelookup_time = $curlInfo['namelookup_time'];      //获得用秒表示的从最开始到域名解析完毕的时间。
        $connect_time = $curlInfo['connect_time'];      //获得用秒表示的从最开始直到对远程主机（或代理）的连接完毕的时间。
        $pretransfer_time = $curlInfo['pretransfer_time'];      //获得用秒表示的从最开始直到文件刚刚开始传输的时间。
        $starttransfer_time = $curlInfo['starttransfer_time'];      //获得用秒表示的从最开始到第一个字节被curl收到的时间。
        $redirect_time = $curlInfo['redirect_time'];      //获得所有用秒表示的包含了所有重定向步骤的时间，包括DNS解析、连接、传输前（pretransfer)和在最后的一次传输开始之前。

        echo "1. 总共的传输时间（total_time）为：" . $total_time . " 秒\n";

        echo "2. 直到DNS解析完成时间（namelookup_time）为：" . $namelookup_time . " 秒\n";

        echo "3. 建立连接时间（connect_time）为：" . $connect_time . " 秒\n";

        echo "4. 传输前耗时（pretransfer_time）为：" . $pretransfer_time . " 秒\n";

        echo "5. 开始传输（starttransfer_time）为：" . $starttransfer_time . " 秒\n";

        echo "6. 重定向时间（redirect_time）为：" . $redirect_time . " 秒\n";

        var_dump($curlInfo);
        //die('ok');
    }
}