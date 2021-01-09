<?php
/**
 * @package    plg_system_feedgator_plus
 *
 * @author     oleg <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Plugin\CMSPlugin;

/**
 * Plg_system_feedgator_plus plugin.
 *
 * @package   plg_system_feedgator_plus
 * @since     1.0.0
 */
class plgSystemPlg_system_feedgator_plus extends CMSPlugin
{
    /**
     * @var array доступ к плагину с IP
     * @since 3.9
     */
    private $_IpArr = [ '178.209.70.115' ];

    /**
     * Текущий IP адрес пользователя
     * @var mixed
     * @since 3.9
     */
    private $ClientIp;

	/**
	 * Application object
	 *
	 * @var    CMSApplication
	 * @since  1.0.0
	 */
	protected $app;

	/**
	 * Database object
	 *
	 * @var    JDatabaseDriver
	 * @since  1.0.0
	 */
	protected $db;





	/**
	 * Affects constructor behavior. If true, language files will be loaded automatically.
	 *
	 * @var    boolean
	 * @since  1.0.0
	 */
	protected $autoloadLanguage = true;

    /**
     * plgSystemPlg_system_feedgator_plus constructor.
     */
    public function __construct( $subject, $config = array() )
    {
        parent::__construct( $subject, $config );
        $this->app = $app = Factory::getApplication();

        $this->ClientIp = $_SERVER['REMOTE_ADDR'];
        if (!defined('USER_IP'))  define('USER_IP',  $this->ClientIp );
        if (!defined('USER_IP_ARR'))  define('USER_IP_ARR',  $this->_IpArr );
    }


    /**
	 * onAfterInitialise.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onAfterInitialise()
	{

	}

	/**
	 * onAfterRoute.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onAfterRoute()
	{

	}

	/**
	 * onAfterDispatch.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onAfterDispatch()
	{

	}

	/**
	 * onAfterRender.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onAfterRender()
	{
		// Access to plugin parameters
		$sample = $this->params->get('sample', '42');
	}

	/**
	 * onAfterCompileHead.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onAfterCompileHead()
	{

	}

	/**
	 * OnAfterCompress.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onAfterCompress()
	{

	}

	/**
	 * onAfterRespond.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onAfterRespond()
	{

	}







}
