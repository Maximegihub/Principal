<?php
namespace Phox_Host\Builder;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Core\Base\Document;

class Header_Document extends Document {

    public function get_name()
    {
        return 'wdes_header';
    }

    public static function get_title()
    {
        return __('Header', 'phox-host');
    }

}
