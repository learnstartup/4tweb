<?php
defined('WEKIT_VERSION') or exit(403);

Wind::import('EXT:4tschool.service.promo.dm.App_Promo_Dm');

class Promotions
{
    public function getPromo($name)
    {
        if(empty($name))
        {
            $name ='Base';
        }
        $promo = 'Promo' . $name;

        return new $promo($promotion);
    }

    /**
     * @return App_Promo
     */
    public function _getPromoDs()
    {
        return Wekit::load('EXT:4tschool.service.promo.App_Promo');
    }


}

class PromoBase
{
    /**
     * @return App_Promo
     */
    protected function _getPromoDs()
    {
        return Wekit::load('EXT:4tschool.service.promo.App_Promo');
    }

    public function cancel($spid)
    {
        $dm = new App_Shop_Promo_Dm();
        $dm->setIsActive(0);

        //mark as not active
        $this->_getPromoDs()->UpdateShopPromo($spid,$dm);

    }

}

class PromoDiscount extends PromoBase
{
    private $price;
    private $discount;

    public function get_promo_price($price, $discount)
    {
        $this->price = $price;
        $this->discount = $discount;
        $this->verify();

        $discountedPrice = $this->price * $this->discount;
        if ($discountedPrice>$this->price) {
            $discountedPrice=$this->price;
        }
        return $discountedPrice;
    }


    private function verify()
    {
        $regex = '/^(([0-9]+[\.]?[0-9]+)|[1-9])$/';
        if (!preg_match($regex, $this->price)) {
            throw new Exception('Invalid price, the discount must be a positive number.');
        }

        if (!preg_match($regex, $this->discount)) {
            throw new Exception('Invalid discount, the discount must be a positive number.');
        }
    }

    //excuted once
    public function add_template()
    {
        $element1 = 'M'; //merchandise, which will be participate the promotions
        $elementList = array($element1);

        $templateid = $this->_getPromoDs()->generateTemplateId();
        $templateid = $templateid['templateid'];

        $name = "Discount";
        $isDuplicate = $this->_getPromoDs()->checkDuplicateInfo('name', $name);
        if ($isDuplicate) {
            return;
        }
        foreach ($elementList as $key => $value) {
            $dm = new App_Promo_Dm();
            $dm->setTemplateId($templateid)
                ->setName($name)
                ->setElement($value)
                ->setCreateDate(Pw::getTime())
                ->setLastUpdateTime(Pw::getTime());

            $this->_getPromoDs()->insertPromoTemplate($dm);
        }
    }
}

Class PromoMeetDeduct extends PromoBase
{
    private $promotion;
    private $totalPrice; //order price
    private $condition; //condition, meet price, trigger promotion
    private $promoMerchandisePrice; // merchandise. which will be participate the promotions.
    private $deduct; //deduct amount
    private $qty; //promo merchandise's quantity
    private $triggerOnce;

    function __construct($promotion)
    {
        $this->promotion = $promotion;
    }

    public function get_promo_price($totalPrice, $promoMerchandisePrice, $qty, $triggerOnce = false)
    {
        $this->totalPrice = $totalPrice;
        $this->promoMerchandisePrice = $promoMerchandisePrice;
        $this->qty = $qty;
        $this->triggerOnce = $triggerOnce;

        foreach ($this->promotion as $item) {
            if ($item['element']=='C') {
                $this->condition =$item;
            }
            elseif($item['element']=='A'){
                $this->deduct = $item;
            }
        }

        if ($this->qty <= 0) {
            throw new Exception('Invalid quantity, the quantity must be more than 0.');
        }

        if ($triggerOnce) {
            return $this->trigger_once();
        }

        return $this->trigger_all();
    }

    private function trigger_once()
    {
        $promoPrice = $this->promoMerchandisePrice;
        if ($this->totalPrice >= $this->condition['value']) {
            $promoPrice = $this->promoMerchandisePrice - $this->deduct['value'];
        }
        return $promoPrice;
    }

    private function trigger_all()
    {
        if ($this->qty == 1) {
            return $this->trigger_once();
        }

        $promoPtrice = $this->promoMerchandisePrice * $this->qty;
        $triggerTimes = floor($this->totalPrice / $this->condition['value']);
        if ($triggerTimes > $this->qty) {
            $triggerTimes = $this->qty;
        }
        for ($i = 0; $i < $triggerTimes; $i++) {
            $promoPtrice -= $this->deduct['value'];
        }
        return $promoPtrice;
    }

    //excuted once
    public function add_template()
    {
        $element1 = 'M'; //merchandise. which will be participate the promotions.
        $element2 = 'C'; //const. it's a condition, meet price, trigger promotions.
        $element3 = 'A'; //amount. deduct price.
        $elementList = array($element1, $element2, $element3);

        $templateid = $this->_getPromoDs()->generateTemplateId();
        $templateid = $templateid['templateid'];

        $name = "MeetDeduct";
        $isDuplicate = $this->_getPromoDs()->checkDuplicateInfo('name', $name);
        if ($isDuplicate) {
            return;
        }
        foreach ($elementList as $key => $value) {
            $dm = new App_Promo_Dm();
            $dm->setTemplateId($templateid)
                ->setName($name)
                ->setElement($value)
                ->setCreateDate(Pw::getTime())
                ->setLastUpdateTime(Pw::getTime());

            $this->_getPromoDs()->insertPromoTemplate($dm);
        }
    }
}

?>