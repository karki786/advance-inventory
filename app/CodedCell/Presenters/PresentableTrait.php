<?php namespace CodedCell\Presenters;

use CodedCell\Presenters\Exceptions\PresenterException;

/**
 * Class PresentableTrait
 * @package CodedCell\Presenters
 */
trait PresentableTrait
{
    protected $presenterInstance;

    /**
     * @return mixed
     * @throws PresenterException
     */
    public function present()
    {
        if (!$this->presenter or !class_exists($this->presenter)) {
            throw new PresenterException('Please set the $protected property to your presenter path');
        }

        if (!$this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }
        return $this->presenterInstance;
    }

    public function getPresenter()
    {
        return $this->presenter;
    }

    public function getPresenterMethods()
    {
        return get_class_methods($this->presenter);
    }
}
