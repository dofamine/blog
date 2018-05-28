<?php

use ModuleValidator\Builder;
use ModuleValidator\Rule;

include_once __DIR__."/ModuleValidator/Builder.php";
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 28.05.2018
 * Time: 18:35
 */

class ModuleValidate
{
    private $rules = [];

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }

    public static function getBuilder(): Builder
    {
        return new Builder();
    }

    public function validate($data)
    {
        foreach($this->rules as $rule)
            if (!$rule->exec($data)) return false;
        return true;
    }
}