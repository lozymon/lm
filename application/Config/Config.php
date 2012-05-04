<?php

namespace Application\Config {

    /**
     * Description of config
     *
     * @author lozymon
     */
    class Config {
        /* error */

        private $display_errors = true;
        private $log_errors = false;
        private $debug = false;

        /* Folders */
        private $library_folder = 'library';
        private $application_folder = 'application';
        private $controller_folder = 'Controllers';
        private $model_folder = 'Models';
        private $def_controller = 'Service';
        private $def_action = 'demo';

        /* DB */
        private $DB_host = 'localhost';
        private $DB_user = 'root';
        private $DB_pass = '';
        private $DB_table = 'demo';
        
        private $_access_salt = 'DnOma)WwtQF5}sh5o{"[KNkt!au>x"ma)WwtQF5}sh5o{"[KNk';
        private $_access_key_valide_time = 120; // secends

        public function __get($name) {
            return $this->{$name};
        }

        public function getAccessSalt() {
            return $this->_access_salt;
        }
        /**
         *  return the path to controllers folder
         * @return string 
         */
        public function getControllerPath($controller = null) {
            if ($controller == null)
                return $this->application_folder . DIRECTORY_SEPARATOR . $this->controller_folder;
            return $this->application_folder . DIRECTORY_SEPARATOR . $this->controller_folder . DIRECTORY_SEPARATOR . $controller;
        }

        /**
         * returns the path you want to add to the include path
         * @return array
         */
        public function getIncludePath() {
            return array(
                $this->library_folder,
                $this->application_folder . DIRECTORY_SEPARATOR . "..",
            );
        }

        /**
         * gets the application root path
         * @return string
         */
        public function getRootPath() {
            return realpath(realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
        }

    }

}