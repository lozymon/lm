<?php

namespace lm {

    /**
     * Description of Request
     *
     * @author lozymon
     */
    class Request {

        private $_request = array();
        private $_config;
        private $_controller;
        private $_action;
        private $_defaultController;
        private $_defaultAction;

        public function __construct() {
            $this->_config = new \Application\Config\Config();

            $this->_defaultController = $this->_config->def_controller;
            $this->_defaultAction = $this->_config->def_action;
            $this->p_initRequest();
        }

        /**
         *
         * @return string returns the controller
         */
        public function getController() {
            if (!empty($this->_controller)) {
                return $this->_controller;
            }
            return $this->_defaultController;
        }

        public function getAction() {
            if (isset($this->_action)) {
                return $this->_action . 'Action';
            }
            return $this->_defaultAction . 'Action';
        }

        /**
         *
         * @return array 
         */
        public function getParams() {
            return $this->_request;
        }

        /**
         * gets the given input param
         * @param string $v 
         * @param string $default default value
         * @return string input value 
         */
        public function getParam($v, $default = "") {
            if (isset($this->_request[$v]))
                return $this->_request[$v];
            return $default;
        }

        /**
         * prosses the REQUEST_URI;  
         */
        private function p_initRequest() {
            $this->_request = explode('/', $_SERVER['REQUEST_URI']);
            // remove the first key in the array
            array_shift($this->_request);
            // gets the constructor
            $this->_controller = array_shift($this->_request);
            // gets the action
            $this->_action = array_shift($this->_request);
        }

    }

}