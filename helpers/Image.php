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
     * @date       09.01.2021 17:52
     * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later;
     ******************************************************************************************************************/

    namespace plgSysFeedgator;
    defined('_JEXEC') or die; // No direct access to this file

    use Exception;
    use JDatabaseDriver;
    use Joomla\CMS\Application\CMSApplication;
    use Joomla\CMS\Factory;
    use Joomla\CMS\Filesystem\File;
    use Joomla\CMS\Filesystem\Folder;
    use Joomla\Registry\Registry;

    /**
     * Class Image
     *
     * @package PlgSysFeedgator
     * @since   3.9
     * @auhtor  Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date    09.01.2021 17:52
     *
     */
    class Image
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
         * @var Image
         * @since  1.6
         */
        public static $instance;
        /**
         * @var array|object параметры плагина
         * @since 3.9
         */
        private $params;

        /**
         * Image constructor.
         *
         * @param $params array|object
         *
         * @throws Exception
         * @since 3.9
         */
        public function __construct($params)
        {
            \JLoader::registerNamespace('GNZ11',JPATH_LIBRARIES.'/GNZ11',$reset=false,$prepend=false,$type='psr4');

            $this->app = Factory::getApplication();
            $this->db = Factory::getDbo();
            $this->params = $params ;
            return $this;
        }

        /**
         * @param array $options
         *
         * @return Image
         * @throws Exception
         * @since 3.9
         */
        public static function instance($options = array()): Image
        {
            if( self::$instance === null )
            {
                self::$instance = new self($options);
            }
            return self::$instance;
        }


        /**
         *
         * @param $row
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   10.01.2021 10:51
         *
         */
        public function saveImage( $row ){

            $saveDir = JPATH_ROOT. $this->params->get('dir_img_save' , '/images/Lenta'  ) ;

            

            require_once JPATH_ADMINISTRATOR . '/components/com_content/models/article.php';
            $Article = new \ContentModelArticle();
             # Текущее время в формате Sql
            $now = (new \Joomla\CMS\Date\Date())->toSql();




            
            
            $ItemContent = $Article->getItem( $row->id );


//            $ItemContent->articletext = '';
            

            


            # Поиск ссылки в html intro
            $Data = $this->_fetchNodes( 'intro' ,   $ItemContent->introtext );
            if( isset( $Data ['src']) )
            {
                # Загрузить  изображение и сохранить в директории
                $filePath = self::loadImage( $Data ['src']  , $saveDir );
                $filePath = str_replace( JPATH_ROOT.'/' , '' ,  $filePath ) ;
                $ItemContent->images['image_intro'] = $filePath ;
                $ItemContent->images['image_intro_alt'] = $Data['alt'] ;
                $ItemContent->introtext = $Data['text'] ;
            }#END IF

            # Поиск ссылки в html intro
            $Data = $this->_fetchNodes( 'fulltext' ,   $ItemContent->fulltext );
            if( isset( $Data ['src']) )
            {
                # Загрузить  изображение и сохранить в директории
                $filePath = self::loadImage( $Data ['src']  , $saveDir );
                $filePath = str_replace( JPATH_ROOT.'/' , '' ,  $filePath ) ;
                $ItemContent->images['image_fulltext'] = $filePath ;
                $ItemContent->images['image_fulltext_alt'] = $Data['alt'] ;
            }#END IF

//            $row = $this->_del($row);



            $ItemContent->attribs->article_layout = 'gorod:news' ;
            $ItemContent->attribs = json_encode( $ItemContent->attribs ) ;
            $ItemContent->images = json_encode( $ItemContent->images ) ;
            $ItemContent->urls = json_encode( $ItemContent->urls );
            $ItemContent->attribs = json_encode( $ItemContent->attribs  );
            $ItemContent->metadata = json_encode( $ItemContent->metadata  );
//            $ItemContent->tags = json_encode( $ItemContent->tags  );

            unset( $ItemContent->articletext ) ;
            unset( $ItemContent->Array ) ;

            $this->_save(  $ItemContent );














//            echo'<pre>';print_r( $ItemContent );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
//            die(__FILE__ .' '. __LINE__ );

            






           /* echo'<pre>';print_r( $ItemContent );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
            die(__FILE__ .' '. __LINE__ );*/



//            $ItemContent->fulltext = str_replace(  $ItemContent->fulltext , '' , $Data['text']) ;


//            return $ItemContent ;


            /*$Registry = new \Joomla\Registry\Registry( $ItemContent )  ;
            $ItemContentArr = $Registry->toArray();

            # Параметры json_encode
            $ItemContentArr['images'] = json_encode( $ItemContentArr['images'] ) ;
            $ItemContentArr['urls'] = json_encode( $ItemContentArr['urls'] );
            $ItemContentArr['attribs'] = json_encode( $ItemContentArr['attribs'] );
            $ItemContentArr['metadata'] = json_encode( $ItemContentArr['metadata'] );
            $ItemContentArr['tags'] = json_encode( $ItemContentArr['tags'] );*/














        }

        public function _save($object){
            $table = '#__content';
            $Query = $this->db->getQuery(true);
            $Query->select('*')->from($table)->where('id = 796'  );
            $this->db->setQuery($Query);

            $res = $this->db->loadAssocList();

            $attribs = json_decode( $res[0]['attribs'] ) ;
            $attribs->article_layout = 'gorod:news' ;


//            echo'<pre>';print_r( $attribs );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
//            die(__FILE__ .' '. __LINE__ );



            $object = new \Joomla\Registry\Registry($object) ;
            $object = $object->toObject();
            $object->attribs = json_encode( $attribs ) ;

//            echo'<pre>';print_r( $object->attribs );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
//            die(__FILE__ .' '. __LINE__ );



            $table = '#__content';
            $key = 'id' ;
            $this->db->updateObject($table, $object, $key, $nulls = false) ;
        }

        public function _del($row){
            $Article = new \ContentModelArticle();

            $ItemContent = $Article->delete( $row->id );
            return $ItemContent ;
        }

        /**
         * Поиск ссылки в html
         * @param $context
         * @param $Content
         *
         * @return array
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   10.01.2021 10:53
         *
         */
        private function _fetchNodes($context   , &$Content ){
            $dom = new \GNZ11\Document\Dom();

            $dom->loadHTML( $Content ) ;
            $xpath       = new \DOMXPath( $dom );

            $selector = 'img' ;
            $XPath = new \GNZ11\Document\Dom\Translator(   $selector );
            $Nodes = $xpath->query( $XPath );




            foreach ( $Nodes as $i => $node)
            {
                if( !$i )
                {
                    $data[ 'src' ] = trim( $node->getAttribute('src') ) ;
                    $data['alt'] = trim( $node->getAttribute('alt') ) ;
                    # Удалить тег <img />
                    $node->parentNode->removeChild($node);
                }#END IF


            }#END FOREACH

            $Content =   trim( $dom->saveHTML() ) ;
            $data['text'] = $Content ;

//            echo'<pre>';print_r( $data );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
//            echo'<pre>';print_r( $Content );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
//            echo'<pre>';print_r( $Nodes );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
//            die(__FILE__ .' '. __LINE__ );

            return $data ;
        }

        /**
         * Загрузить  изображение и сохранить в директории
         * @param $src
         * @param $saveDir
         *
         * @return string
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   09.01.2021 20:08
         *
         */
        public static function loadImage( $src , $saveDir ){

            $newNameFile = trim( basename( $src ) , '?#') ;
            $filePath = $saveDir . '/' . $newNameFile  ;

            # Проверить что директория существует
            if( !Folder::exists( $saveDir ) ) Folder::create( $saveDir ); #END IF




            $ch = curl_init();
            $timeout = 0;
            curl_setopt ($ch, CURLOPT_URL, $src);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            // Getting binary data
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);

            $image = curl_exec($ch);
            curl_close($ch);

            // output to browser
//            header("Content-type: image/jpeg");

            $f = fopen( $filePath , 'w');
            fwrite($f, $image);
            fclose($f);

            return $filePath ;

        }

    }