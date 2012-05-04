<?php

namespace lm {

    /**
     * Description of ArrayToXML
     *
     * @author lozymon
     */
    class ArrayToXML {

        /**
         * The main function for converting to an XML document.
         * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
         *
         * @param array $data
         * @param string $rootNodeName - what you want the root node to be - defaultsto data.
         * @param SimpleXMLElement $xml - should only be used recursively
         * @param int $version - version of the xml
         * @return string XML
         */
        public static function toXml($data, $rootNodeName = 'data', $xml = null, $version = 0) {
            // turn off compatibility mode as simple xml throws a wobbly if you don't.
            if (ini_get('zend.ze1_compatibility_mode') == 1) {
                ini_set('zend.ze1_compatibility_mode', 0);
            }

            if ($xml == null) {
                $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
                $xml->addChild("count", count($data));
                $xml->addChild("version", $version[0]);
            }

            // loop through the data passed in.
            foreach ($data as $key => $value) {
                // no numeric keys in our xml please!
                if (is_numeric($key)) {
                    // make string key...
                    //$key = "unknownNode_". (string) $key;
                    $key = "item"; //. (string) $key;
                }

                // replace anything not alpha numeric
                $key = preg_replace('/[^a-z]/i', '', $key);

                // if there is another array found recrusively call this function
                if (is_array($value)) {
                    $node = $xml->addChild($key);
                    // recrusive call.
                    lm_ArrayToXML::toXml($value, $rootNodeName, $node);
                } else {
                    // add single node.
                    $value = htmlentities($value, ENT_QUOTES | ENT_IGNORE, "UTF-8");
                    $xml->addChild($key, $value);
                }
            }
            // pass back as string. or simple xml object if you want!
            return $xml->asXML();
        }

        public static function toXmlAttributs(array $data, $rootNodeName = 'DATA', $version = null) {
            // turn off compatibility mode as simple xml throws a wobbly if you don't.
            if (ini_get('zend.ze1_compatibility_mode') == 1) {
                ini_set('zend.ze1_compatibility_mode', 0);
            }

            $xmlDoc = new \DOMDocument();

            // create the root element
            $root = $xmlDoc->appendChild(
                    $xmlDoc->createElement(strtoupper($rootNodeName)));

            if ($version != null) {
                // adds the count element
                $countNode = $root->appendChild($xmlDoc->createElement("COUNT"));
                $countNode->appendChild($xmlDoc->createAttribute('VALUE'))->appendChild($xmlDoc->createTextNode(count($data)));

                // adds the version element
                $versionNode = $root->appendChild($xmlDoc->createElement("VERSION"));
                $versionNode->appendChild($xmlDoc->createAttribute('VALUE'))->appendChild($xmlDoc->createTextNode($version));
            }

            // loop through the data passed in.
            foreach ($data as $key => $arr) {
                // no numeric keys in our xml please!
                if (is_numeric($key)) {
                    $key = "item";
                }
                // replace anything not alpha numeric
                $key = strtoupper(preg_replace('/[^a-z]/i', '', $key));

                $itemNode = $root->appendChild($xmlDoc->createElement($key));
                foreach ($arr as $key => $value) {
                    $itemNode->appendChild(
                            $xmlDoc->createAttribute(strtoupper($key)))->appendChild(
                            $xmlDoc->createTextNode($value));
                }
            }
            // pass back as string. or simple xml object if you want!
            return $xmlDoc->saveXML();
        }

    }

}