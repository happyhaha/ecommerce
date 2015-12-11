<?php

namespace Ibec\Ecommerce\Database;

use Validator;

trait MiscTrait
{
    protected $rules = [];
    protected $errors;
    public $hasErrors = false;

    public function validate($data)
    {
        $this->hasErrors = false;

        // make a new validator object
        $v = Validator::make($data, $this->rules);

        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors;
            $this->hasErrors = true;
            return false;
        }

        // validation pass
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    /**
     * Список хинтов (подсказок) для вывода под полями в форме
     * где ключ это имя аттрибута, а значение это текст подсказки
     *
     * @return array
     */
    public static function attributeHints()
    {
        return [];
    }

    /**
     * @param string $attribute
     * @return null or string
     */
    public function getHint($attribute)
    {
        $list = static::attributeHints();
        if (isset($list[$attribute])) {
            return $list[$attribute];
        }

        return null;
    }

    public function getNodeValue($attribute, $locale = 'ru')
    {
        $nodes = $this->nodes;
        if (isset($nodes[$locale])) {
            return $nodes[$locale][$attribute];
        }

        return null;
    }
}
