<?php
Wind::import('APPS:windid.api.OpenBaseController');
Wind::import('LIB:utility.PwMail');
/**
 * the last known user to change this file in the repository  <$LastChangedBy: Peter.yan $>
 * @author $Author: Peter.yan $ 215169718@qq.com
 * @copyright ?2003-2103 fenxiangyo.com
 * @license http://www.fenxiangyo.com
 * @package
 */
class OpenManageController extends OpenBaseController
{

    public function doReportAction()
    {
        $reportId = $this->getInput("reportid");

        $postData = print_r($_POST,true);
        $requestData = print_r($_REQUEST,true);

        $content = "Post:<br/>".$postData."<br/>".$requestData;

        $mail = new PwMail();
        $result = $mail->sendMail('android@fenxiangyo.com', "点餐哟客户端:".$reportId, $content);
        if ($result instanceof PwError) {
            $result = false;
        }
        else
            $result = true;

        $this->output($result);

    }
}

?>