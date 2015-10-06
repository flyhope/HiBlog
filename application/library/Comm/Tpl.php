<?php
/**
 * 模板相关方法
 * 
 * @author chengxuan <i@chengxuan.li>
 */
abstract class Helper_Tpl {

    /**
	 * 获取模板对象
	 * @param	string	$tpl_path	模板路径，默认值为默认module下的views
	 * @return	\Yaf_View_Simple
	 */
    static public function getView($tpl_path = '') {
        $tpl_path || $tpl_path = TPL_PATH;
        $view = new Yaf_View_Simple($tpl_path);
        return $view;
    }

    /**
	 * 加载CSS
	 * @param string $path
	 * @param boolean $return
	 * @return \mixed
	 */
    static public function css($path, $with_version = true, $return = false) {
        $href = $path;
        if($with_version) {
            $ver = self::cssVer();
            $href .= (strpos($href, '?') === false ? '?' : '&') . "version={$ver}";
        }
        
        $result = "<link href=\"{$href}\" type=\"text/css\" rel=\"stylesheet\" />";
        if ($return) {
            return $result;
        } else {
            echo $result;
            return null;
        }
    }

    /**
     * 获取图片路径（一般用户加载默认图片）
     *
     * @param string $path  相对路径
     *
     * @return \string
     */
    static public function img($path, $with_version = true) {
        $url = $path;
        if($with_version) {
            $ver = self::cssVer();
            $url .= (strpos($url, '?') === false ? '?' : '&') . "version={$ver}";
        }
        return $url;
    }

    /**
	 * 加载JS
	 * @param string $path
	 * @param boolean $return
	 * @return \mixed
	 */
    static public function js($path, $with_version = true, $return = false) {
        $src = $path;
        if($with_version) {
            $ver = self::jsVer();
            $src .= (strpos($src, '?') === false ? '?' : '&') . "version={$ver}";
            $result = "<script type=\"text/javascript\" src=\"{$src}\"></script>";
        }
        
        if ($return) {
            return $result;
        } else {
            echo $result;
            return null;
        }
    }

    /**
	 * 获取当前CSS版本号
	 * @return \string
	 */
    static public function cssVer() {
        static $ver = '';
        if (!$ver) {
            $conf = new \Yaf_Config_Ini(CONF_PATH . 'cdn');
            $ver = $conf->version->css;
        }
        return $ver;
    }

    /**
	 * 获取JS版本号
	 * @return \string
	 */
    static public function jsVer() {
        static $ver = '';
        if (!$ver) {
            $conf = new \Yaf_Config_Ini(CONF_PATH . 'cdn');
            $ver = $conf->version->js;
        }
        return $ver;
    }
    
    /**
     * 加载CDN上的JS库
     * 
     * @param string $lib_name
     * @param boolean $return
     * 
     * @return \mixed
     */
    static public function jsLib($lib_name, $return = false) {
        $conf = new \Yaf_Config_Ini(CONF_PATH . 'cdn');
        $url = $conf->lib[$lib_name];
        return $url ? self::js($url, false, $return) : '';
    }
    
    /**
     * 加载CDN上的CSS库
     *
     * @param string $lib_name
     * @param boolean $return
     *
     * @return \mixed
     */
    static public function csLib($lib_name, $return = false) {
        $conf = new \Yaf_Config_Ini(CONF_PATH . 'cdn');
        $url = $conf->lib[$lib_name];
        return $url ? self::css($url, false, $return) : '';
    }
}
