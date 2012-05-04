<?php

namespace lm\Crypt {

    /**
     * Description of ICrypt
     *
     * @author lozymon
     */
    interface ICrypt {

        public function __construct($salt);

        public function encrypt($value);

        public function decrypt($value);
    }

}