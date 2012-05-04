<?php

namespace lm {

    /**
     * Description of ServiceController
     *
     * @author lozymon
     */
    class ServiceController extends \lm\Controller {

        public function __construct() {
            parent::__construct();
        }

        /**
         * gets access key to access functions
         * @param string $pass
         */
        public function getAccassKeyAction($key) {
            $accessKey = new AccessKey(new AccessKey\Salt($key), $this->getConfig());
            return $accessKey->getAccassKey();
        }

        protected function RunActions() {
            $classMethod = new \ReflectionMethod($this, $this->getRequest()->getAction());
            $argumentCount = $classMethod->getNumberOfRequiredParameters();

            if ($argumentCount > count($this->getRequest()->getParams())) {
                throw new ServiceController\Exception\MissingRequiredArgumentException(
                        'Required argument\'s are ' . $argumentCount .
                        ', argument given is ' . count($this->getRequest()->getParams()));
            }

            $return = call_user_func_array(
                    array(
                $this, // class to run
                $this->getRequest()->getAction() // function in class
                    ), $this->getRequest()->getParams()); // input params

            echo $return;
        }

        /**
         * set document header
         * @param lm\ServiceController\Header $header 
         */
        public function setHeader($header) {
            switch ($header) {
                case \lm\ServiceController\Header::JSON :
                    header('Content-type: application/json');
                    break;

                case \lm\ServiceController\Header::XML:
                    header("Content-type: text/xml; charset=utf-8");
                    break;

                case \lm\ServiceController\Header::NONE:
                default:
                    break;
            }
        }

    }

}