<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Push - 数据服务接口
 */
class App_Push
{

    /**
     * 取得数据
     */
    public function getSearchPushData($searchCondition, $start, $limit)
    {
        return $this->loadDao()->getSearchPushData($searchCondition, $start, $limit);
    }

    /**
     * 计算数据的数量
     */
    public function countPush($searchCondition)
    {
        return $this->loadDao()->countPush($searchCondition);
    }

    /**
     * 根据表主id, 取出一条数据
     */
    public function getOnePushById($id)
    {
        return $this->loadDao()->getOnePushById($id);
    }

    /**
     * add record
     *
     * @param App_Push_Dm $dm
     * @return multitype:|Ambigous <boolean, number, string, rowCount>
     */
    public function add(App_Push_Dm $dm)
    {

        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

    /**
     * get record
     *
     * @param $id
     * @return one record
     */
    public function get($id){
        return $this->loadDao()->get($id);
    }

    /**
     * update record
     *
     * @param App_Push_Dm $dm
     * @return multitype:|Ambigous <boolean, number, rowCount>
     */
    public function update($id, App_Push_Dm $dm)
    {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadDao()->update($id, $dm->getData());
    }

    /**
     * @return App_Push_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.push.dao.App_Push_Dao');
    }
}