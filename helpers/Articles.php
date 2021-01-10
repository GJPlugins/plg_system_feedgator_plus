<?php

    /*******************************************************************************************************************
     *     ╔═══╗ ╔══╗ ╔═══╗ ╔════╗ ╔═══╗ ╔══╗        ╔══╗  ╔═══╗ ╔╗╔╗ ╔═══╗ ╔╗   ╔══╗ ╔═══╗ ╔╗  ╔╗ ╔═══╗ ╔╗ ╔╗ ╔════╗
     *     ║╔══╝ ║╔╗║ ║╔═╗║ ╚═╗╔═╝ ║╔══╝ ║╔═╝        ║╔╗╚╗ ║╔══╝ ║║║║ ║╔══╝ ║║   ║╔╗║ ║╔═╗║ ║║  ║║ ║╔══╝ ║╚═╝║ ╚═╗╔═╝
     *     ║║╔═╗ ║╚╝║ ║╚═╝║   ║║   ║╚══╗ ║╚═╗        ║║╚╗║ ║╚══╗ ║║║║ ║╚══╗ ║║   ║║║║ ║╚═╝║ ║╚╗╔╝║ ║╚══╗ ║╔╗ ║   ║║
     *     ║║╚╗║ ║╔╗║ ║╔╗╔╝   ║║   ║╔══╝ ╚═╗║        ║║─║║ ║╔══╝ ║╚╝║ ║╔══╝ ║║   ║║║║ ║╔══╝ ║╔╗╔╗║ ║╔══╝ ║║╚╗║   ║║
     *     ║╚═╝║ ║║║║ ║║║║    ║║   ║╚══╗ ╔═╝║        ║╚═╝║ ║╚══╗ ╚╗╔╝ ║╚══╗ ║╚═╗ ║╚╝║ ║║    ║║╚╝║║ ║╚══╗ ║║ ║║   ║║
     *     ╚═══╝ ╚╝╚╝ ╚╝╚╝    ╚╝   ╚═══╝ ╚══╝        ╚═══╝ ╚═══╝  ╚╝  ╚═══╝ ╚══╝ ╚══╝ ╚╝    ╚╝  ╚╝ ╚═══╝ ╚╝ ╚╝   ╚╝
     *------------------------------------------------------------------------------------------------------------------
     *
     * @author     Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date       06.01.2021 21:25
     * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later;
     ******************************************************************************************************************/

    namespace plgSysFeedgator;
    defined('_JEXEC') or die; // No direct access to this file

    use Exception;
    use JDatabaseDriver;
    use Joomla\CMS\Application\CMSApplication;
    use Joomla\CMS\Factory;
    use Joomla\CMS\MVC\Controller\BaseController;

    /**
     * Class Articles работа с компонентом COM_CONTENT
     *
     * @package plgMettagHelpers
     * @since   3.9
     * @auhtor  Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date    06.01.2021 21:25
     *
     */
    class Articles
    {
        /**
         * @var CMSApplication|null
         * @since 3.9
         */
        private $app;
        /**
         * @var JDatabaseDriver|null
         * @since 3.9
         */
        private $db;
        /**
         * Array to hold the object instances
         *
         * @var Articles
         * @since  1.6
         */
        public static $instance;

        /**
         * Articles constructor.
         *
         * @param $params array|object
         *
         * @throws Exception
         * @since 3.9
         */
        public function __construct($params)
        {
            $this->app = Factory::getApplication();
            $this->db = Factory::getDbo();
            return $this;
        }

        /**
         * @param array $options
         *
         * @return Articles
         * @throws Exception
         * @since 3.9
         */
        public static function instance($options = array())
        {
            if( self::$instance === null )
            {
                self::$instance = new self($options);
            }
            return self::$instance;
        }

        /**
         * Получить список материалов по массиву ID
         *
         * @param array|int $ids
         *
         * @return mixed
         * @throws Exception
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.01.2021 21:47
         * @see https://stackoverflow.com/a/37605938/6665363
         */
        public function getArticles(  $ids )
        {
            $ids = is_array($ids) ? $ids : [$ids];

            $jContent = BaseController::getInstance('Content');
            $jArticles = $jContent->getModel('Articles');
            $jArticles->getState();
            $jArticles->setState('filter.article_id' , $ids);
            $jArticles->setState('list.limit' , count($ids));
//            $jArticles->setState('filter.published' , 1);
            return $jArticles->getItems();
        }

    }




























