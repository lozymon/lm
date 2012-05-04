<?php

namespace lm\AccessKey {

    use lm\Crypt;

    /**
     * Description of Key
     *
     * @author lozymon
     */
    class Key {

        private $_inputKeyData;
        private $_config;

        /**
         * @var lm\Crypt 
         */
        private $_crypt;

        public function __construct($key = null) {
            $this->_config = new \Application\Config\Config();
            $this->_inputKeyData = $this->p_getData($key);
        }

        public function __get($name) {
            if (isset($this->_inputKeyData[$name]))
                return $this->_inputKeyData[$name];
        }

        public function getKey($data = array()) {
            if (is_null($data)) {
                // access data
                $data = array(
                    'date' => getdate()
                );
            }

            return $this->getCrypt()->encrypt(json_encode($data));
        }

        public function compareObjects(Salt &$SaltObject) {
            return ($this == $SaltObject);
        }

        private function p_getData($key) {
            $data = $this->getCrypt()->decrypt($key);
            return json_decode($data, true);
        }

        private function getCrypt() {
            if ($this->_crypt == null)
                $this->_crypt = new Crypt($this->_config->getAccessSalt());
            return $this->_crypt;
        }

    }

}