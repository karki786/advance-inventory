<?php namespace CodedCell\Presenters;

use CodedCell\Printers\PrinterEntity;

/**
 * Class Supplier
 * @package CodedCell\Presenters
 */
class Printer extends Presenter
{
    protected $entity;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->printer = new PrinterEntity();
    }

    public function isPrinterUp()
    {
        return $this->printer->checkPrinterUp($this->entity->printerIP);
    }

    public function hostName()
    {

        $response = $this->printer->getInfo($this->entity->printerIP, $this->entity->oid[0]->printerHostName);
        if ($response) {
            $response = trim($response);
            return str_replace('"',"", $response);
        }

        return "No response";
    }

    /**
     * Gets Catridge Status
     * @param $color
     * @return string
     */
    public function colorStatus($color)
    {
        $catridgeOid = $color . 'CatridgeOid';
        $catridgeMaxOid = $color . 'CatridgeOidMax';
        $color = $this->printer->getInfo($this->entity->printerIP, $this->entity->oid[0]->$catridgeOid);
        $colorMax = $this->printer->getInfo($this->entity->printerIP, $this->entity->oid[0]->$catridgeMaxOid);
        if (is_numeric($color) and is_numeric($colorMax)) {
            $level = $color / $colorMax;
            return round($level * 100) . "%";
        }
        return "Not able to get " . $color . " status";

    }

    public function catridgeType($color)
    {
        $catridgeType = $color . 'CatridgeType';
        $catridge = $this->printer->getInfo($this->entity->printerIP, $this->entity->oid[0]->$catridgeType);
        if ($catridge) {
            $catridge = str_replace('"', "", $catridge);
            return $catridge;
        } else {
            return "Could not get Catridge";
        }
    }

    public function pagesPrinted()
    {
        $pages = $this->printer->getInfo($this->entity->printerIP, $this->entity->oid[0]->totalPagesPrinted);

        if (is_numeric($pages)) {
            return number_format($pages);
        }
        return "Could not retrieve ";

    }

    public function status()
    {
        $status = $this->printer->getInfo($this->entity->printerIP, $this->entity->oid[0]->statusOid);
        if ($status) {
            return str_replace('"', "", $status);
        }

        return "Cannot retrieve status";
    }


}
