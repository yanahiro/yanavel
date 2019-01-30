<?php

namespace App\Base\Services\ViewRenderer\Button;

/**
 * Class Button
 * ボタン生成クラス
 *
 * @package App\Base\Services\ViewRenderer\Button
 * @author yanahiro
 * @version 1.0.0
 */
class Button
{
    /**
     * グループ
     *
     * @var string
     */
    protected $group = 'default';

    /**
     * フィールド
     *
     * @var array
     */
    protected $fields = [];

    /**
     * キー
     *
     * @var string
     */
    protected $key;

    /**
     * 通常ボタンの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function btn($prefix)
    {
        $this->button($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * サブミットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function submit($prefix)
    {
        $this->button($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * aタグの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function a($prefix)
    {
        $this->button($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * モーダルの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function modal($prefix)
    {
        $this->button($prefix, __FUNCTION__);
        $this->fields[$this->group][$this->key]['template'] = 'default';
        $this->fields[$this->group][$this->key]['modal']['modal_target'] = $this->group.$this->key;
        return $this;
    }

    /**
     * 名前の登録
     *
     * @param  string $name
     * @return this
     */
    public function name($name)
    {
        $this->fields[$this->group][$this->key]['name'] = $name;
        return $this;
    }

    /**
     * リンクの登録
     *
     * @param  string $href
     * @param  bool   $blank
     * @return this
     */
    public function href($href, $blank=false)
    {
        $this->fields[$this->group][$this->key]['href'] = $href;
        $this->fields[$this->group][$this->key]['blank'] = $blank;
        return $this;
    }

    /**
     * テンプレートの登録
     *
     * @param  string $template
     * @return this
     */
    public function template($template)
    {
        $this->fields[$this->group][$this->key]['template'] = $template;
        return $this;
    }

    /**
     * モーダルヘッダーの登録
     *
     * @param  string $header
     * @return this
     */
    public function modalHeader($header)
    {
        $this->fields[$this->group][$this->key]['modal']['modal_header'] = $header;
        return $this;
    }

    /**
     * モーダルボディの登録
     *
     * @param  string $body
     * @return this
     */
    public function modalBody($body)
    {
        $this->fields[$this->group][$this->key]['modal']['modal_body'] = $body;
        return $this;
    }

    /**
     * モーダルフッターの登録
     *
     * @param  mixed $footer
     * @return this
     */
    public function modalFooter($footer)
    {
        $this->fields[$this->group][$this->key]['modal']['modal_footer'] = $footer;
        return $this;
    }

    /**
     * グループの切替
     *
     * @param  string $group
     * @return this
     */
    public function group($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * ボタン登録
     *
     * @return string $prefix
     * @param  string $type
     * @return void
     */
    protected function button($prefix, $type)
    {
        $this->key = $prefix;
        $this->fields[$this->group][$this->key]['type'] = $type;
        $this->fields[$this->group][$this->key]['class'] = 'btn-'.$prefix;
    }

    /**
     * 配列で返す
     *
     * @return array
     */
    public function toArray($group)
    {
        return $this->fields[$group];
    }
}
