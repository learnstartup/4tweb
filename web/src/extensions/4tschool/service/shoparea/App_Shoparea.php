<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_shop - 数据服务接口
 */
class App_Shoparea
{

    public function getShopAreaByShopId($shopId)
    {
        return $this->loadDao()->getShopAreaByShopId($shopId);
    }

    public function checkShopIfExist($schoolId, $shopId)
    {
        return $this->loadDao()->checkShopIfExist($schoolId, $shopId);
    }

    public function deleteShopAreaById($id)
    {
        return $this->loadDao()->deleteShopAreaById($id);
    }

    /**
     * @return App_Shopstatusrecord_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.shoparea.dao.App_Shoparea_Dao');
    }

    /**
     * add record
     *
     * @param App_Shopstatusrecord_Dm $dm
     * @return multitype:|Ambigous <boolean, number, string, rowCount>
     */
    public function add(App_Shoparea_Dm $dm)
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
    public function update($id, App_Shoparea_Dm $dm)
    {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadDao()->update($id, $dm->getData());
    }

}


?>    