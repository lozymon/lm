<?php

namespace lm {

    /**
     * Description of AccessKey
     *
     * @author lozymon
     */
    class AccessKey {

        /**
         * @var \Application\Config\Config 
         */
        private $_config;

        /**
         * @var AccessKey\Salt 
         */
        private $_salt;

        /**
         *
         * @param AccessKey\Key $key
         * @param \Application\Config\Config $config 
         */
        public function __construct(AccessKey\Salt $salt, \Application\Config\Config $config) {
            $this->_config = $config;
            $this->_salt = $salt;
            if (!$this->p_validateSalt($salt))
                throw new AccessKey\Exception\InvalideKeyException();
        }

        /**
         * gets access key to access functions
         * @param string $pass
         */
        public function getAccassKey() {
            $key = new AccessKey\Key();
            $k = $key->getKey();
            echo $k;
            $kk = new AccessKey\Key($k);
            print_r($kk->data);
            
        }

        private function p_validateSalt(AccessKey\Salt $salt) {
            $configSalt = new AccessKey\Salt(sha1(md5($this->_config->getAccessSalt())));
            return $salt->compareObjects($configSalt);
        }

    }

}