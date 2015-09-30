<?php
/**
 * 异常处理方法
 * 
 * @author chengxuan
 */
class ErrorController extends Yaf_Controller_Abstract {

    /**
     * 错误控制入口
     * 
     * @param Exception $exception
     * @return boolean
     */
    public function errorAction(Exception $exception) {
        var_dump($exception);
        return false;
    }
    
    /**
     * 追加JSON高度信息
     *
     * @param array     $result    原要数据的数据
     * @param Exception $exception 异常对象
     *
     * @return array
     */
    protected function _appendDebugJson(array $result, Exception $exception) {
        if (ini_get('display_errors')) {
            $result['_debug']['code'] = $exception->getCode();
            $result['_debug']['message'] = $exception->getMessage();
            $result['_debug']['file'] = $exception->getFile();
            $result['_debug']['line'] = $exception->getLine();
            $result['_debug']['trace'] = $exception->getTrace();
            if (method_exists($exception, 'getMetadata')) {
                $result['_debug']['metadata'] = $exception->getMetadata();
            }
        }
        return $result;
    }
    
    /**
     * 显示调试HTML
     * @param Exception $exception
     * @return boolean
     */
    protected function _debugHtml($exception) {
        try {
            $type = get_class($exception);
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $file = $exception->getFile();
            $line = $exception->getLine();
    
            $trace = $exception->getTrace();
    
            $this->getView()->assign(array(
                'type' => $type,
                'code' => $code,
                'message' => $message,
                'file' => $file,
                'line' => $line,
                'trace' => $trace,
            ));
            $this->display('debug');
        } catch (Exception $exception) {
            var_dump($exception);
            return false;
        }
    }
    
    
}
