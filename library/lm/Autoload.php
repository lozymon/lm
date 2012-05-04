<?php

namespace lm {
    require_once __DIR__ . '/../../Application/Config/Config.php';

use Application\Config\Config;

    /**
     * Description of autoloader
     *
     * @author lozymon
     */
    class Autoload {

        /**
         *
         * @var Application\Config\Config() 
         */
        private $_config;

        /**
         *
         */
        public function __construct() {
            $this->_config = new Config();
            $this->p_IncludePaths($this->_config->getIncludePath());
            spl_autoload_register(array($this, 'load'));
        }

        /**
         *
         * @param string $class_name 
         */
        public function load($class_name) {
            //if (substr($class_name, 0, 2) === 'lm') {
            $filespac = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $class_name);
            $filespac .= '.php';

            $this->p_SecuretyCheck($filespac);
            $this->p_IncludeFile($filespac, true);
            //}
        }

        private function p_getDirectoryPath() {
            return realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
        }

        private function p_IncludePaths(array $IncludePaths) {
            foreach ($IncludePaths as $path) {
                set_include_path(implode(PATH_SEPARATOR, array(
                            realpath($this->p_getDirectoryPath() . $path), get_include_path(),
                        )));
            }
        }

        private function p_SecuretyCheck($filename) {
            if (preg_match('/[^a-z0-9\\/\\\\_.:-]/i', $filename)) {
                require_once __DIR__ . '/Autoload/Exception/SecurityException.php';
                throw new Autoload\Exception\SecurityException('Illegal character in filename');
            }
        }

        private function p_fileExist($filespac) {
            $appPath = $this->_config->getRootPath() . DIRECTORY_SEPARATOR . $filespac;
            $libPath = $this->_config->getRootPath() . DIRECTORY_SEPARATOR . $this->_config->library_folder . DIRECTORY_SEPARATOR . $filespac;

            if (file_exists($appPath) || file_exists($libPath))
                return true;
            return false;
        }

        private function p_IncludeFile($filespac, $once = false) {
            if ($this->p_fileExist($filespac)) {
                if ($once)
                    return include_once $filespac;
                else
                    return include $filespac;
            } else {
                require_once __DIR__ . '/Autoload/Exception/ClassNotFoundException.php';
                throw new Autoload\Exception\ClassNotFoundException('Can\'t find file: ' . $filespac);
            }
        }

    }

}