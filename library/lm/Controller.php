<?php

namespace lm {

    /**
     * Description of Controller
     *
     * @author lozymon
     */
    class Controller {

        /**
         * @var Request
         */
        private $_request;
        private $_config;

        public function __construct() {
            $this->_request = new Request();
            $this->_config = new \Application\Config\Config();
            $this->RunActions();
        }

        /**
         *
         * @return Request 
         */
        public function getRequest() {
            return $this->_request;
        }

        /**
         *
         * @return \Application\Config\Config 
         */
        public function getConfig() {
            return $this->_config;
        }

        /**
         * runs the action 
         */
        protected function RunActions() {
            $this->{$this->_request->getAction()}();
        }

    }

}