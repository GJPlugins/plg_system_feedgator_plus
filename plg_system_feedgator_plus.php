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

    use Joomla\Registry\Registry;
    use Joomla\CMS\Application\CMSApplication;
    use Joomla\CMS\Plugin\CMSPlugin;
    use Joomla\CMS\Factory;



    JLoader::registerNamespace( 'plgSysFeedgator' , JPATH_PLUGINS . '/system/plg_system_feedgator_plus/helpers' , $reset = false , $prepend = false , $type = 'psr4' );
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
     * Affects constructor behavior.
     * If true, language files will be loaded automatically.
	 *
	 * @var    boolean
	 * @since  1.0.0
	 */
	protected $autoloadLanguage = true;

	#
    #
    # LOCAL VARIABLE
    #
    #

	/**
     * @var bool
     * @since 3.9
     */
    private $FGSaveArticle = false ;

    /**
     * plgSystemPlg_system_feedgator_plus constructor.
     * @since 3.9
     */
    public function __construct( $subject, $config = array() )
    {
        parent::__construct( $subject, $config );
        $this->app = $app = Factory::getApplication();

        $this->ClientIp = $_SERVER['REMOTE_ADDR'];
        if (!defined('USER_IP'))  define('USER_IP',  $this->ClientIp );
        if (!defined('USER_IP_ARR'))  define('USER_IP_ARR',  $this->_IpArr );

        #TODO DEV
        if( !in_array( $this->ClientIp , $this->_IpArr) ) return ; #END IF

        
        
    }

    #
    # ***** ---- System Methods ---- *****
    #

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
	 * onBeforeCompileHead.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onBeforeCompileHead()
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


    #
    # ***** ---- com_content Methods ---- *****
    #

//    public function onContentBeforeSave( string $context , &$row, $isNew){
//	    die(__FILE__ .' '. __LINE__ );
//
//        $helperImage = plgSysFeedgator\Image::instance( $this->params );
//       //
//
//    }

    /**
     *
     * @param string $context
     * @param        $row
     * @param        $isNew
     *
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   09.01.2021 16:55
     *
     */
    public function onContentAfterSave(string $context , &$row , $isNew){

        if( !$isNew ) return ; #END IF
        if( !$this->FGSaveArticle ) return true ; #END IF
        $helperImage = plgSysFeedgator\Image::instance( $this->params );
        $helperImage->saveImage( $row );



//        $this->FGSaveArticle = false ;



    }

    /**
     * Displays the voting area when viewing an article and the voting section is displayed after the article
     *
     * @param string    $context The context of the content being passed to the plugin
     * @param object   &$row     The article object
     * @param object   &$params  The article params
     * @param           $offset
     *
     * @return  string|boolean  HTML string containing code for the votes if in com_content else boolean false
     *
     * @since   3.7.0
     */
    public function onContentAfterDisplay(string $context , &$row , &$params , $offset)
    {
    }

    /**
     * TRIGGER 'onContentPrepare'
     *
     * @param string                       $context The context of the content being passed to the plugin.
     * @param object                      &$row     The article object.  Note $article->text is also available
     * @param Joomla\Registry\Registry    &$params  The article params
     * @param integer                      $page    The 'page' number
     *
     * @return  void
     *
     * @throws Exception
     * @since   1.6
     */
    public function onContentPrepare(string $context, &$row, &$params, $page = 0)
    {
    }


    #
    # ***** ---- com_fields Methods ---- *****
    # onCustomFieldsBeforePrepareField
    # onCustomFieldsPrepareField
    # onCustomFieldsAfterPrepareField
    # onCustomFieldsPrepareDom
    # onCustomFieldsGetTypes
    #

    /**
     * com_fields Событие позволяет плагинам изменять вывод поля до его подготовки
     *
     * @param $context
     * @param $item
     * @param $field
     *
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   01.01.2021 19:30
     *
     */
    public function onCustomFieldsBeforePrepareField($context, $item, &$field){

    }

    /**
     * com_fields Сбор значения для поля
     * Gathering the value for the field
     *
     * @param $context
     * @param $item
     * @param $field
     *
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   04.01.2021 13:52
     */
    public function onCustomFieldsPrepareField($context , $item , &$field)
    {

    }

    /**
     * com_fields Событие позволяет плагинам изменять вывод подготовленного поля
     *            Event allow plugins to modify the output of the prepared field
     * FRONT
     *
     * @param $context
     * @param $item
     * @param $field
     * @param $value
     *
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   01.01.2021 19:30
     *
     */
    public function onCustomFieldsAfterPrepareField($context, $item, $field, &$value){

    }

    /**
     * com_fields событие, чтобы создать узел поля dom
     * @param $obj
     * @param $node
     * @param $context
     *
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   04.01.2021 13:55
     *
     */
    public function onCustomFieldsPrepareDom($obj, $node , $context){

    }

    /**
     * Возвращает типы настраиваемых полей. ( ADMIN )
     * Returns the custom fields types.
     *
     * Возвращенный массив содержит массивы со следующими ключами:
     * The returned array contains arrays with the following keys:
     * - label: The label of the field
     * - type:  The type of the field
     * - path:  The path of the folder where the field can be found
     *
     * @return  void | string[][]
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   04.01.2021 14:03
     *
     */
    public static function onCustomFieldsGetTypes()
    {
    }



    #
    # ***** ---- JForm Methods ---- *****
    # onContentPrepareForm
    # onContentPrepareData
    # onUserBeforeDataValidation
    #

    /**
     * JForm События подготовки формы.
     * Добавить поле title h1 h2  в форму создания категории или товара
     * @param $form
     * @param $data
     *
     * @return bool|void
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   18.12.2020 20:28
     *
     */
    public function  onContentPrepareForm ( $form ,  $data )
    {

    }

    /**
     * JForm Запуск события подготовки данных.
     * @param string $context
     * @param $data
     *
     * @return bool
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   04.01.2021 14:21
     *
     */
    public function onContentPrepareData( $context, &$data )
    {
        return true ;
    }

    /**
     * JForm Перед Валидацией формы
     *
     * NB. Хотя это событие начинается с пользователя, оно вводит в заблуждение - оно применяется ко всем
     * действиям и переименовано в лучшее имя onContentValidateData в Joomla 4.0
     *
     * @param JForm $form Форма для проверки.
     * @param array $data Данные для проверки.
     *
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   04.01.2021 14:36
     */
    public function onUserBeforeDataValidation(JForm $form , array &$data)
    {
    }

    #
    # ***** ---- com_feedgator Method ---- *****
    #
    public function onBeforeFGSaveArticle( &$content, $fgParams ){
        $this->FGSaveArticle = true ;



    }
    public function onAfterFGSaveArticle( $content, $fgParams ){


    }



    #
    # ***** ---- com_Ajax Method ---- *****
    #
    /**
     * onAjax Точка входа
     * @since  3.9
     * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date   05.12.2020 06:09
     *
     */
    public function onAjaxPlg_system_feedgator_plus(){

    }


    #
    # ***** ---- Local Methods ---- *****
    #

    private function editImageContent(){

    }

}








