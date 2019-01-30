<?php

namespace App\Base\Services\ViewRenderer\FormView;

/**
 * Class FormElement
 * フォーム定義クラス
 *
 * @package App\Base\Services\ViewRenderer\FormView
 * @author yanahiro
 * @version 1.0.0
 */
abstract class FormElement implements FormElementInterface
{
    /**
     * ボタン基本
     *
     * @var array
     */
    protected $base_button;

    /**
     * 戻り先
     *
     * @var string
     */
    protected $back;

    /**
     * ID
     *
     * @var int|string
     */
    protected $id;

    /**
     * 確認画面有無
     *
     * @var bool
     */
    protected $conf = true;

    /**
     * 主キー
     *
     * @var string
     */
    public $pk = 'id';

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        $this->buttonsBase();
    }

    /**
     * ボタンの基本
     *
     * @return void
     */
    public function buttonsBase()
    {
        $this->base_buttons = [
            'home' => [
                'name' => 'ホームに戻る',
                'href' => '/',
            ],
            'back' => [
                'name' => '戻る',
            ],
            'conf' => [
                'name' => '確認する',
            ],
            'create' => [
                'name' => '登録する',
            ],
            'update' => [
                'name' => '更新する',
            ],
            'delete' => [
                'name' => '削除する',
            ],
            'upload' => [
                'name' => 'アップロードする',
            ],
            'send' => [
                'name' => '送信する',
            ],
        ];
    }

    /**
     * 戻り先の作成
     *
     * @param  string $back
     * @return this
     */
    public function setBack($back)
    {
        $str = '';
        // 先頭4文字がhttpではない場合'/'を設定
        if (strncmp($back, 'http',4) != 0) {
            $str = '/';
        }

        $this->back = $back;
        $this->base_buttons['back']['href'] = $str . $back;
        return $this;
    }

    /**
     * IDのセット
     *
     * @return this
     */
    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 確認画面を解除
     *
     * @return this
     */
    public function setConf()
    {
        $this->conf = false;
        return $this;
    }

    /**
     * ボタンの作成
     *
     * @return array
     */
    public function buttons($action)
    {
        $method = camel_case($action).'Buttons';
        return $this->$method();
    }

    /**
     * create時ボタンの作成
     *
     * @return array
     */
    public function createButtons()
    {
        $next = 'create';
        if($this->conf)
        {
            $next = 'conf';
        }
        return $this->choice(['back', $next]);
    }

    /**
     * update時ボタンの作成
     *
     * @return array
     */
    public function updateButtons()
    {
        $next = 'update';
        if($this->conf)
        {
            $next = 'conf';
        }
        return $this->choice(['back', $next]);
    }

    /**
     * delete時ボタンの作成
     *
     * @return array
     */
    public function deleteButtons()
    {
        return $this->choice(['back', 'delete']);
    }

    /**
     * detail時ボタンの作成
     *
     * @return array
     */
    public function detailButtons()
    {
        return $this->choice(['back']);
    }

    /**
     * upload時ボタンの作成
     *
     * @return array
     */
    public function uploadButtons()
    {
        return $this->choice(['back', 'upload']);
    }

    /**
     * send時ボタンの作成
     *
     * @return array
     */
    public function sendButtons()
    {
        $next = 'send';
        if($this->conf)
        {
            $next = 'conf';
        }
        return $this->choice(['back', $next]);
    }

    /**
     * 基本ボタンを選択して必要分を返す
     *
     * @return array
     */
    public function choice($choices)
    {
        $res = [];
        foreach($choices as $key)
        {
            $res[$key] = $this->base_buttons[$key];
        }
        return $res;
    }

    /**
     * create時フィールド
     *
     * @return void
     */
    public function createFields()
    {
        \Widget::del('id');
    }

    /**
     * create_conf時フィールドの作成
     *
     * @return void
     */
    public function createConfFields()
    {
        \Widget::del('id');
    }
}
