<?php
namespace Phox_Host\Builder;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use Elementor\Core\Base\Document;

class Footer_Document extends Document {

    public function get_name() {
        return 'wdes_footer';
    }

    public static function get_title() {
        return __( 'Footer', 'phox-host' );
    }

}