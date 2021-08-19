<?php

namespace App\Http\Controllers;
use AlibabaCloud\SDK\ViapiUtils\ViapiUtils;
use AlibabaCloud\SDK\Facebody\V20191230\Facebody;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Facebody\V20191230\Models\RecognizeExpressionRequest;
use Illuminate\Http\Request;
class TestController extends Controller
{
    public static function Change(Request $request){
        // 您的AccessKeyID
        $accessKeyId = "LTAI5tFWNMGyG7DX4NSNk5NS";
        // 您的AccessKeySecret
        $accessKeySecret = "n7ysxjvuzgA9LFvpM6fy8Ip7JNBi4Q";
        // 要上传的文件路径，url 或 filePath
        $fileUrl =$request["url"];
        // 上传成功后，返回上传后的文件地址
        $fileLoadAddress = ViapiUtils::upload($accessKeyId, $accessKeySecret, $fileUrl);
        return  $fileLoadAddress?
            json_success("成功",$fileLoadAddress,"200"):
            json_fail("失败",null,"100");
   }
    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return Facebody Client
     */
    public static function createClient($accessKeyId, $accessKeySecret){
        $config = new Config([
            // 您的AccessKey ID
            "accessKeyId" => $accessKeyId,
            // 您的AccessKey Secret
            "accessKeySecret" => $accessKeySecret
        ]);
        // 访问的域名
        $config->endpoint = "facebody.cn-shanghai.aliyuncs.com";
        return new Facebody($config);
    }

    /**
     * @param string[] $args
     * @return void
     */
    public static function Test(Request $request){
        $client = self::createClient("LTAI5tFWNMGyG7DX4NSNk5NS", "n7ysxjvuzgA9LFvpM6fy8Ip7JNBi4Q");
        $recognizeExpressionRequest = new RecognizeExpressionRequest([
            "imageURL" => "$request[url]"
        ]);
        // 复制代码运行请自行打印 API 的返回值
       $data =  $client->recognizeExpression($recognizeExpressionRequest);
        return  $client->recognizeExpression($recognizeExpressionRequest)?
             json_success("成功",$data,"200"):
             json_fail("失败",null,"100");
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}


