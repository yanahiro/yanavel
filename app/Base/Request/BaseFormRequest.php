<?php

namespace App\Base\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

/**
 * リクエスト基底クラス
 * リクエストクラスの共通的な機能を定義するクラス
 *
 * @package App\Http\Requests\Entry
 * @author yanahiro
 * @version 1.0
 *
 */
class BaseFormRequest extends FormRequest
{
    /**
     * メソッド
     *
     * @var string
     */
    protected $method = 'POST';

    /**
     * （サーバーサイド側）バリデーション定義
     * リクエスト送信時、Laravelはrules()関数が呼び出される。
     * リクエストの送信内容によって、バリデーション定義を返却する
     * @return array
     */
    public function rules()
    {
        // リクエスト前に共通的な処理があれば処理を記述する。

        // methodを設定
        $this->method = $this->method();

        // 確認モード
        $conf = $this->input('conf');
        if (isset($conf) && !is_null($conf)) {
            // confがnullの場合
            return [];
        }
        $rules = $this->requestRules();
        if ($this->method == 'PUT') {
            $rules = $this->updateChangeRules($rules);
        }
        return $rules;
    }

    /**
     * バリデーションルールを定義する
     * @return array
     */
    protected function requestRules()
    {
        return [];
    }

    /**
     * 更新時に変更したいバリデーションを定義する
     * requestRules()で定義したRuleをベースに追加する
     * @param $rules
     * @return mixed
     */
    protected function updateChangeRules($rules)
    {
        // $rules['hoge'] = 'required';
        return $rules;
    }

    /**
     * 属性の名称を定義する
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * 独自のエラーメッセージを定義する
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * クライアントチェック用のルールを定義する
     * @return array
     */
    public function clientRules()
    {
        return [];
    }

    /**
     * フォームリクエストの認可
     * 権限など、指定処理の更新判定が必要な場合は
     * オーバーライドして処理を記述する。
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * リクエストのhas関数をオーバーライド
     * null, 空の場合はfalseを返却するように見直し
     * @param array|string $key
     * @return bool
     */
    public function has($key)
    {
        $keys = is_array($key) ? $key : func_get_args();

        $input = $this->all();

        foreach ($keys as $value) {
            if (! Arr::has($input, $value)) {
                // キーが存在しない場合
                return false;
            }
            // Laravel バージョンアップ対応
            $val = $input[$key];
            if (is_null($val) || empty($val)) {
                // 値が空、nullでもfalseで返却する
                return false;
            }

        }

        return true;
    }
}