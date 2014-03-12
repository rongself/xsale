<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-4
 * Time: 下午5:31
 */

namespace Application\Model;


class ProductTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getProduct($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveProduct(Products $product)
    {
        $data = array(
            'artist' => $product->artist,
            'title'  => $product->title,
        );

        $id = (int) $product->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getProduct($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Album id does not exist');
            }
        }
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

} 