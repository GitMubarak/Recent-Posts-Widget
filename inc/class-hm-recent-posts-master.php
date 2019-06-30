<?php
/**
 * HM Recent Posts: main plugin class
*/
class HMRPW_Master {

	protected $hmrpw_loader;
	protected $hmrpw_version;
	
	/**
	 * Class Constructor
	*/
	public function __construct() {
		$this->hmrpw_version = HMRPW_VERSION;
		$this->hmrpw_load_dependencies();
		$this->hmrpw_trigger_widget_hooks();
	}
	
	/**
	 * Loading Dependencies likes included, required fies 
	 * and their objects
	*/
	private function hmrpw_load_dependencies() {

		require_once HMRPW_PATH . 'widget/' . HMRPW_CLASSPREFIX . 'widget-activater.php';
	}
	
	/**
	 * Calling the widget section widget child class
	*/
	private function hmrpw_trigger_widget_hooks() {

		new HmRecentPostsWidgetActivater();
		add_action( 'widgets_init', function(){ register_widget( 'HmRecentPostsWidgetActivater' ); });
	}
	
	/**
	 * Controlling the version
	*/
	public function hmrpw_version() {
		return $this->hmrpw_version;
	}
}
