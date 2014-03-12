<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-4
 * Time: 下午4:48
 */

namespace Application\Model;


class Product {
    public $sku;
    public $name;
    public $cost;
    public $price;
    public $description;
    public $picture;
    public $stock;
    public $remark;
    public $createDate;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
    }
} 