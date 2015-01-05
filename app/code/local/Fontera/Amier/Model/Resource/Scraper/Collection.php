<?php


class Fontera_Amier_Model_Resource_Scraper_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * Init collection and determine table names
     *
     */
    protected function _construct()
    {

        parent::_construct();
        $this->_init(
            'fontera_amier/scraper',
            'fontera_amier/scraper'
        );

    }


}
