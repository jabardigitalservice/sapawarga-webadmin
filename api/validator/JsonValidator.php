<?php

namespace app\validator;

use Yii;
use yii\validators\Validator;

/**
 * Class JsonValidator
 *
 * @author Roman Agilov <agilovr@gmail.com>
 */
class JsonValidator extends Validator
{
    /**
     * @var string User-defined error message used when the value is not a string.
     */
    public $notStringMsg;

    /**
     * @var string User-defined error message used when the value is not a valid JSON string.
     */
    public $invalidJsonMsg;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->notStringMsg === null) {
            $this->notStringMsg = Yii::t('app', 'The value must be a string.');
        }

        if ($this->invalidJsonMsg === null) {
            $this->invalidJsonMsg =
                Yii::t('app', 'The value must be a valid JSON string. {extendedMessage}.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (!is_string($value)) {
            return [$this->notStringMsg, []];
        }

        json_decode($value);

        if (json_last_error()) {
            return [$this->invalidJsonMsg, ['extendedMessage' => json_last_error_msg()]];
        }

        return null;
    }
}
