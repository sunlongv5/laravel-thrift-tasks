<?php
//日志目录位置
defined('REPORT_LOG_PATH') or define('REPORT_LOG_PATH',     dirname($_SERVER['DOCUMENT_ROOT']).'/storage/logs/LogReport/');
//项目名
defined('REPORT_APP_NAME') or define('REPORT_APP_NAME',     'crm');
//单日志文件大小限制
defined('LOG_FILE_SIZE') or define('LOG_FILE_SIZE',         2097152);       //2MB

// 设定错误和异常处理
error_reporting(0);

LogReport::auto();

class LogReport
{
    static $handler = [
        'finally_except' => ['Think\Think', 'appException'],
        'finally_error' => ['Think\Think', 'appError'],
    ];

    static $data = [
        'msg'       => '',// 错误信息 
        'msgCode'   => '',// 自定义错误码 六位数字字符串 etc "100000" 
        'ts'        => '',// 10位整形 时间戳 
        'dateStr'   => '',// 日期 2018-06-28 21:24:09 
        'app'       => '',// 应用名称 
        'serverIp'  => '',// 服务器ip 
        'fileName'  => '',// 文件名 
        'lineNo'    => '',// 行数 
        'method'    => '',// 函数名 
    ];

    /**
     * 自动注册
     * @return [type] [description]
     */
    static function auto()
    {
        if (defined('APP_PATH')) {
            self::register();
            self::set();
        } else {
            self::$handler = array_map(function($v){
                return [];
            }, self::$handler);
        }
    }

    /**
     * 注册致命错误
     * @return [type] [description]
     */
    static function register()
    {
        register_shutdown_function('LogReport::fatalError');
    }

    /**
     * 设置处理方法
     */
    static function set()
    {
        set_error_handler('LogReport::appError');
        set_exception_handler('LogReport::exception');
    }

    /**
     * 错误数据格式
     * @param  string|array     $e      错误内容|'message','file','line','code','method'
     * @param  string           $file   错误文件
     * @param  string           $line   错误行数
     * @param  string           $code   错误码
     * @param  string           $method 错误函数
     * @return [type]           [description]
     */
    static function anlyError($e, $file = null, $line = null, $code = null, $method = null)
    {
        if (!is_array($e)) {
            $e = [
                'message' => $e,
                'file' => !is_null($file) ? $file : '',
                'line' => !is_null($line) ? $line : '',
                'code' => !is_null($code) ? $code : '',
                'method' => !is_null($method) ? $method : '',
            ];
        }
        $data               = self::$data;
        $data['msg']        = !empty($e['message']) ? $e['message'] : '';
        $data['msgCode']    = str_pad($e['code'], 6, '0', STR_PAD_LEFT);
        $data['ts']         = time();
        $data['dateStr']    = date('Y-m-d H:i:s');
        $data['app']        = REPORT_APP_NAME;
        $data['serverIp']   = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';;
        $data['fileName']   = !empty($e['file']) ? $e['file'] : '';
        $data['lineNo']     = !empty($e['line']) ? $e['line'] : '';
        $data['method']     = !empty($e['method']) ? $e['method'] : '';
        return $data;
    }

    /**
     * 致命错误处理
     * @return [type] [description]
     */
    static function fatalError()
    {
        if ($e = error_get_last()) {
            switch ($e['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    ob_end_clean();
                    self::write(self::anlyError($e));
                    break;
            }
        }
        // exit();
    }

    /**
     * 一般错误处理
     * @param  [type] $errno   [description]
     * @param  [type] $errstr  [description]
     * @param  [type] $errfile [description]
     * @param  [type] $errline [description]
     * @return [type]          [description]
     */
    static function appError($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                self::write(self::anlyError($errstr , $errfile, $errline));
                break;
        }
        if (!empty(self::$handler['finally_error'])) {
            call_user_func(self::$handler['finally_error'], $errno, $errstr, $errfile, $errline);
        }
    }

    /**
     * 异常处理
     * @return [type] [description]
     */
    static function exception($e)
    {
        self::write(self::anlyError($e->getMessage() , $e->getFile(), $e->getLine()));
        if (!empty(self::$handler['finally_except'])) {
            call_user_func(self::$handler['finally_except'], $e);
        }
    }

    /**
     * 日志记录
     * @param  string $log 日志内容
     * @return [type]      [description]
     */
    static function write($log)
    {
        if (is_array($log)) {
            $log = json_encode($log);
        }
        if (empty($log)) {
            return false;
        }

        // 自动创建日志目录
        if (!is_dir(REPORT_LOG_PATH)) {
            mkdir(REPORT_LOG_PATH, 0755, true);
        }
        $name = date('Ymd');
        $filename = REPORT_LOG_PATH.$name.'.log';
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if (is_file($filename) && floor(LOG_FILE_SIZE) <= filesize($filename)) {
            rename($filename, dirname($filename) . '/' . $name. '-' . time() . '.log');
        }
        $log .= PHP_EOL;
        return file_put_contents($filename, $log, FILE_APPEND);
    }
}