<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
class QiniuController extends Controller
{
	public $RSF_HOST = 'http://rsf.qbox.me';
	public $RS_HOST = 'http://rs.qbox.me';
	public $UP_HOST = 'http://upload-na0.qiniu.com';
	public $IO_HOST = 'http://iovip.qbox.me';
	public $timeout = 3600;

	//p配置
	public $sk = 'D_l3GcFAjIA4o0-PBTenIWAumRmEl1fr4pP5LMfa';
	public $ak = 't3XBD9Job8IqehXOZBm6IRjBC4B9tZCkN9hMD6Jd';
	public $domain = 'opvmrt6l7.bkt.gdipper.com';
	public $bucket = 'huangsite-blog';


	public function __construct($config = array(),$host = ''){
		if(!empty($config)){
			$this->sk = $config['secrectKey'];
			$this->ak = $config['accessKey'];
			$this->domain = $config['domain'];
			$this->bucket = $config['bucket'];
			$this->timeout = isset($config['timeout'])? $config['timeout'] : 3600;
		}
		if($host != '') $this->UP_HOST = $host;
	}

	static function sign ($sk,$ak,$data){
		$sign = hash_hmac('sha1', $data, $sk, true);
		return $ak . ':' . self::encode($sign);
	}

	static function signWithData($sk,$ak,$data){
		$data = self::encode($data);
		return self::sign($sk,$ak,$data) . ':' . $data;
	}

	static function encode ($str){
		$find = array('+', '/');
		$replace = array('-', '_');
		return str_replace($find, $replace, base64_encode($str));
	}

    public function index()
    {
        return view('admin.qiniu');
    }

	public function uploadToken($sk,$ak,$param){
		$deadline = time() + 3600;
		$data = array('scope'=> $this->bucket,'deadline'=>$deadline);
		array_merge($data,$param);
		$data = json_encode($data);
		return self::SignWithData($sk,$ak,$data);
	}

	public function accessToken($url, $body = ''){
		$parsed_url = parse_url($url);
		$path = $parsed_url['path'];
		$access = $path;
		if(isset($parsed_url['query'])) $access .= "?" . $parsed_url['query'];
		$access .= "\n";
		if($body !== null) $access .= $body;
		return self::sign($this->sk, $this->ak, $access);
	}

	/**
	 * 图片上传
	 * @param $file array('fileName'=>'','temp'=>'') 文件名称，临时文件/base64编码
	 * @param $config array('saveName'=>'') 保存文件全名，包括路径
	 * @param $type 上传类型 file $_FILES, base64 base64编码上传。
	 */
	public function upload ($file,$config,$type){
		$mimeBoundary = md5(microtime());
		$uploadToken = $this->uploadToken($this->sk,$this->ak,$config);
		if($type == 'file'){
			$mimeBoundary = md5(microtime());
			$uploadToken = $this->uploadToken($this->sk,$this->ak,$config);
			$header[] = 'Content-Type:multipart/form-data;boundary=' . $mimeBoundary;
			$data = array(
				'--' . $mimeBoundary,
				'Content-Disposition: form-data; name="token"',
				'',
				$uploadToken,
				'--' . $mimeBoundary,
				'Content-Disposition: form-data; name="key"',
				'',
				$config['saveName'],
				'--' . $mimeBoundary,
				'Content-Disposition: form-data; name="file"; filename="' . $file['fileName'] . '"',
				'Content-Type: application/octet-stream',
				'Content-Transfer-Encoding: binary',
				''
			);
			array_push($data,file_get_contents($file['temp']));
			array_push($data,'--' . $mimeBoundary . '--');
			$body = implode("\r\n", $data);
			$header[] = 'Content-Length:' . @strlen($body);
			return $this->request($this->UP_HOST,$header,$body);
		}else{
			preg_match('/\/(.*)\;/',$file['temp'],$suffix);
			$header = array(
				'Content-Type:image/' . $suffix[1],
				'Authorization:UpToken ' . $uploadToken,
				'Content-Type:application/octet-stream'
			);
			$body = substr(strstr($file['temp'],','),1);
			$requestUrl = $this->UP_HOST . '/putb64/-1/key/' . self::encode($config['saveName']);
			return $this->request($requestUrl,$header,$body);
		}
	}

	//抓取远程图片
	public function fetch ($fileurl,$newfile){
		$entry = self::encode($fileurl);
		$save = self::encode("{$this->bucket}:$newfile");
		$opturl = $this->IO_HOST.'/fetch/'.$entry.'/to/'.$save;
		$accessToken = $this->accessToken($opturl);
		$header[] = 'Content-Type: application/json';
		$header[] = 'Authorization: QBox '.$accessToken;
		$response = $this->request($opturl,$header);
		return $response;
	}

	// 图片处理
	public function dealImage ($file,$type,$data){
		$newfile = isset($data['newfile']) && !empty($data['newfile']) ? $data['newfile'] : $file;
		$entry = self::encode("{$this->bucket}:{$newfile}");
		switch($type){
			case 'crop':
					$opturl = $this->domain.'/'.$file.'?imageMogr2/crop/!'.$data['w'].'x'.$data['h'].'a'.$data['x'].'a'.$data['y'].'|saveas/'.$entry;
				break;
			case 'thumb':
					$opturl = $this->domain.'/'.$file.'?imageMogr2/thumbnail/'.$data['w'].'x'.$data['h'].'|saveas/'.$entry;
				break;
			case 'rotate':
					$opturl = $this->domain.'/'.$file.'?imageMogr2/rotate/'.$data.'|saveas/'.$entry;
				break;
		}
		$sign = self::sign($this->sk,$this->ak,$opturl);
		$url = 'http://'.$opturl.'/sign/'.$sign;
		$response = $this->request($url);
		return $response;
	}

	//列出资源
	public function listFile ($query = array()){
		$query = array_merge(array('bucket'=>$this->bucket), $query);
        $url = "{$this->RSF_HOST}/list?".http_build_query($query);
        $accessToken = $this->accessToken($url);
        $response = $this->sendrequest($url,'POST',array('Authorization'=>"QBox $accessToken"));
        return $response;
	}

	//删除文件
	public function deleteFile ($file){
		if(is_array($file)){
			$url = $this->RS_HOST . '/batch';
			$ops = array();
			foreach ($file as $val) {
				$delfile = is_array($val) ? $val['key'] : $val;
				$ops[] = "/delete/". self::encode("{$this->bucket}:{$delfile}");
			}
			$params = 'op=' . implode('&op=', $ops);
			$url .= '?'.$params;
			$accessToken = $this->accessToken($url);
			$response = $this->sendrequest($url,'POST',array('Authorization'=>"QBox $accessToken"));
			return $response;
		}else{
			$key = trim($file);
			$url = "{$this->RS_HOST}/delete/" . self::encode("{$this->bucket}:{$key}");
			$accessToken = $this->accessToken($url);
			$response = $this->sendrequest($url,'POST',array('Authorization'=>"QBox $accessToken"));
			return $response;
		}
	}

	public function request ($url,$header = null,$body = null){
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER,1);
		if(!is_null($header)) curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
		if(!is_null($body)) curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		curl_setopt($curl, CURLOPT_POST, 1);
		$result = curl_exec($curl);
		list($header, ,$body) = explode("\r\n\r\n",$result,3);
		curl_close($curl);
		if($result !== false){
			return json_decode($body,true);
		}else{
			return $header;
		}
	}

	/**
	 * 请求云服务器
	 * @param  string   $path    请求的PATH
	 * @param  string   $method  请求方法
	 * @param  array    $headers 请求header
	 * @param  resource $body    上传文件资源
	 * @return boolean
	 */
	private function sendrequest($path, $method, $headers = null, $body = null){
		$ch  = curl_init($path);
		$_headers = array('Expect:');
		if (!is_null($headers) && is_array($headers)){
			foreach($headers as $k => $v) {
				array_push($_headers, "{$k}: {$v}");
			}
		}
		$length = 0;
		$date   = gmdate('D, d M Y H:i:s \G\M\T');
		if (!is_null($body)) {
			if(is_resource($body)){
				fseek($body, 0, SEEK_END);
				$length = ftell($body);
				fseek($body, 0);

				array_push($_headers, "Content-Length: {$length}");
				curl_setopt($ch, CURLOPT_INFILE, $body);
				curl_setopt($ch, CURLOPT_INFILESIZE, $length);
			} else {
				$length = @strlen($body);
				array_push($_headers, "Content-Length: {$length}");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			}
		}else{
			array_push($_headers, "Content-Length: {$length}");
		}
		array_push($_headers, "Date: {$date}");

		curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

		$post = $method == 'PUT' || $method == 'POST' ? 1 : 0;
		curl_setopt($ch, CURLOPT_POST, $post);

		if($method == 'HEAD') curl_setopt($ch, CURLOPT_NOBODY, true);
		$response = curl_exec($ch);
		curl_close($ch);
		list($header, $body) = explode("\r\n\r\n", $response, 2);
		if($response !== false){
			return json_decode($body,true);
		}else{
			return $header;
		}
	}
}
