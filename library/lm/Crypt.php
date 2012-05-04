<?php

namespace lm {

    use lm\Crypt\ICrypt;

    /**
     * Description of Crypt
     *
     * @author lozymon
     */
    class Crypt implements ICrypt {

        /**
         * @var string crypt key
         */
        private $_salt;

        /**
         * @var type 
         */
        private $_algo;

        /**
         * 
         * @param string $salt crypt key 
         */
        public function __construct($salt, $algo = MCRYPT_BLOWFISH) {
            $this->_salt = substr($salt, 0, mcrypt_get_key_size($algo, MCRYPT_MODE_ECB));
            $this->_algo = $algo;
        }

        /**
         * 
         * @param string $data
         * @return false | encrypted value 
         */
        public function Encrypt($data) {
            if (!$data) {
                return false;
            }

            $iv_size = mcrypt_get_iv_size($this->_algo, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

            $crypt = mcrypt_encrypt($this->_algo, $this->_salt, $data, MCRYPT_MODE_ECB, $iv);
            return trim(base64_encode($crypt));
        }

        /**
         *
         * @param string $data
         * @return false | decrypted value 
         */
        public function Decrypt($data) {
            if (!$data) {
                return false;
            }

            $crypt = base64_decode($data);

            $iv_size = mcrypt_get_iv_size($this->_algo, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

            $decrypt = mcrypt_decrypt($this->_algo, $this->_salt, $crypt, MCRYPT_MODE_ECB, $iv);
            return trim($decrypt);
        }

    }

}