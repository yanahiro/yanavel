<?php

namespace App\Base\Services\ViewRenderer\FormView;

use App\Base\Services\ViewRenderer\RenderInterface;

/**
 * Class FormRender
 * フォーム作成クラス
 *
 * @package App\Base\Services\ViewRenderer\FormView
 * @author yanahiro
 * @version 1.0.0
 */
class FormRender implements RenderInterface
{
    /**
     * フィールド
     * @var array
     */
    protected $fields;

    /**
     * ボタン
     * @var array
     */
    protected $buttons;

    /**
     * メソッド
     * @var array
     */
    protected $method;

    /**
     * データ
     * @var array|Eloquent
     */
    protected $data;

    /**
     * オリジナルデータ
     * @var Eloquent
     */
    protected $raw;

    /**
     * ID
     * @var int|string
     */
    protected $id;

    /**
     * 変更ID
     * @var int|string
     */
    protected $cid;

    /**
     * 戻り先URL
     * @var string
     */
    protected $back;

    /**
     * 確認画面かどうか
     * @var bool
     */
    protected $conf = false;

    /**
     * プレフィックス
     * @var string
     */
    protected $prefix;

    /**
     * 強制リセット
     * @var bool
     */
    protected $is_force_reset = false;

    /**
     * Form要素のセット
     * @param  FormElementInterface  $elem
     * @return this
     */
    public function setElement(FormElementInterface $elem)
    {
        $this->elem = $elem;
        return $this;
    }

    /**
     * IDのセット
     * @param  int|string $id
     * @return this
     */
    public function setID($id)
    {
        if (is_null($this->id)) {
            $this->id = $id;
        }
        return $this;
    }

    /**
     * 変更IDのセット
     * URLのidと取得するリポジトリのidが違う場合に対応
     * @param  int|string $id
     * @return this
     */
    public function setChangeID($id)
    {
        if (is_null($this->cid)) {
            $this->cid = $id;
        }
        return $this;
    }

    /**
     * データのセット
     * @param  array|EloquentInterface $data
     * @param  bool $is_force_reset
     * @return this
     */
    public function setData($data, $is_force_reset = false)
    {
        $this->data = $data;
        $this->raw = $data;
        $this->is_force_reset = $is_force_reset;
        return $this;
    }

    /**
     * 戻るのセット
     *
     * @param  string $back
     * @return this
     */
    public function setBack($back)
    {
        $this->back = $back;
        return $this;
    }

    /**
     * 確認画面のセット
     *
     * @return this
     */
    public function setConf()
    {
        $this->conf = true;
        return $this;
    }

    /**
     * コントローラのセット
     *
     * @param  string  $controller
     * @return this
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * アクションのセット
     *
     * @param  string  $action
     * @return this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * プレフィックスのセット
     *
     * @param  string $prefix
     * @return this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * フォームのフィールドを取得
     *
     * @return array
     */
    public function getFields()
    {
        // フィールド作成を実行
        $this->elem->setID($this->id)
            ->fields();

        // アクションによる変更を実行
        $plus = camel_case($this->action);
        if ($this->conf) {
            $plus .= 'Conf';
        }
        $method = $plus.'Fields';
        if (method_exists($this->elem, $method)) {
            $this->elem->$method();
        }

        // 外からの値に置き換えない場合
        if (!$this->is_force_reset) {
            // 確認画面から戻ってきた場合に備えて前回のデータを取得
            if (!$this->conf) {
                $old = \Input::old();
                if (!is_null($old) && count($old) > 0) {
                    $this->data = $old;
                } else {
                    $space = \Once::get('space');

                    if ($space == $this->prefix.$this->action.$this->id) {
                        $data = \Once::get('input');
                        if (!is_null($data)) {
                            // 更新時
                            if (!is_null($this->id)) {
                                // データの主キーが正しい場合
                                if (is_null($this->cid)) {
                                    if ($data[$this->elem->pk] == $this->id) {
                                        $this->data = $data;
                                    }
                                } else {
                                    if ($data[$this->elem->pk] == $this->cid) {
                                        $this->data = $data;
                                    }
                                }
                            } else {
                                // 登録時
                                $this->data = $data;
                            }
                        }
                    }
                }
            }
        }

        // アクションからメソッド取得
        $this->generateMethod();

        // アクションやメソッドを設定
        \Widget::action($this->controller.$this->action)
            ->method($this->method)
            ->classes('form-horizontal')
            ->data($this->data);

        // データを整形したものにする
        $data_res =  \Widget::getDataRes();
        if (!is_null($data_res)) {
            $this->data = $data_res;
        }

        // updateやdeleteの場合はIDをセット
        if (!is_null($this->id)) {
            \Widget::id($this->id);
        }

        // 確認画面の場合全てのwidgetをplaneに
        if ($this->conf) {
            $this->elem->setConf();
            \Widget::conf();
        }
        \Once::set('input', $this->data);
        \Once::set('space', $this->prefix.$this->action.$this->id);
//        dd(\Once::get('space'));

        // フィールドの作成
        $fields = \Widget::render();
        return $fields;
    }

    /**
     * ボタンの取得
     *
     * @return array
     */
    public function getButtons()
    {
        $this->elem->setBack($this->back);
        return $this->elem->buttons($this->action);
    }

    /**
     * データの取得
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 生データの取得
     *
     * @return Eloquent
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * メソッドのセット
     *
     * @return string $method
     * @return this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * アクションからメソッドを取得
     *
     * @return void
     */
    protected function generateMethod()
    {
        if (is_null($this->method)) {
            if (strstr($this->action, 'create')) {
                $method = 'post';
            } elseif (strstr($this->action, 'update')) {
                $method = 'put';
            } elseif (strstr($this->action, 'delete')) {
                $method = 'delete';
            } else {
                $method = 'post';
            }
            $this->method = $method;
        }
    }

    /**
     * 必要な情報を作る
     *
     * @return void
     */
    public function build()
    {
        // フィールドの作成
        $this->fields = $this->getFields();

        // ボタンの作成
        $this->buttons = $this->getButtons();

        return $this;
    }

    /**
     * Formのオープン
     *
     * @return string
     */
    public function open()
    {
        return \Widget::open();
    }

    /**
     * Formのクローズ
     *
     * @return string
     */
    public function close()
    {
        return \Widget::close();
    }

    /**
     * viewで使いやすいように配列に変換する
     *
     * @return array
     */
    public function toArray()
    {
        $form = [
            'fields' => $this->fields,
            'buttons' => $this->buttons,
            'conf' => $this->conf,
            'data' => $this->data,
            'raw' => $this->raw,
        ];
        return $form;
    }

    /**
     * viewにレンダリングする
     *
     * @return string
     */
    public function render()
    {
        // 未実装
    }
}
