<?php

/**
 * This is particularly helpful if some parts of the form are enabled depending
 * on a value of a selected input.
 */
class ManipleForms_Form_TriggeredForm extends Zefram_Form2
{
    /**
     * @var Zend_Form
     */
    protected $_parentForm;

    /**
     * @var string
     */
    protected $_triggerName;

    /**
     * @var mixed
     */
    protected $_triggerValue;

    public function __construct(Zend_Form $parentForm, $triggerName = null, $triggerValue = null, array $options = null)
    {
        parent::__construct($options);

        if ($this->_triggerName === null) {
            if ($triggerName === null) {
                throw new InvalidArgumentException("Trigger element's name must not be empty");
            }
            $this->_triggerName = (string) $triggerName;
        }

        if ($this->_triggerValue === null) {
            if ($triggerValue === null) {
                throw new InvalidArgumentException("Trigger element's value must not be empty");
            }
            $this->_triggerValue = $triggerValue;
        }

        $this->_parentForm = $parentForm;
    }

    /**
     * A helper method for checking if two variables can be considered as having
     * the same value.
     *
     * Identity equality cannot be used, because we want to be able to recognize
     * values even if they are not properly type-filtered when retrieved from the
     * for element. E.g. we want '1' to be equal to 1, but not want '' to be
     * equal to null or 0, so standard equality operator (==) cannot be used here.
     *
     * @param mixed $a
     * @param mixed $b
     * @return bool
     */
    public static function areEqual($a, $b)
    {
        // identity equality (===) is too strong here, on the other hand equality
        // (==) uses PHP coercion rules which may lead to undesired results, e.g.:
        //     0 == null
        //     false == null
        //     0 == '0'
        //     0 == 'a'
        //     0 == ''
        if (is_string($a) || is_string($b)) {
            return (string) $a === (string) $b;
        }
        return $a === $b;
    }

    public function isTriggered()
    {
        $isTriggered = self::areEqual($this->getTriggerElement()->getValue(), $this->_triggerValue);
        return $isTriggered;
    }

    public function getTriggerName()
    {
        return $this->_triggerName;
    }

    public function getTriggerValue()
    {
        return $this->_triggerValue;
    }

    /**
     * @return Zend_Form_Element
     */
    public function getTriggerElement()
    {
        $element = $this->_parentForm->getElement($this->_triggerName);
        return $element;
    }

    public function getValues($suppressArrayNotation = false)
    {
        if ($this->isTriggered()) {
            return parent::getValues($suppressArrayNotation);
        }
        return array();
    }

    public function getValue($name)
    {
        if ($this->isTriggered()) {
            return parent::getValue($name);
        }
        return null;
    }

    public function isValid($data)
    {
        if ($this->isTriggered()) {
            return parent::isValid($data);
        }
        return true;
    }

    public function getUnfilteredValue($name)
    {
        if ($this->isTriggered()) {
            return parent::getUnfilteredValue($name);
        }
        return null;
    }

    public function getUnfilteredValues()
    {
        if ($this->isTriggered()) {
            return parent::getUnfilteredValues();
        }
        return array();
    }

    public function isValidPartial(array $data = null)
    {
        if ($this->isTriggered()) {
            return parent::isValidPartial($data);
        }
        return true;
    }
}
