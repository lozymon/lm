<?php

namespace Application\Controllers {

    /**
     * Description of test
     *
     * @author lozymon
     */
    class Service extends \lm\ServiceController {

        public function indexAction() {
        }

        public function demoAction() {
            $this->setHeader(\lm\ServiceController\Header::XML);
            
            // demo data
            $data = array(
                'col1' => 'value 1',
                'col2' => 'value 2',
                'col3' => 'value 3');
            $data = array($data, $data, $data);

            return \lm\ArrayToXML::toXmlAttributs($data);
        }

    }

}