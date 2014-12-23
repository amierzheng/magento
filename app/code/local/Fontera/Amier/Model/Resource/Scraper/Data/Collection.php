<?php


class Fontera_Amier_Model_Resource_Scraper_Data_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{

    /**
     * Init collection and determine table names
     *
     */
    protected function _construct()
    {
        $this->_init('scraper/data');

    }


}
