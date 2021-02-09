<?php namespace CodedCell\Presenters;

class Department extends Presenter
{
    protected $entity;

    /**
     * @return string
     */
    public function budgetLimit()
    {
        return number_format($this->entity->budgetLimit, 2, ".", ",");
    }

    /**
     * @return string
     */
    public function dispatchSum()
    {
        return number_format($this->entity->dispatches->sum('totalCost'), 2, ".", ",");
    }

    /**
     * @return string
     */
    public function dispatchCount()
    {
        return number_format($this->entity->dispatches->sum('amount'), 2, ".", ",");
    }

    /**
     * @return mixed
     */
    public function budgetStartDate()
    {
        if ($this->entity->budgetStartDate != null) {
            return $this->entity->budgetStartDate;
        }
        return "-";
    }

    /**
     * @return mixed
     */
    public function budgetEndDate()
    {
        if ($this->entity->budgetEndDate != null) {
            return $this->entity->budgetEndDate;
        }
        return "-";
    }

    /**
     * @return string
     */
    public function percentage()
    {
        if ($this->entity->dispatchsum > 0) {
            $val = ($this->entity->dispatchsum / $this->entity->budgetLimit) * 100;
        } else {
            return "100%";
        }
        if ($val > 100) {
            return "100%";
        } else {
            return $val . "%";
        }
    }
}
