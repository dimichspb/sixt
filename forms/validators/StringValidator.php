<?php
namespace app\forms\validators;

use app\entities\base\BaseEntity;

class StringValidator extends \yii\validators\StringValidator
{
    /**
     * @param $value
     * @return array|null
     * @throws \yii\base\NotSupportedException
     */
    protected function validateValue($value)
    {
        if ($value instanceof BaseEntity) {
            $value = $value->getValue();
        }
        return parent::validateValue($value);
    }

    /**
     * @param $model
     * @param $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;

        if ($value instanceof BaseEntity) {
            $value = $value->getValue();
        }

        if (!is_string($value)) {
            $this->addError($model, $attribute, $this->message);

            return;
        }

        $length = mb_strlen($value, $this->encoding);

        if ($this->min !== null && $length < $this->min) {
            $this->addError($model, $attribute, $this->tooShort, ['min' => $this->min]);
        }
        if ($this->max !== null && $length > $this->max) {
            $this->addError($model, $attribute, $this->tooLong, ['max' => $this->max]);
        }
        if ($this->length !== null && $length !== $this->length) {
            $this->addError($model, $attribute, $this->notEqual, ['length' => $this->length]);
        }
    }
}