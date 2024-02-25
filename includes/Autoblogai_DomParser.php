<?php

class Autoblogai_DomParser
{
    function get_first_img_src($html) {
        // Create a new DOMDocument object.
        $dom = new DOMDocument();

        // Suppress libxml errors (due to malformed HTML inputs).
        libxml_use_internal_errors(true);

        // Load the HTML content.
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

        // Clear the errors.
        libxml_clear_errors();

        // Create a new XPath object.
        $xpath = new DOMXPath($dom);

        // Query the first img tag.
        $img = $xpath->query('//img[1]');

        // Check if the img tag exists.
        if($img->length > 0) {
            $imgElement = $img->item(0);

            // Get the value of the src attribute.
            return $imgElement->getAttribute('src');
        }

        return null;
    }

}
