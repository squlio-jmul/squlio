<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * HTML Page library
 *
 * @package Libraries
 * @author Johan Mulyono <dev.jmulyono@gmail.com>
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

/**
 * Generates pages within the app
 *
 */
class Page extends SQ_Library {

	/**
	 * Acceptable page types
	 *
	 * @var array
	 */
	static public $_validPageTypes = array(
		'default'
	);

	/**
	 * Absolute path to image files
	 *
	 * @var string
	 */
	public $imgPath;

	/**
	 * Absolute path to CSS files
	 *
	 * @var string
	 */
	public $cssPath;

	/**
	 * Absolute path to JavaScript files
	 *
	 * @var string
	 */
	public $jsPath;
	public $minifiedJs;
	public $minifiedCss;

	public $templatePath;

	/**
	 * Title of the page
	 *
	 * @var string
	 */
	protected $_pageTitle;

	public function __construct()
	{
		parent::__construct();

		$this->imgPath = $this->_ci->config->item('static_img');
		$this->cssPath = $this->_ci->config->item('static_css');
		$this->jsPath = $this->_ci->config->item('static_js');

		// set the app version
		$this->minifiedJs = $this->_ci->config->item('minified_js');
		$this->minifiedCss = $this->_ci->config->item('minified_css');
		$this->isProduction = $this->_ci->config->item('is_production');
		$this->debug = $this->_ci->config->item('debug');

		// set the page title
		$this->_pageTitle = $this->_ci->config->item('default_page_title');
	}

	public function show($pageType, $title, $viewPath, $viewData = array(), $pageData = array())
	{
		if ( ! $this->_isValidPageType($pageType))
		{
			$this->logMessage('Invalid page type: ' . $pageType, 'error');
			show_404();
		}

		// build the view
		$data = $this->loadView($viewPath, $viewData, true);

		// merge any page data that was provided
		if ( ! empty($pageData)) {
			$data = array_merge($data, $pageData);
		}

		// initialize the page view data array
		$data['title'] = !empty($title) ? $title  : $this->_pageTitle;

		// pass the app version info to the data array
		$data['js_path'] = $this->jsPath;
		$data['img_path'] = $this->imgPath;
		$data['css_path'] = $this->cssPath;
		$data['minified_js'] = $this->minifiedJs;
		$data['minified_css'] = $this->minifiedCss;
		$data['is_production'] = $this->isProduction;
		$data['debug'] = $this->debug;

		$this->_pageByType($pageType, $data);
	}

	public function getContent($pageType, $title, $viewPath, $viewData = array(), $pageData = array()) {
		if ( ! $this->_isValidPageType($pageType)) {
			$this->logMessage('Invalid page type: ' . $pageType, 'error');
			show_404();
		}

		// build the view
		$data = $this->loadView($viewPath, $viewData, true);

		// merge any page data that was provided
		if ( ! empty($pageData)) {
			$data = array_merge($data, $pageData);
		}

		// initialize the page view data array
		$data['title'] = !empty($title) ? $title . ' - ' . $this->_pageTitle : $this->_pageTitle;

		// pass the app version info to the data array
		$data['js_path'] = $this->jsPath;
		$data['minified_js'] = $this->minifiedJs;
		$data['minified_css'] = $this->minifiedCss;
		$data['is_production'] = $this->isProduction;
		$data['debug'] = $this->debug;

		return $this->_pageByType($pageType, $data, true);
	}


	/**
	 * Render a page that matches the $pageType param
	 *
	 * @param string $pageType
	 * @param array $data
	 */
	private function _pageByType($pageType, $data, $get_content = false)
	{
		if($this->minifiedCss){
			//$data['headerCss'][] = $this->cssPath . '/third_party/bootstrap.css';
		}else{
			$data['headerCss'][] = $this->cssPath . '/third_party/bootstrap.css';
			$data['headerCss'][] = $this->cssPath . '/squlio.css';
		}
		$data['navs'] = array (
			'admin' => array(
			),
			'school_admin' => array(
			)
		);

		if ($get_content) {
			$content = $this->loadView('pages/' . $pageType, $data, true);
			return $content['content'];
		} else {
			$this->loadView('pages/' . $pageType, $data);
		}
	}

	/* helper methods --------------------------------------------------------------------------------- */

	/**
	 * Return a view
	 *
	 * This is an analogue to $this->load->view()
	 *
	 * @param string $view
	 * @param array $data
	 * @return string
	 */
	public function loadView($view, $data = array(), $return = false) {
		$data['js_path'] = $this->jsPath;
		$data['img_path'] = $this->imgPath;
		$data['css_path'] = $this->cssPath;

		// assemble the view path
		$viewPath = $this->_buildViewPath($view);

		// return the actual the content HTML
		if ($return) {
			return array(
				'content' => $this->_ci->load->view($viewPath, $data, true)
			);
		}

		// display the view
		$this->_ci->load->view($viewPath, $data);
	}

	/**
	 * Assembles our view path using the given $renderMode
	 *
	 * @param string $view
	 * @param string $renderMode
	 * @return string
	 */
	private function _buildViewPath($view) {
		// will become our array of view elements
		$elements = array();

		// make sure we have discrete, non-empty components
		foreach (explode('/', $view) as $viewPart)
		{
			if ( ! empty($viewPart) )
			{
				$elements[] = $viewPart;
			}
		}

		// reconstruct the path
		$viewPath = implode('/', $elements);

		return $viewPath;
	}

	/**
	 * Determines if the given $pageType is valid
	 *
	 * @param string $pageType
	 * @return boolean
	 */
	private function _isValidPageType($pageType) {
		return in_array($pageType, self::$_validPageTypes);
	}

}

/* End of file Page.php */
/* Location: ./application/libraries/Page.php */
