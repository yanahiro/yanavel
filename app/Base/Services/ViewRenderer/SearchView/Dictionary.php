<?php

namespace App\Base\Services\ViewRenderer\SearchView;

/**
 * Class Dictionary
 * 検索条件作成クラス
 *
 * @package App\Services\ViewRenderer\SearchView
 * @author yanahiro
 * @version 1.0.0
 */
class Dictionary
{
    /**
     * クエリビルダー
     *
     * @var Illuminate\Database\Query\Builder
     */
    protected $builder;

    /**
     * ウィジェット
     *
     * @var string
     */
    protected $widget;

    /**
     * バリュー
     *
     * @var string
     */
    protected $value;

    /**
     * キー
     *
     * @var string
     */
    protected $key;

    /**
     * マルチ
     *
     * @var bool
     */
    protected $multi = false;

    /**
     * like検索用
     *
     * @var array
     */
    protected $like = [];

    /**
     * ビルダーのセット
     *
     * @param Illuminate\Database\Query\Builder
     * @return this
     */
    public function setBuilder($builder)
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * ウィジェットのセット
     *
     * @param string
     * @return this
     */
    public function setWidget($widget)
    {
        $this->widget = $widget;
        return $this;
    }

    /**
     * バリューのセット
     *
     * @param mixed
     * @return this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * キーのセット
     *
     * @param string
     * @return this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * マルチセレクトのセット
     *
     * @param bool
     * @return this
     */
    public function setMulti($bool = true)
    {
        $this->multi = $bool;
        return $this;
    }

    /**
     * マルチセレクトのセット
     *
     * @param array
     * @return this
     */
    public function setLike($like)
    {
        $this->like = $like;
        return $this;
    }

    /**
     * where句の作成
     *
     * @return this
     */
    public function flush()
    {
        unset($this->builder);
        unset($this->widget);
        unset($this->value);
        unset($this->key);
        unset($this->multi);
        unset($this->like);

        $this->multi = false;
        $this->like = [];
        return $this;
    }

    /**
     * where句の作成
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function build()
    {
        if(isset($this->widget))
        {
            switch ($this->widget)
            {
                case 'text':
                    if (strpos($this->key, 'multicol_') !== false) {
                        $this->builder = $this->builder->whereMultiText($this->key, $this->value, $this->like);
                    } else {
                        $this->builder = $this->builder->whereText($this->key, $this->value, $this->like);
                    }
                    break;
                case 'radio':
                    $this->builder = $this->builder->where($this->key, '=', $this->value);
                    break;
                case 'chosen':
                    if($this->multi) {
                        if (empty(array_filter($this->value))) {
                            continue;
                        }
                        $this->builder = $this->builder->whereIn($this->key, $this->value);
                    } else {
                        $this->builder = $this->builder->where($this->key, $this->value);
                    }
                    break;
                case 'checkbox':
                    $this->builder = $this->builder->whereIn($this->key, $this->value);
                    break;
                case 'imgcheckbox':
                    $this->builder = $this->builder->whereIn($this->key, $this->value);
                    break;
                case 'range':
                    $this->builder = $this->builder->range($this->key, $this->value);
                    break;
                case 'datetime_range':
                    $this->builder = $this->builder->whereDatetimeRange($this->key, $this->value);
                    break;
                default:
                    $this->builder = $this->builder->where($this->key, '=', $this->value);
                    break;
            }
        } else {
            if (is_array($this->value)) {
                $this->builder = $this->builder->whereIn($this->key, $this->value);
            } else {
                $this->builder = $this->builder->where($this->key, '=', $this->value);
            }
        }
        return $this->builder;
    }
}
