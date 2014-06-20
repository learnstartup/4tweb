<?php

defined('WEKIT_VERSION') or exit(403);
/**
 *
 */
class App_Promotionalmanage
{
	public function getAllShopsPromotional($searchCondition, $start, $limit)
    {
        return $this->loadDao()->getAllShopsPromotional($searchCondition, $start, $limit);
    }

    public function getShopPromotionalBySchoolIdShopId($choosenSchoolId, $choosenShopId)
    {
        return $this->loadDao()->getShopPromotionalBySchoolIdShopId($choosenSchoolId, $choosenShopId);
    }

    public function getOneShopsPromotional($id)
    {
        return $this->loadDao()->getOneShopsPromotional($id);
    }

    public function countPromotional($searchCondition)
    {
        return $this->loadDao()->countPromotional($searchCondition);
    }

    public function getPromotionalShops($schoolid)
    {
        return $this->loadDao()->getPromotionalShops($schoolid);
    }

    public function update($id, App_Promotionalmanage_Dm $dm)
    {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadDao()->update($id, $dm->getData());
    }

    public function add(App_Promotionalmanage_Dm $dm)
    {
        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

    /**
     * @return App_Promotionalmanage_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.promotionalmanage.dao.App_Promotionalmanage_Dao');
    }

}

?>