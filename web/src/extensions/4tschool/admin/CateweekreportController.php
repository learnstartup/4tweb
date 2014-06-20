<?php
Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.cateweekreport.dm.App_Cate_Week_Report_Dm');

class CateweekreportController extends T4AdminBaseController
{
  private $pageNumber = 10;
	public function run() 
	{
        $this->_setNavType('cateweekreport');
        $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
        $allSchool = array_values($allSchool);  
        $cateTypeClass = $this->setCateTypeCommonClass();

        $this->setOutput($allSchool, 'allSchool');
        $this->setOutput($cateTypeClass, 'cateTypeClass');        

        $choosenSchoolId = -1;
        $typename = -1;
        $audited = -1;
        $released = -1;
        if ($this->getInput('type', 'post') === 'do') 
        {
          list($choosenSchoolId, 
               $typename,
               $audited,
               $released) = $this->getInput(array('choosenSchoolId',
                                                  'typename', 
                                                  'audited',
                                                  'released'), 'post');
        }

        $page = $this->getInput('page');

        $searchCondition = array('choosenSchoolId' => $choosenSchoolId, 
                                 'typename' => $typename, 
                                 'audited' => $audited, 
                                 'released' => $released);
        $count =  $this->_getCateWeekReportDs()->countCateWeek($searchCondition); 
        if (0 < $count) 
        {
          $totalPage = ceil($count/$this->pageNumber);
          $page > $totalPage && $page = $totalPage;
          list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

          if($page <= 0)
            $page =1;
        }
        $cateWeekReportList = $this->_getCateWeekReportDs()->getSearchCateWeekData($searchCondition, $start, $limit);
        $cateWeekReportList = array_values($cateWeekReportList);

        $this->setOutput($searchCondition, 'searchCondition');
        $this->setOutput($cateWeekReportList, 'cateWeekReportList');
        $this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($this->pageNumber, 'perPage'); 
	}

	public function addAction()
    {
        if ($this->getInput('type', 'post') === 'do') {

            list($choosenSchoolId, 
                 $title, 
                 $cateType,
                 $link,
                 $content,
                 $contactInfo,
                 $isAudited, 
                 $isReleased) = $this->getInput(array('choosenSchoolId',
                                                      'title', 
                                                      'cateType',
                                                      'link',
                                                      'content',
                                                      'contactInfo',
                                                      'isAudited',
                                                      'isReleased'), 'post');
            if (empty($title)) {
                $this->showError('请输入周报标题.');
                return;
            }
            if (empty($cateType)) {
                $this->showError('请选择周报类型.');
                return;
            }
            if (empty($contactInfo)) {
                $this->showError('请输入联系方式.');
                return;
            }

            $dm = new App_Cate_Week_Report_Dm();
			
            $dm->setSchoolId($choosenSchoolId)
               ->setCateType($cateType)
               ->setTitle($title)
               ->setLink($link)
               ->setContent($content)
               ->setCreator($this->adminUser->username)
               ->setContactInfo($contactInfo)
               ->setIsAudited($isAudited)
               ->setIsReleased($isReleased)
               ->setCreateDate(date('Y-m-d H:i:s'))
               ->setAuditDate(date('Y-m-d H:i:s'))
               ->setReleaseDate(date('Y-m-d H:i:s'));

            $id=$this->_getCateWeekReportDs()->add($dm);

            if ($id > 0) {
                $this->showMessage('添加成功');
            } else {
                $this->showError('更新失败,请联系管理员');
            }            
        } else {
            $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
            $allSchool = array_values($allSchool);
            $this->setOutput($allSchool, 'allSchool');

            $choosenSchoolid = $this->getInput('choosenSchoolid');
            if (!isset($choosenSchoolid) || $choosenSchoolid <= 0) {
                $choosenSchoolid = $allSchool[0]['schoolid'];
            }
            $cateTypeClass = $this->setCateTypeCommonClass();
            
            $this->setOutput($cateTypeClass, 'cateTypeClass');
            $this->setOutput($choosenSchoolid, 'choosenSchoolid');
        }
    }

    public function editAction()
    {
        if ($this->getInput('type', 'post') === 'do') {

            list($choosenSchoolId, 
                 $title, 
                 $cateType,
                 $link,
                 $content,
                 $contactInfo,
                 $isAudited, 
                 $isReleased) = $this->getInput(array('choosenSchoolId',
                                                      'title', 
                                                      'cateType',
                                                      'link',
                                                      'content',
                                                      'contactInfo',
                                                      'isAudited',
                                                      'isReleased'), 'post');
            if (empty($title)) {
                $this->showError('请输入周报标题.');
                return;
            }
            if (empty($cateType)) {
                $this->showError('请选择周报类型.');
                return;
            }
            if (empty($contactInfo)) {
                $this->showError('请输入联系方式.');
                return;
            }

            $dm = new App_Cate_Week_Report_Dm();
			
            $dm->setSchoolId($choosenSchoolId)
               ->setCateType($cateType)
               ->setTitle($title)
               ->setLink($link)
               ->setContent($content)
               ->setCreator($this->adminUser->username)
               ->setContactInfo($contactInfo)
               ->setIsAudited($isAudited)
               ->setIsReleased($isReleased)
               ->setCreateDate(date('Y-m-d H:i:s'))
               ->setAuditDate(date('Y-m-d H:i:s'))
               ->setReleaseDate(date('Y-m-d H:i:s'));

            $id = $this->getInput('id');
            $id=$this->_getCateWeekReportDs()->update($id, $dm);

            if ($id == 1) {
                $this->showMessage('更新成功');
            } else {
                $this->showError('更新失败,请联系管理员');
            }            
        } else {
        	$id = $this->getInput('id');
        	$cateWeekReportList = $this->_getCateWeekReportDs()->getCateWeekReportById($id);
          $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
          $allSchool = array_values($allSchool);
          $cateTypeClass = $this->setCateTypeCommonClass();

          $this->setOutput($allSchool, 'allSchool');
          $this->setOutput($cateTypeClass, 'cateTypeClass');
          $this->setOutput($cateWeekReportList, 'cateWeekReportList');
        }
    }

    public function imguploadAction()
    {
        $cateWeekReportId = $this->getInput('cid');
        $imageUrl = $this->getInput('url');
        $this->setOutput($cateWeekReportId, 'cateWeekReportId');
        $this->setOutput($imageUrl, 'imageUrl');

        if ($this->getInput('type', 'post') === 'do' && is_uploaded_file($_FILES["uploadimg"]["tmp_name"])) {
            list($cateWeekReportId, $imageUrl) = $this->getInput(array('cid', 'breviaryphoto'), 'post');

            if (empty($cateWeekReportId)) {
                $this->showError("未知的错误,请联系管理员");
            }

            $file = $_FILES["uploadimg"];

            //check the uploaded file whether it is a image.
            $ext = strtolower(substr(strrchr($file['name'], '.'), 1));
            if (!$this->isImage($ext)) {
                $this->showError("文件格式不正确!");
            }

            //build dir
            $image_path = '/uploaded_images/cate_week/' . $cateWeekReportId . '/';
            $destination_folder = dirname(dirname(__FILE__)) . $image_path;

            if (!file_exists($destination_folder)) {
                mkdir($destination_folder);
            }

            $imgName = 'cateweekreport_' . $cateWeekReportId . '.' . $ext;
            $destination = $destination_folder . $imgName;

            //if the image of current merchandise already exists, change the exists one to history.
            if (file_exists($destination)) {

                $imgHistory = $destination_folder . 'cateweekreport_' . $cateWeekReportId . "_" . "hist" . "_" . time() . "." . $ext;
                rename($destination, $imgHistory);
            }

            //save image and stroage url to db.
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $url = $image_path . $imgName;
                if ($this->saveUrl($cateWeekReportId, $url)) {
                    $this->showMessage("上传成功！");
                }
            }
        }
    }

    public function isImage($ext)
    {
        return in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'swf'));
    }

    public function saveUrl($cateWeekReportId, $url)
    {
        $dm = new App_Cate_Week_Report_Dm();
        $dm->setBreviaryphoto($url);
        $result = $this->_getCateWeekReportDs()->update($cateWeekReportId, $dm);

        return $result;
    }

    public function setCateTypeCommonClass()
    {
        return $cateTypeCommonClass = array("美食文章", "美食周报");
    }

    public function previewAction()
    {
      $id = $this->getInput('id');
      $cateweekreport = $this->_getCateWeekReportDs()->get($id);
      $cateweekreport['breviaryphoto'] = 'src/extensions/4tschool'. str_replace('\\', '/', $cateweekreport['breviaryphoto']);
      $this->setOutput($cateweekreport,'cateweekreport');
    }

	/**
     * @return App_Cate_Week_Report
     */
    private function _getCateWeekReportDs()
    {
        return Wekit::load('EXT:4tschool.service.cateweekreport.App_CateWeekReport');
    }

    private function _get4TSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

}