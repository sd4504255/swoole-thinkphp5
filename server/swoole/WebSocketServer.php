<?php
/*
|---------------------------------------------------------------
|  Copyright (c) 2016
|---------------------------------------------------------------
| 文件名称：数据库连接池类
| 功能 :用户信息操作
| 作者：qieangel2013
| 联系：qieangel2013@gmail.com
| 版本：V1.0
| 日期：2016/5/25
|---------------------------------------------------------------
*/
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
class WebSocketServer
{
	public static $instance;
	public function __construct() {
        define('WEB_IMG_URL','http://shop.usetool.cc/');
        define('APP_DEPLOY','external');   //当前部署环境 本地
        define('APP_PATH', __DIR__ . '/../../application/');
        define('APP_DEBUG', true);
        define('SINGKEY','QGaUCYhKnbhNUyOOvuSLWGzL#YfZWt9H');
        require_once __DIR__ . '/../../thinkphp/base.php';

//        $rui = "Goods/goodsList";
//        $dispatch = [
//            'controller' => $rui,
//            'var' => ['param'=>["page"=>1,"pageSize"=>11,"supplier_id"=>1]]
//        ];
//        \think\App::dispatch($dispatch,'controller');
//        $result = \think\App::run()->getData();
//        var_dump($result);
        //use your server ip address
		$server = new \swoole_websocket_server("127.0.0.1", 9509);
		$server->set(
			array(
				'daemonize'     => true,
                'worker_num'    => 1,
                'dispatch_mode' => 1
			)
		);
		$server->on('Open',array($this , 'onOpen'));
		$server->on('Message',array($this , 'onMessage'));
		$server->on('Close',array($this , 'onClose'));
		$server->start();
	}

	public function onOpen($server, $req) {
        $server->push($req->fd,'{"errcode":"0","error":"没有错误","data":"连接成功"}');
	}
	public function onMessage($server, $frame){

//        $rui = "Test/test";
//        $dispatch = [
//            'controller' => $rui,
//            'var' => ['param'=>[11,11,11,3]]
//        ];
//        \think\App::dispatch($dispatch,'controller');
//        $result = \think\App::run()->getData();
//        var_dump($result);

        if(empty($frame->data)){
            $server->push($frame->fd,'{"errcode":"101","error":"数据为空","data":[]}');
        }else {
            $reback = ['error'=>'服务器错误','errCode'=>103,'data'=>[]];
            try {
                $actionData = json_decode($frame->data, true);
                if(isset($actionData['action']) && !empty($actionData['action'])) {
                    $param = \think\Request::instance()->input($actionData['param']);
                    $dispatch = [
                        'controller' => $actionData['action'],
                        'var' => ['param'=>$param]
                    ];
                    \think\App::dispatch($dispatch,'controller');
                    $result = \think\App::run()->getData();
                    $server->push($frame->fd, $result);
                }else{
                    $reback['error']    = '参数错误';
                    $reback['errCode']  = 119;
                    $server->push($frame->fd, json_encode($reback));
                }
            } catch (\Exception $e) {
                $reback['data']=$e;
                $server->push($frame->fd,json_encode($reback));
            }
        }
	}
	public function onClose($server, $fd) {
	}
	public static function getInstance() {
		if (!self::$instance) {
            self::$instance = new WebSocketServer;
        }
        return self::$instance;
	}
}

WebSocketServer::getInstance();
