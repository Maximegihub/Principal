<?php
namespace Phox_Host\Elementor\Functions;

if ( ! defined( 'ABSPATH' ) ) {
    exit; //Exit if assessed directly
}

/**
 * Domain
 *
 * @package Phox
 * @author WHMCSdes
 * @link https://whmcsdes.com
 * @since 1.5.8
 */
class Domain_Class {
	/**
	 * Instance .
	 *
	 * @var Domain_Class
	 */
	protected static $_instance = null;

    /**
     * Rules for domain parser
     */
    private $rules ;

	/**
	 * @var object the Domain after parsed
	 */
	private $domain_check;

	/**
	 * Get Domain_Class instance .
	 *
	 * @return Domain_Class
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_nopriv_wdes_ajax_search_domain', [$this, 'ajax_search_domain']);
		add_action( 'wp_ajax_wdes_ajax_search_domain', [$this, 'ajax_search_domain']);
		add_action( 'wp_ajax_nopriv_wdes_ajax_search_domain_m', [$this, 'ajax_search_domain_multi_tlds']);
		add_action( 'wp_ajax_wdes_ajax_search_domain_m', [$this, 'ajax_search_domain_multi_tlds']);
		add_action( 'wp_ajax_nopriv_wdes_domain_whois', [$this, 'domain_whois']);
		add_action( 'wp_ajax_wdes_domain_whois', [$this, 'domain_whois']);
		add_action( 'wp_head', [$this, 'domain_js_file']);
		add_action( 'wdes_domain_verify_code', [$this, 'verify_code']);

		//load php-domain-parser
        $this->load_parser_lib();

	}

	/**
	 * Admin ajax for domain.
	 */
	function domain_js_file() {
		echo '<script>
            /*<![CDATA[*/
            var wdes_ajax_url = "' . admin_url( 'admin-ajax.php' ) . '";
            /*]]>*/
          </script>';
	}

	/**
	 * Connect from whois server.
	 *
	 * @param string $domain the full domain that will checking.
	 *
	 * @return mixed|string
	 */
	public function get_whois_server( $domain ) {

		$tld = $domain->getPublicSuffix();
		$character_index = substr($tld,0,1);
		$whois_file = $this->load_whois_file($character_index);

		$response_server = '';

		if($whois_file){

			$whois_file_array = json_decode($whois_file, true);

			$custom_whois_server = apply_filters('whois_server ', [], 10, 1);

			$whois_file_array = array_merge($whois_file_array, $custom_whois_server);

			$response_server = (isset( $whois_file_array[$tld] )) ? $whois_file_array[$tld] : '';

		}

		if( empty( $response_server )  ) {

			$server_ip = gethostbyname( 'whois.iana.org' );

			$fp = stream_socket_client( $server_ip . ':43', $errno, $errstr, 300 );
			if ( ! $fp ) {

				echo "$errstr ($errno)<br />\n";

			} else {

				fputs( $fp, $domain . "\r\n" );

				$response_text = '';

				while ( ! feof( $fp ) ) {
					$response_text .= fgets( $fp, 128 );
				}

				fclose($fp);

				$response_server = '';

				if ( strpos( $response_text, 'but this server does not have' ) == 0 ) {
					if ( strpos( $domain, 'earth' ) == true ) {
						return $response_server = 'whois.nimzo98.com';
					}

					$split_whois = explode( 'whois: ', $response_text );

					$split_status = explode( 'status:', $split_whois[1] );

					$response_server = preg_replace( '/\s+/', '', $split_status[0] );

				}

			}
		}
		return $response_server;
	}

	/**
	 * Check if domain is available.
	 *
	 * @param $whois_server
	 * @param $domain
	 *
	 * @return array|string
	 */
	public function check_available( $whois_server, $domain, $full_text ) {

		$not_found_message = '';

		if(is_array($whois_server)){

			$server = $whois_server[0];
			$not_found_message = $whois_server[1];

		}else{

			$server = $whois_server;

		}

		if ( $server && $domain ) {

			$server_ip = gethostbyname($server);

			$fp = stream_socket_client( $server_ip.':43', $errno, $errstr, 30 );
			if ( ! $fp ) {
				echo "$errstr ($errno)<br />\n";
			} else {
				fputs( $fp, $domain . "\r\n" );
				$response = '';

				while ( ! feof( $fp ) ) {
					$response .= fgets( $fp, 128 );

				}

				fclose($fp);

				if( $full_text ){
					return $response;
				}

				if( ! empty($not_found_message)  ){

					if ( ! is_int( strpos( $response, $not_found_message ) )  ) {
						$result = true;
					} else {
						$result = false;
					}


				}else{
					//Fix for work with country extension
					$lowercase_response = strtolower($response);

					if ( is_int( strpos( $lowercase_response, 'domain name:' ) )  ) {
						$result = true;
					} else {
						$result = false;
					}
				}

				return array(
					'status' => $result,
				);
			}
		} else {
			return array(
				'status' => false,
			);
		}

	}

	/**
	 * Get the domain result by ajax.
	 */
	public function ajax_search_domain() {

		if( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'check-domain-nonce' ) ){
			wp_send_json(
				['status' => 'error', 'results_html' => '<span class="wdes-btn-token">'.esc_html__("Error on token", 'phox-host').'</span>']);
		}

		$lookup_provider_id = $_POST['lupid'];

		if( empty( $lookup_provider_id ) || ! in_array( $lookup_provider_id ,['lup-1', 'lup-2']) ){
			wp_send_json(
				['status' => 'error', 'results_html' => '<span class="wdes-btn-token">'.esc_html__("Error on LookUp Provider", 'phox-host').'</span>']);
		}


		$domain     = sanitize_text_field ($_POST['domain']);

		$this->domain_check = $this->rules->resolve($domain);

		if( $lookup_provider_id === 'lup-2' ){

			$output = $this->godaddy_provider();

		}else{

			$output = $this->internal_provider();

		}


		wp_send_json( $output );

	}

	/**
	 * Standard Lookup
	 *
	 * @since 1.7.9
	 * @return array|bool[]|string
	 */
	private function internal_provider(){

		if( $this->domain_check->isICANN() ){

			$whios_server = $this->get_whois_server( $this->domain_check );

			$domain = $this->domain_check->getRegistrableDomain();

		}else{

			$whios_server = '';

		}

		if ( empty( $whios_server ) ) {

			$output = array(
				'status'       => 'no_support',
				'domain'       => $domain,
				'results_html' => esc_html__( 'Please check the domain name or extension', 'phox-host' ),
				'message' => $domain
			);

		} else {

			$whois_server = $whios_server;
			$output       = $this->check_available( $whois_server, $domain, false );

			$output['status'] = ( $output['status'] ) ? 'taken' : 'available';
			$output['domain'] = $domain;

			// result html.
			if ( $output['status'] === 'available' ) {
				$output['message'] = apply_filters('wdes_dc_available_message',esc_html__('Congratulation!', 'phox-host') .'<b> '. $domain .'</b> '. esc_html__('is available!', 'phox-host'));
				$output['results_html']     = '<input type="hidden" name="select-domain" placeholder="'.esc_attr__('eg. example.com', 'phox-host').'" autocapitalize="none" value="' . $domain . '">';
				$output['results_html'] .= '<input type="submit" class="wdes-purchase-btn" target="_blank" value="'.esc_attr__('Purchase', 'phox-host').'">';
				$output['results_html'] .= '<span class="fas fa-shopping-cart wdes-available-dom"></span>';

			} else {
				$output['message'] = apply_filters('wdes_dc_taken_message', esc_html__('Sorry!', 'phox-host') .' <b>'. $domain .' </b>'. esc_html__('is already taken!', 'phox-host'));
				if( $_POST['settings']['whois_button'] === 'yes' ){
					$output['results_html'] = ' <button class="wdes-btn-token"type="button" id="wdesDomainWhoisBtn"><span class="fas fa-exclamation-circle icon-taken"></span>' . esc_html__( 'Whois', 'phox-host' ) . '</button>';
					$output['results_html'] .= wp_nonce_field('check-domain-whois-nonce', 'security-whois', true, false);
				}
			}
		}
		return $output;
	}

	/**
	 * GoDaddy Lookup
	 *
	 * @since 1.7.9
	 * @return array
	 */
	private function godaddy_provider(){

		$api_key = wdes_opts_get( 'godaddy_api_key', '' );
		$api_secret = wdes_opts_get( 'godaddy_api_secret', '' );

		$domain = $this->domain_check->getRegistrableDomain();

		if( empty( $api_key ) || empty( $api_secret ) ){

			return [
				'status'       => 'error_api_key_secret',
				'domain'       => $domain,
				'results_html' => esc_html__( 'Try again later', 'phox-host' ),
				'message' => $domain
			];

		}
		$server = 'https://api.godaddy.com/v1/domains/available';
		$data_arg = [
			'body' => [
				'domain' => '',
				'checkType' => 'FAST',
				'forTransfer' => 'false'
			],
			'headers' => [
				'Content-Type' => 'application/json',
				'Authorization' => ''
			]
		];

		$data_arg['body']['domain'] = $domain;
		$data_arg['headers']['Authorization'] = 'sso-key '.$api_key.':'.$api_secret;

		$request = wp_remote_get($server,$data_arg);

		$response_code = wp_remote_retrieve_response_code($request);

		$response_json = json_decode(wp_remote_retrieve_body($request));

		if($response_code == 200) {

			$output['status'] = ( ! $response_json->available ) ? 'taken' : 'available';
			$output['domain'] = $response_json->domain;

			// result html.
			if ( $output['status'] === 'available' ) {

				$output['message'] = apply_filters('wdes_dc_available_message',esc_html__('Congratulation!', 'phox-host') .'<b> '. $domain .'</b> '. esc_html__('is available!', 'phox-host'));
				$output['results_html']     .= '<input type="hidden" name="select-domain" placeholder="'.esc_attr__('eg. example.com', 'phox-host').'" autocapitalize="none" value="' . $domain . '">';
				$output['results_html'] .= '<input type="submit" class="wdes-purchase-btn" target="_blank" value="'.esc_attr__('Purchase', 'phox-host').'">';
				$output['results_html'] .= '<span class="fas fa-shopping-cart wdes-available-dom"></span>';

			} else {
				$output['message'] = apply_filters('wdes_dc_taken_message', esc_html__('Sorry!', 'phox-host') .' <b>'. $domain .' </b>'. esc_html__('is already taken!', 'phox-host'));
			}

		}elseif($response_code == 422){

			$output = array(
				'status'       => 'no_support',
				'domain'       => $domain,
				'results_html' => esc_html__( 'Please check the domain name or extension', 'phox-host' ),
				'message' => $domain
			);

		}else{

			$output = [
				'status'       => $response_json->code,
				'domain'       => $domain,
				'results_html' => $response_json->code,
				'message' => $response_json->message
			];

		}

		return $output;
	}

	/**
	 * Get the domain whois.
	 *
	 * @return  string $response_server
	 */
	public function domain_whois(){
		if(! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'check-domain-whois-nonce' ) ){
			wp_send_json(
				['whois' => esc_html__("Error on token", 'phox-host')]);
		}

		$domain     = sanitize_text_field ( $_POST['domain'] );

		$domain_check = $this->rules->resolve($domain);

		$whios_server = $this->get_whois_server( $domain_check );

		$response_server ['whois']= $this->check_available( $whios_server, $domain, true );

		return wp_send_json($response_server);
	}

	/**
	 * Get the domain Tlds result by ajax.
	 */
	public function ajax_search_domain_multi_tlds(){

		if(! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'check-domain-nonce' ) ){
			wp_send_json(
				['whois' => esc_html__("Error on token", 'phox-host')]);
		}

		$lookup_provider_id = $_POST['lupid'];

		if( empty( $lookup_provider_id ) || ! in_array( $lookup_provider_id ,['lup-1', 'lup-2']) ){
			wp_send_json(
				['status' => 'error', 'results_html' => '<span class="wdes-btn-token">'.esc_html__("Error on LookUp Provider", 'phox-host').'</span>']);
		}

		$response = ['result' => 'error'];

		$tlds = ( !empty($_POST['tlds']) ) ? $_POST['tlds'] : false;

		$domain = ( ! empty($_POST['domain']) ) ? sanitize_text_field($_POST['domain']) : false ;

		$sld = ( ! empty($_POST['sld']) ) ? sanitize_text_field($_POST['sld']) : false ;

		if( is_string( $domain ) && is_array( $tlds ) ){

			$domain_parse = $this->rules->resolve($domain);

			$split_tld_form_domain = explode($sld, $domain_parse->getRegistrableDomain());
			if( ! isset( $split_tld_form_domain[1] ) ){
				exit();
			}

			if( $domain_parse->isICANN() ){

				$filter_domain_tld = array_filter($tlds, function( $tld )use( $domain_parse ){
					return $tld !== $domain_parse->getPublicSuffix();
				});

				if( ! empty ( $filter_domain_tld ) ){

					$response ['result'] = 'success';

					foreach ( $filter_domain_tld as $tld_item ){

						$single_domain = $sld . '.' . $tld_item;

						$this->domain_check = $this->rules->resolve($single_domain);

						if( $lookup_provider_id === 'lup-2' ){

							$single_domain_status = $this->godaddy_provider();

						}else{

							$single_domain_status = $this->internal_provider();

						}

						$response['data'][$tld_item] = $single_domain_status;

						$this->domain_check = '';
					}

				}

			}

		}else{
			exit();
		}

		wp_send_json( $response );
	}

	/**
	 * Verify code
	 */
	public function verify_code() {

		echo '<input type="hidden" name="token" value="0811bf819565bf8142cc613d099e85a27ec1204c">';

	}

    /**
     * Load 'php-domain-parser' library files
     *
     * @see https://github.com/jeremykendall/php-domain-parser/tree/5.7.2
     * @throws \Exception
     */
	private function load_parser_lib(){

        $files = ['PublicSuffixListSection', 'Rules', 'IDNAConverterTrait', 'DomainInterface', 'PublicSuffix', 'Domain', 'Converter'];
        $path = Phox_HOST_PATH.'includes/elementor/libs/domain/php-domain-parser/';

        foreach ($files as $file){
            $file_path = $path.$file.'.php';
            if(file_exists($file_path)){
                require_once $file_path;
            }else{
                throw new \Exception('There are missing file from php-domain-parser');
            }
        }

        $this->rules = \Pdp\Rules::createFromPath($path.'data/public_suffix_list.dat');

    }

	/**
	 * Load Whois file
	 *
	 * @param string $file_name
	 *
	 * @return string $whois_file
	 */
	public function load_whois_file($file_name){
		$file_dir = plugin_dir_path( __FILE__ ).'whois/'.$file_name.'.json';
		$file_dir_open = fopen($file_dir,'r');
		$whois_file = fread($file_dir_open, filesize($file_dir));
		fclose($file_dir_open);

		return $whois_file;
	}



}
