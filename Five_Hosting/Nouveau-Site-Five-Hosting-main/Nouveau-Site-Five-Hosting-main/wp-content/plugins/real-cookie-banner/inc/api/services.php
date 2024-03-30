<?php

use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
if (!\function_exists('wp_rcb_service_groups')) {
    /**
     * Get a list of all existing service groups.
     *
     * @since 2.3.0
     */
    function wp_rcb_service_groups() {
        return \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getOrdered();
    }
}
if (!\function_exists('wp_rcb_services_by_group')) {
    /**
     * Get a list of all existing services within a group.
     *
     * Example: Get all available service groups and services
     *
     * <code>
     * <?php
     * if (function_exists('wp_rcb_service_groups')) {
     *     foreach (wp_rcb_service_groups() as $group) {
     *         foreach (wp_rcb_services_by_group($group->term_id) as $service) {
     *             printf(
     *                 'Group: %s, Service: %s Service-ID: %d<br />',
     *                 $group->name,
     *                 $service->post_title,
     *                 $service->ID
     *             );
     *         }
     *     }
     * }
     * </code>
     *
     * @param int $group_id The `term_id` of the group
     * @param string|string[] $post_status Pass `null` to read all existing
     * @since 2.3.0
     */
    function wp_rcb_services_by_group($group_id, $post_status = null) {
        $query = [
            'post_type' => \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
            'orderby' => ['menu_order' => 'ASC', 'ID' => 'DESC'],
            'numberposts' => -1,
            'nopaging' => \true
        ];
        if ($post_status !== null) {
            $query['post_status'] = $post_status;
        }
        return \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getOrdered(
            $group_id,
            \false,
            \get_posts(\DevOwl\RealCookieBanner\Core::getInstance()->queryArguments($query, 'wp_rcb_services_by_group'))
        );
    }
}
