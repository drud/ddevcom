<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
/**
 * Description of Search
 *
 * @author mark
 */
class HunchSchema_Search extends HunchSchema_Thing {

    public $schemaType = "SearchResultsPage";
    
    public function getResource($pretty = false) {
        $this->schema = array(
            '@context' => 'http://schema.org/',
            '@type' => $this->schemaType,
        );
        
        return $this->toJson( $this->schema, $pretty );
    }
}
