<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_shop - 数据服务接口
 */
class App_Shopstatusrecord
{

    public function getAllShopStatusRecord($searchCondition, $start, $limit)
    {
        return $this->loadDao()->getAllShopStatusRecord($searchCondition, $start, $limit);
    }

    public function countAllShopStatusRecord($searchCondition)
    {
        return $this->loadDao()->countAllShopStatusRecord($searchCondition);
    }


    /**
     * @return App_Shopstatusrecord_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shopstatusrecord.dao.App_Shopstatusrecord_Dao');
    }

    /**
     * add record
     *
     * @param App_Shopstatusrecord_Dm $dm
     * @return multitype:|Ambigous <boolean, number, string, rowCount>
     */
    public function add(App_Shopstatusrecord_Dm $dm)
    {

        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

    /**
     * update record
     *
     * @param App_Shopstatusrecord_Dm $dm
     * @return multitype:|Ambigous <boolean, number, rowCount>
     */
    public function update($id, App_Shopstatusrecord_Dm $dm)
    {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadDao()->update($id, $dm->getData());
    }

}


?>    