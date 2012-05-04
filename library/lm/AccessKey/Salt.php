<?php

namespace lm\AccessKey {

    /**
     * Description of Key
     *
     * @author lozymon
     */
    class Salt {

        private $_salt;

        public function __construct($salt) {
            $this->_salt = $salt;
        }
        
        private function p_valideSalt() {
            sha1(md5($this->_access_key));
        }

        public function compareObjects(Salt &$SaltObject) {
            return ($this == $SaltObject);
        }

        public function __toString() {
            return $this->_salt;
        }

    }

}