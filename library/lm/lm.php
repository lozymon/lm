<?php

namespace lm {

    use Application\Config\Config;

    /**
     * Description of lm
     *
     * @author lozymon
     */
    class lm {

        /**
         *
         * @var Config 
         */
        private $_config;
        private $_request;

        public function __construct() {
            // init auto loader
            $this->p_initAutoload();

            // set propertys
            $this->_config = new Config();
            $this->_request = new Request();

            // init errorss
            $this->p_initErrors();

            // runs the controller
            $this->p_RunController();

            // print params if set to debug
            if ($this->_config->debug) {
                echo '<pre>';
                print_r($this->_request->getParams());
            }
        }

        /**
         * init the auto loader 
         */
        private function p_initAutoload() {
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'Autoload.php';
            new Autoload();
        }

        /**
         * runs the controller 
         */
        private function p_RunController() {
            try {
                $controllerPath = $this->_config->getControllerPath($this->_request->getController());
                new $controllerPath();
            } catch (\Exception $e) {
                echo $e;
            }
        }

        /**
         * sets the errors 
         */
        private function p_initErrors() {
            ini_set('display_errors', $this->_config->display_errors);
            ini_set('log_errors', $this->_config->log_errors);
            error_reporting(E_ALL);
        }

    }

}