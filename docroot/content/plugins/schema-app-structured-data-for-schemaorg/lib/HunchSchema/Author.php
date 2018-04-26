<?php

defined('ABSPATH') OR die('This script cannot be accessed directly.');

/**
 * Description of Author Page
 *
 * @author mark
 */
class HunchSchema_Author extends HunchSchema_Thing {

    public $schemaType = "ProfilePage";

    public function __construct() {
        
    }

    public function getResource($pretty = false) {
        $this->schema = array
            (
            '@context' => 'http://schema.org/',
            '@type' => $this->schemaType,
            'headline' => sprintf('About %s', get_the_author()),
            'datePublished' => get_the_date('Y-m-d'),
            'dateModified' => get_the_modified_date('Y-m-d'),
            'about' => $this->getAuthor(),
        );

        return $this->toJson( $this->schema, $pretty );
    }

}
