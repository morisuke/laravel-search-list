<?php

namespace Morisuke\SearchList\Eloquent;

/**
 * OperationTrait
 *
 * @package
 * @version $id$
 * @copyright itto.inc
 * @author morisuke <writers-high@outlook.com>
 * @license PHP Version 7.1
 */
trait OperationTrait
{
    /**
     * searchOperation
     *
     * @param string $operator
     * @param string $field
     * @param mixed $values
     * @access protected
     * @return void
     */
    protected function searchOperation(string $operator, string $field, $values)
    {
        // operatorを小文字で取得
        $upper_operator = studly_case($operator);
        $method_name    = "searchOperation{$upper_operator}";

        // 専用の処理メソッドが用意されている場合
        if (method_exists($this, $method_name))
        {
            return $this->{$method_name}($field, $values);
        }

        // そのまま渡せる場合はクエリにセット
        return $this->where($field, $operator, $values);
    }

    /**
     * searchOperationBetween
     *
     * @param string $field
     * @param array $values
     * @access protected
     * @return void
     */
    protected function searchOperationBetween(string $field, array $values)
    {
        // valuesが配列で来るのでループさせながらwhereをかけていく
        foreach ($values as $param_name => $value)
        {
            // 値が入っていない場合はスキップ
            if (empty($value)) continue;

            // before <= x <= afterになるようoperatorを調整
            $operator = ($param_name === 'before') ? '>=' : '<=';
            $this->where($field, $operator, $value);
        }
    }

    /**
     * searchOperationIn
     *
     * @param string $field
     * @param string $values
     * @access protected
     * @return void
     */
    protected function searchOperationIn(string $field, array $values)
    {
        $this->whereIn($field, $values);
    }

    /**
     * searchOperationLike
     *
     * @param string $field
     * @param string $values
     * @access protected
     * @return void
     */
    protected function searchOperationLike(string $field, string $values)
    {
        $this->where($field, 'like', "%{$values}%");
    }
}
