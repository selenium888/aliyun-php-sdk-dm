<?php

namespace Selenium888\Aliyun\Dm;

use Selenium888\Aliyun\Dm\Dm\Request\V20151123 as Push;
use Superman2014\Aliyun\Core\Profile\DefaultProfile;
use Superman2014\Aliyun\Core\DefaultAcsClient;
use Superman2014\Aliyun\Core\Regions\ProductDomain;
use Superman2014\Aliyun\Core\Regions\Endpoint;
use Superman2014\Aliyun\Core\Regions\EndpointProvider;

$regionIds = ['cn-hangzhou', 'cn-beijing', 'cn-qingdao', 'cn-hongkong', 'cn-shanghai', 'us-west-1', 'cn-shenzhen', 'ap-southeast-1'];
$productDomains = [
    new ProductDomain('Mts', 'mts.cn-hangzhou.aliyuncs.com'),
    new ProductDomain('ROS', 'ros.aliyuncs.com'),
    new ProductDomain('Dm', 'dm.aliyuncs.com'),
    new ProductDomain('Sms', 'sms.aliyuncs.com'),
    new ProductDomain('Bss', 'bss.aliyuncs.com'),
    new ProductDomain('Ecs', 'ecs.aliyuncs.com'),
    new ProductDomain('Oms', 'oms.aliyuncs.com'),
    new ProductDomain('Rds', 'rds.aliyuncs.com'),
    new ProductDomain('BatchCompute', 'batchCompute.aliyuncs.com'),
    new ProductDomain('Slb', 'slb.aliyuncs.com'),
    new ProductDomain('Oss', 'oss-cn-hangzhou.aliyuncs.com'),
    new ProductDomain('OssAdmin', 'oss-admin.aliyuncs.com'),
    new ProductDomain('Sts', 'sts.aliyuncs.com'),
    new ProductDomain('Push', 'cloudpush.aliyuncs.com'),
    new ProductDomain('Yundun', 'yundun-cn-hangzhou.aliyuncs.com'),
    new ProductDomain('Risk', 'risk-cn-hangzhou.aliyuncs.com'),
    new ProductDomain('Drds', 'drds.aliyuncs.com'),
    new ProductDomain('M-kvstore', 'm-kvstore.aliyuncs.com'),
    new ProductDomain('Ram', 'ram.aliyuncs.com'),
    new ProductDomain('Cms', 'metrics.aliyuncs.com'),
    new ProductDomain('Crm', 'crm-cn-hangzhou.aliyuncs.com'),
    new ProductDomain('Ocs', 'pop-ocs.aliyuncs.com'),
    new ProductDomain('Ots', 'ots-pop.aliyuncs.com'),
    new ProductDomain('Dqs', 'dqs.aliyuncs.com'),
    new ProductDomain('Location', 'location.aliyuncs.com'),
    new ProductDomain('Ubsms', 'ubsms.aliyuncs.com'),
    new ProductDomain('Drc', 'drc.aliyuncs.com'),
    new ProductDomain('Ons', 'ons.aliyuncs.com'),
    new ProductDomain('Aas', 'aas.aliyuncs.com'),
    new ProductDomain('Ace', 'ace.cn-hangzhou.aliyuncs.com'),
    new ProductDomain('Dts', 'dts.aliyuncs.com'),
    new ProductDomain('R-kvstore', 'r-kvstore-cn-hangzhou.aliyuncs.com'),
    new ProductDomain('PTS', 'pts.aliyuncs.com'),
    new ProductDomain('Alert', 'alert.aliyuncs.com'),
    new ProductDomain('Push', 'cloudpush.aliyuncs.com'),
    new ProductDomain('Emr', 'emr.aliyuncs.com'),
    new ProductDomain('Cdn', 'cdn.aliyuncs.com'),
    new ProductDomain('COS', 'cos.aliyuncs.com'),
    new ProductDomain('CF', 'cf.aliyuncs.com'),
    new ProductDomain('Ess', 'ess.aliyuncs.com'),
    new ProductDomain('Ubsms-inner', 'ubsms-inner.aliyuncs.com'),
    new ProductDomain('Green', 'green.aliyuncs.com'),
];

$endpoint = new Endpoint('cn-hangzhou', $regionIds, $productDomains);
$endpoints = array($endpoint);
EndpointProvider::setEndpoints($endpoints);

defined('ENABLE_HTTP_PROXY') or define('ENABLE_HTTP_PROXY', false);
defined('HTTP_PROXY_IP') or define('HTTP_PROXY_IP', '127.0.0.1');
defined('HTTP_PROXY_PORT') or define('HTTP_PROXY_PORT', '8888');


class PushSender
{
    /**
     * 阿里云推送消息.
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $appKey
     * @param $target
     * @param $targetValue
     * @param $title
     * @param array $content
     * @return string
     */
    public function push($accessKeyId, $accessKeySecret, $appKey, $target, $targetValue, $title, array $content)
    {
        //将要发送的内容转为json格式
        $content = json_encode($content);
        $iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $accessKeyId, $accessKeySecret);
        $client = new DefaultAcsClient($iClientProfile);
        $request = new Push\PushMessageToAndroidRequest();

        $request->setAppKey($appKey);
        $request->setTarget($target); //推送目标: DEVICE:按设备推送 ALIAS:按别名推送 ACCOUNT:按帐号推送  TAG:按标签推送; ALL:广播推送
        $request->setTargetValue($targetValue); //根据Target来设定，如Target=DEVICE, 则对应的值为 设备id1,设备id2. 多个值使用逗号分隔.(帐号与设备有一次最多100个的限制)
        $request->setTitle($title);
        $request->setBody($content);

        $response = $client->getAcsResponse($request);
        return json_encode($response);
    }
}
