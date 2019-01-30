<?php

namespace App\Base\Services\ViewRenderer\Widget;

/**
 * Class Widget
 * フォームに定義するオブジェクト定義設定基底クラス
 *
 * @package App\Services\ViewRenderer\Widget
 * @author yanahiro
 * @version 1.0.0
 */
class Widget
{
    /**
     * フィールド
     *
     * @var array
     */
    protected $fields = [];

    /**
     * グルーピングフィールド
     *
     * @var array
     */
    protected $gfields = [];

    /**
     * グループ
     *
     * @var array
     */
    protected $group = [];

    /**
     * 削除グループ
     *
     * @var array
     */
    protected $delgroup = [];

    /**
     * キー
     *
     * @var string
     */
    protected $key;

    /**
     * キー
     *
     * @var string
     */
    protected $action;

    /**
     * クラス
     *
     * @var string|array
     */
    protected $classes;

    /**
     * メソッド
     *
     * @var string
     */
    protected $method;

    /**
     * ID
     *
     * @var int|string
     */
    protected $id;

    /**
     * 整形データ
     *
     * @var array
     */
    protected $data_res;

    /**
     * ファイルの有無
     *
     * @var bool
     */
    protected $is_file = false;

    /**
     * ページ内リンク
     *
     * @var bool
     */
    protected $page_link;

    /**
     * テキストウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function text($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * パスワードウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function password($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 隠しウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function hidden($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 隠しプレーンウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function phidden($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * プレーンウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function plane($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 数値ウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function number($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * テキストエリアウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function textarea($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * リッチテキストエリアウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function richtext($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * ラジオウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function radio($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * チェックボックスウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function checkbox($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 画像ラジオウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function imgradio($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 画像チェックボックスウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function imgcheckbox($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 日付ウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function date($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 日付(年月日セレクト)ウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function date3($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 日付(年月セレクト)ウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function date2($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 日時ウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function datetime($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * 日時範囲ウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function datetime_range($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * ファイルウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function file($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
		$this->is_file = true;
        return $this;
    }

    /**
     * upload_fileウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function upload_file($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        $this->multiple(false);
        return $this;
    }

    /**
     * chosenウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function chosen($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        $this->multiple(false);
        return $this;
    }

    /**
     * 隠しセレクトウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function pselect($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        $this->multiple(false);
        return $this;
    }

    /**
     * レンジウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function range($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * ファイルウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function image($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * ハックウィジェットの登録
     *
     * @param  string $prefix
     * @return this
     */
    public function hack($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * バニッシュウィジェットの登録
     *
     * @param  string $name
     * @return this
     */
    public function vanish($prefix)
    {
        $this->widget($prefix, __FUNCTION__);
        return $this;
    }

    /**
     * フィールド名の登録
     *
     * @param  string $name
     * @return this
     */
    public function name($name)
    {
        $this->fields[$this->key]['name'] = $name;
        return $this;
    }

    /**
     * フィールド名の登録
     *
     * @param  string $overname
     * @return this
     */
    public function overname($overname)
    {
        $this->fields[$this->key]['overname'] = $overname;
        return $this;
    }

    /**
     * グループをつくり名前をつける
     *
     * @param  string $prefix
     * @param  string $name
     * @return this
     */
    public function head($prefix, $name = '')
    {
        $this->group[] = [
            'prefix' => $prefix,
            'name' => $name,
            'before' => $this->key,
        ];
        return $this;
    }

    /**
     * グループを消す
     *
     * @param  string $prefix
     * @return this
     */
    public function delhead($prefix)
    {
        $this->delgroup[] = $prefix;
        return $this;
    }

    /**
     * フィールドの必須登録
     *
     * @param  bool $required
     * @return this
     */
    public function required($required = true)
    {
        $this->fields[$this->key]['required'] = $required;
        return $this;
    }

    /**
     * フィールドのプレースホルダ登録
     *
     * @param  string  $placeholder
     * @return this
     */
    public function placeholder($placeholder)
    {
        $this->fields[$this->key]['option']['placeholder'] = $placeholder;
        return $this;
    }

    /**
     * フィールドのaccept登録
     *
     * @param  string  $accept
     * @return this
     */
    public function accept($accept)
    {
        $this->fields[$this->key]['accept'] = $accept;
        return $this;
    }

    /**
     * フィールドのfolder_name登録
     *
     * @param  string  $folder_name
     * @return this
     */
    public function folder_name($folder_name)
    {
        $this->fields[$this->key]['folder_name'] = $folder_name;
        return $this;
    }

    /**
     * chosenフィールドの結果なし時文言登録
     *
     * @param  string  $no
     * @return this
     */
    public function no_results($no)
    {
        $this->fields[$this->key]['no_results'] = $no;
        return $this;
    }

    /**
     * chosenフィールドの複数選択登録
     *
     * @param  bool  $multiple
     * @return this
     */
    public function multiple($multiple = true)
    {
        $this->fields[$this->key]['multiple'] = $multiple;
        return $this;
    }

    /**
     * フィールドのmaxlength登録
     *
     * @param  int  $max
     * @return this
     */
    public function maxlength($max)
    {
        $this->fields[$this->key]['option']['maxlength'] = $max;
        return $this;
    }

    /**
     * フィールドのあいまい検索
     *
     * @param  array  $type ['before', 'after']
     * @return this
     */
    public function like($type = ['before'])
    {
        $pattern = "%s";
        if (in_array('before', $type)) {
            $pattern = $pattern."%%";
        }
        if (in_array('after', $type)) {
            $pattern = "%%".$pattern;
        }
        $this->fields[$this->key]['like'] = $pattern;
        return $this;
    }

    /**
     * フィールドのscope登録
     *
     * @param  bool  $scope
     * @param  array $param
     * @return this
     */
    public function scope($scope, $param = null)
    {
        $this->fields[$this->key]['scope'] = $scope;
        $this->fields[$this->key]['scope-param'] = $param;
        return $this;
    }

    /**
     * フィールドの値登録
     *
     * @param  mixed  $value
     * @param  string $key
     * @return this
     */
    public function value($value, $key = '')
    {
        if($key == '') {
            $key = $this->key;
        }
        $this->fields[$key]['value'] = $value;
        return $this;
    }

    /**
     * フィールドの前にアイコンを付ける登録
     *
     * @param  string $before
     * @param  string $type
     * @return this
     */
    public function before($before, $type = 'fa')
    {
        if($type == 'fa') {
            $before = '<i class="fa fa-'.$before.'"></i>';
        }
        $this->fields[$this->key]['before'] = $before;
        $this->fields[$this->key]['group'] = true;
        return $this;
    }

    /**
     * フィールドの後ろにアイコンを付ける登録
     *
     * @param  string $after
     * @param  string $type
     * @return this
     */
    public function after($after, $type = 'fa')
    {
        if($type == 'fa') {
            $before = '<i class="fa fa-'.$after.'"></i>';
        }
        $this->fields[$this->key]['after'] = $after;
        $this->fields[$this->key]['group'] = true;
        return $this;
    }

    /**
     * エスケープ登録
     *
     * @param  bool $bool
     * @return this
     */
    public function escape($bool = true)
    {
        $this->fields[$this->key]['escape'] = $bool;
        return $this;
    }

    /**
     * フィールドのサイズ登録
     *
     * @param  int|string $size
     * @return this
     */
    public function size($size)
    {
        if(is_integer($size)) {
            $size = (string) $size;
        }
        $this->fields[$this->key]['size'] = 'size-'.$size;
        return $this;
    }

    /**
     * フィールドのサイズ複数登録
     *
     * @param  array $sizes
     * @return this
     */
    public function sizes($sizes)
    {
        foreach ($sizes as $size) {
            $this->fields[$this->key]['sizes'][] = 'size-'.$size;
        }
        return $this;
    }

    /**
     * フィールドのヘルプテキスト登録
     *
     * @param  string $text
     * @return this
     */
    public function helptext($text)
    {
        $this->fields[$this->key]['helptext'] = $text;
        return $this;
    }

    /**
     * フィールドのサブヘルプテキスト登録
     *
     * @param  string $text
     * @return this
     */
    public function subhelptext($text)
    {
        $this->fields[$this->key]['subhelptext'] = $text;
        return $this;
    }

    /**
     * フィールドの選択肢登録
     *
     * @param  array $choices
     * @param  array $excludes
     * @return this
     */
    public function choices($choices)
    {
        $this->fields[$this->key]['choices'] = $choices;
        return $this;
    }

    /**
     * 確認でもプレーンにしない
     *
     * @param  bool $bool
     * @return this
     */
    public function noplane($bool=false)
    {
        $this->fields[$this->key]['noplane'] = $bool;
        return $this;
    }

    /**
     * 空選択肢を追加する
     *
     * @return this
     */
    public function addBlank()
    {
        $this->fields[$this->key]['choices'] += ['' => _('未選択')];
        return $this;
    }

    /**
     * planeで使用のaタグ
     *
     * @param  string $href
     * @return this
     */
    public function a($href)
    {
        $this->fields[$this->key]['a'] = $href;
        // エスケープも行う
        $this->escape();
        return $this;
    }

    /**
     * 画像src
     *
     * @param  string $src
     * @return this
     */
    public function src($src)
    {
        $this->fields[$this->key]['src'] = $src;
        return $this;
    }

    /**
     * targetの作成
     *
     * @param  string|array $target
     * @return this
     */
    public function target($target)
    {
        $this->fields[$this->key]['target'] = $target;
        return $this;
    }

    /**
     * フィールドの選択肢登録
     *
     * @param  Collection $q
     * @param  string  $key
     * @param  string  $disp
     * @return this
     */
    public function query($q, $key, $disp)
    {
        $chosen = [];
        foreach ($q as $qv) {
            $chosen[$qv[$key]] = $qv[$disp];
        }
        $this->fields[$this->key]['query'] = $chosen;
        return $this;
    }

    /**
     * Formのアクション登録
     *
     * @param  string $action
     * @return this
     */
    public function action($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Formのメソッド登録
     *
     * @param  string $method
     * @return this
     */
    public function method($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Formのクラス登録
     *
     * @param  string|array $classes
     * @return this
     */
    public function classes($classes)
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * ページ内リンク登録
     *
     * @param  string $link
     * @return this
     */
    public function page_link($link)
    {
        $this->page_link = '#'.$link;
        return $this;
    }

    /**
     * Formのデータ登録
     *
     * @param  array|Eloquent|Collection $data
     * @return this
     */
    public function data($data)
    {
        $data_res = [];
        foreach ($this->fields as $k => &$v) {
            // create時
            if (is_null($data)) {
                if (!isset($v['value'])) {
                    $v['value'] = $this->getDataValue($data, $k, $v);
                }
            } elseif (is_array($data)) {
                // 戻ってきた時
                if (count($data) != 0) {
                    // 検索条件の場合はdataが配列 フィールド名のまま取得
                    $v['value'] = @$data[$k];
                } else {
                    // 検索条件の場合はdataが配列 フィールド名のまま取得
                    $v['value'] = @$v['value'];
                }
            } else {
                // updateの初期時
                $k = $this->removeUniquePrefix($k);
                // 親がある場合は親から探してみる
                if (isset($v['parent'])) {
                    $v['value'] = $this->getParentDataValue($data, $v['parent'], $k, $v);
                } else {
                    $v['value'] = $this->getDataValue($data, $k, $v);
                }
            }
            $v = $this->human($v);
            if (isset($v['chidden'])) {
                $v['widget'] = 'phidden';
            }
            // hidden系はOnceのセッションに持たすので準備
            if ($v['widget'] == 'phidden' || $v['widget'] == 'hidden') {
                $hidden[$k] = $v['value'];
            }
            $data_res[$k] = $v['value'];
        }
        // Eloquentのデータの場合は配列にする
        if (!is_array($data)) {
            $this->data_res = $data_res;
        }
        if (isset($hidden)) {
            \Once::set('hidden', $hidden);
        }
        return $this;
    }

    /**
     * 親のデータを取得する
     *
     * @param  Eloquent|Collection $data
     * @param  string $parent
     * @param  string $k
     * @param  array  $v
     * @return this
     */
    private function getParentDataValue($data, $parent, $k, $v)
    {
        $spl = explode('.', $parent);
        $parent_data = $data;
        foreach($spl as $key) {
            if (isset($parent_data[0])) {
                // 親にたどり着く前に配列(Collection)だった場合は1つ目を取得
                $parent_data = $parent_data[0];
            }
            $parent_data = @$parent_data[$key];
        }

        return $this->getDataValue($parent_data, $k, $v);
    }

    /**
     * データを取得する
     *
     * @param  Eloquent|Collection $data
     * @param  string $parent
     * @param  string $k
     * @param  array  $v
     * @return this
     */
    private function getDataValue($data, $k, $v)
    {
        if (isset($v['overname'])) {
            $k = $v['overname'];
        }
        // 先にアクセサーから取得する
        $value = @$data[$k];
        if (is_null($value) && !is_null($data)) {
            // 配列系のデータの場合（1対多など）
            if (isset($data[0])) {
                $value_array = [];
                // キーを作成する 詳細画面と更新画面で
                // 併用するためchosen系は分岐が必要
                $key = $k;
                if ($v['widget'] == 'chosen') {
                    $key = explode('_', $k);
                    $key = $key[count($key) - 1];
                }
                foreach ($data as $data2) {
                    $value_array[] = $this->getDataValue($data2, $key, $v);
                }
                $value = $value_array;
            }
        }
        if ($v['widget'] == 'date' || $v['widget'] == 'datetime') {
            if (is_null($value) || $value == '') {
                return null;
            }
            return \Carbon\Carbon::parse($value)->setTimezone(tz());
        }
        if ($value instanceof \Carbon\Carbon) {
            $res['year'] = $value->year;
            $res['month'] = $value->month;
            $res['day'] = $value->day;
            return $res;
        }
        if ($v['widget'] == 'date2') {
            if (mb_strlen($value) >= 6) {
                $res['year'] = mb_substr($value, 0, 4);
                $res['month'] = mb_substr($value, 4, 2);
                return $res;
            }
        }
        if ($v['widget'] == 'text' && is_array($value)) {
            $value = @$value[0];
        }
        return $value;
    }

    /**
     * FormのID登録
     *
     * @param  int|string $id
     * @return this
     */
    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * FormのID取得
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 整形データの取得
     *
     * @return array
     */
    public function getDataRes()
    {
        return $this->data_res;
    }

    /**
     * キーのセット
     * 変更を加えたい場合などに使用
     *
     * @param  string $key
     * @return this
     */
    public function key($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * formのオープン
     *
     * @return string
     */
    public function open()
    {
        if(is_null($this->id)) {
            $action = $this->action;
        } else {
            $action = [$this->action, $this->id];
        }
        $open = [
            'action' => $action,
            'class' => $this->classes,
            'method' => $this->method,
            'files' => $this->is_file,
            'novalidate',
        ];
        if (!is_null($this->page_link)) {
            $open['url'] = $this->page_link;
        }

        return \Form::open($open);
    }

    /**
     * formのクローズ
     *
     * @return string
     */
    public function close()
    {
        return \Form::close();
    }

    /**
     * 確認画面用
     *
     * @return this
     */
    public function conf()
    {
        foreach($this->fields as $k => &$v)
        {
            $v = $this->human($v);
            if (isset($v['chameleon']) && $v['value'] == '') {
                unset($this->fields[$k]);
            }
            if (isset($v['before'])) {
                unset($v['before']);
            }
            if (isset($v['after'])) {
                unset($v['after']);
            }
            if (isset($v['group'])) {
                unset($v['group']);
            }
            if (!($v['widget'] == 'hack' || $v['widget'] == 'vanish' || $v['widget'] == 'image')) {
                if (!isset($v['noplane']) || !$v['noplane']) {
                    // ng-showなどを利かすため
                    if (isset($v['option']['ng-model'])) {
                        $v['widget'] = 'phidden';
                    } else {
                        $v['widget'] = 'plane';
                    }
                }
            }
            // helptextは消す
            if (isset($v['helptext'])) {
                unset($v['helptext']);
            }
            if (isset($v['subhelptext'])) {
                unset($v['subhelptext']);
            }
        }
        return $this;
    }

    /**
     * 人間可読のデータ
     *
     * @param  array  $v
     * @return string
     */
    public function human(&$v)
    {
        if ($v['widget'] == 'radio') {
            if (isset($v['value'])) {
                $v['value_human'] = @$v['choices'][$v['value']];
            }
        }
        if ($v['widget'] == 'password') {
            if (isset($v['value'])) {
                $v['value_human'] = secret($v['value']);
            }
        }
        if ($v['widget'] == 'chosen' || $v['widget'] == 'pselect') {
            if (isset($v['choices'])) {
                $list = $v['choices'];
            } else {
                $list = $v['query'];
            }

            if (isset($v['value']) && is_array($v['value'])) {
                $values = [];
                foreach ($v['value'] as $value) {
                    //$values[] = @$v['query'][$value];
                    $values[] = @$list[$value];
                }
                $v['value_human'] = array_comma($values);
            } else {
                //$v['value_human'] = @$v['query'][$v['value']];
                $v['value_human'] = @$list[$v['value']];
            }
        }
        if ($v['widget'] == 'checkbox') {
            if (isset($v['value']) && is_array($v['value'])) {
                $values = [];
                foreach ($v['value'] as $value) {
                    $values[] = @$v['choices'][$value];
                }
                $v['value_human'] = array_comma($values);
            } else {
                $v['value_human'] = @$v['choices'][$v['value']];
            }
        }
        if ($v['widget'] == 'date') {
            $val = $v['value'];

            if (!is_null($val)) {
                if (!($val instanceof \Carbon\Carbon)) {
                    if($val == '') {
                        $val = null;
                    } else {
                        $format = constant_value('commons.date_format.carbon.dt_ymd');
                        $dt = \DateTime::createFromFormat($format, $v['value']);
                        if ($dt) {
                            $val = \Carbon\Carbon::instance($dt);
                        }
                    }
                } else {
                    $format = constant_value('commons.date_format.carbon.ymd');
                    $val->setToStringFormat($format);
                }
            }
            $v['value'] = $val;
        }
        if ($v['widget'] == 'date3') {
            if (isset($v['value'])) {
                if (!is_array($v['value'])) {
                    if (!is_null($v['value']) && $v['value'] != '') {
                        $d = date2array($v['value']);
                    } else {
                        $d = [
                            'year' => '',
                            'month' => '',
                            'day' => '',
                        ];
                    }
                    $v['value'] = $d;
                }

                if ($v['value']['year'] != '' && $v['value']['month'] != '' && $v['value']['day'] != '') {
                    $v['value_human'] = \Carbon\Carbon::parse(implode('-', $v['value']))->format('Y/m/d');
                } else {
                    $v['value_human'] = '';
                }
            }
        }
        if ($v['widget'] == 'date2') {
            if (isset($v['value'])) {
                if ($v['value']['year'] != '' && $v['value']['month'] != '') {
                    $v['value_human'] = $v['value']['year'].'/'.str_pad($v['value']['month'], 2, '0', STR_PAD_LEFT);
                } else {
                    $v['value_human'] = '';
                }
            }
        }
        if ($v['widget'] == 'datetime') {
            $val = $v['value'];

            if (!is_null($val)) {
                if (!($val instanceof \Carbon\Carbon)) {
                    if ($val == '') {
                        $val = null;
                    } else {
                        $format = constant_value('commons.date_format.carbon.dt_ymdhi');
                        $dt = \DateTime::createFromFormat($format, $v['value']);
                        if ($dt) {
                            $val = \Carbon\Carbon::instance($dt);
                        }
                    }
                } else {
                    $format = constant_value('commons.date_format.carbon.ymdhi');
                    $val->setToStringFormat($format);
                }
            }
            $v['value'] = $val;
        }
        if ($v['widget'] == 'range') {
            $v['value_human'] = range_string($v['value']);
        }
        if ($v['widget'] == 'textarea') {
            $v['value_human'] = nl2br($v['value']);
        }
        if ($v['widget'] == 'richtext') {
            $v['value_human'] = $v['value'];
            $v['conf_class'] = 'txt_rich cke_editable cke_editable_themed cke_contents_ltr cke_show_borders';
        }
        if (isset($v['a'])) {
            $v['value_human'] = a($v['value'], $v['a'], $this->fields);
        }
        // 配列のバリューはカンマ区切りに
        if (is_array($v['value']) && !isset($v['value_human'])) {
            $v['value_human'] = array_comma($v['value']);
        }
        return $v;
    }

    /**
     * 検索などでのリレーション用
     *
     * @param  string $parents
     * @return this
     */
    public function parents($parents)
    {
        $this->fields[$this->key]['parent'] = $parents;
        return $this;
    }

    /**
     * 消す用
     *
     * @param  string $prefix
     * @return this
     */
    public function del($prefix)
    {
        unset($this->fields[$prefix]);
        return $this;
    }

    /**
     * データがなければ消す用
     *
     * @param  string $prefix
     * @return this
     */
    public function chameleon($prefix = null)
    {
        if (is_null($prefix)) {
            $prefix = $this->key;
        }
        $this->fields[$prefix]['chameleon'] = true;
        return $this;
    }

    /**
     * 更新時などでphiddenに変換する用
     *
     * @param  string $prefix
     * @return this
     */
    public function chidden($prefix)
    {
        $this->fields[$prefix]['chidden'] = true;
        return $this;
    }

    /**
     * 変更する用
     *
     * @param  string $prefix
     * @param  string $key
     * @param  mixed  $change
     * @return this
     */
    public function change($prefix, $key, $change)
    {
        $this->fields[$prefix][$key] = $change;
        return $this;
    }

    /**
     * ハックウィジェットの参照テンプレートを変更する用
     *
     * @param  string $prefix
     * @param  string $over
     * @return this
     */
    public function override($prefix, $over)
    {
        $this->fields[$prefix]['override'] = $over;
        return $this;
    }

    /**
     * 普通のフィールド取得
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * レンダリング
     *
     * @return array
     */
    public function render()
    {
        $this->renderOption();
        $this->renderGroup();
        return $this->gfields;
    }

    /**
     * オプション（inputタグなどにつく属性）のレンダリング
     *
     * @return void
     */
    public function renderOption()
    {
        foreach ($this->fields as $k => &$v) {
            if(!(
                $v['widget'] == 'radio' ||
                $v['widget'] == 'checkbox' ||
                $v['widget'] == 'imgradio' ||
                $v['widget'] == 'imgcheckbox'
            )) {
				$v['option']['class'] = 'input';
			} else {
				$v['option']['class'] = '';
			}
            if (isset($v['value']) && $v['value'] !== '' && isset($v['option']['ng-model'])) {
                $v['option']['ng-init'] = $v['option']['ng-model'].'="'.$v['value'].'"';
            }
        }
    }

    /**
     * グループのレンダリング
     *
     * @return void
     */
    public function renderGroup()
    {
        if (count($this->group) > 0) {
            $fields = $this->fields;
            foreach ($this->group as $gk => $gv) {
                if (!in_array($gv['prefix'], $this->delgroup)) {
                    foreach ($fields as $k => $v) {
                        $this->gfields[$gv['prefix']]['fields'][$k] = $v;
                        $this->gfields[$gv['prefix']]['name'] = $gv['name'];
                        unset($fields[$k]);
                        if (isset($this->group[$gk + 1]) && $this->group[$gk + 1]['before'] == $k) {
                            break;
                        }
                    }
                }
            }
            // すべてグループが消えた場合はシングルで登録
            if (count($this->gfields)==0) {
                $this->gfields['one']['fields'] = $this->fields;
            }
        } else {
            $this->gfields['one']['fields'] = $this->fields;
        }
    }

    /**
     * フィールドがあるか
     *
     * @return bool
     */
    public function existFields()
    {
        if(count($this->fields) > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * ウィジェット登録
     *
     * @return string $prefix
     * @param  string $widget
     * @return void
     */
    protected function widget($prefix, $widget)
    {
        $this->key = $this->getUniquePrefix($prefix);
        $this->fields[$this->key] = ['widget' => $widget];
    }

    /**
     * フィールドキーのユニーク対応
     *
     * @return string $prefix
     * @return void
     */
    protected function getUniquePrefix($prefix)
    {
        if (!isset($this->fields[$prefix])) {
            return $prefix;
        }

        $prefix = $this->addUniquePrefix($prefix);
        return $this->getUniquePrefix($prefix);
    }

    /**
     * フィールド名にユニーク文字を追加する
     *
     * @return string $prefix
     * @return void
     */
    public function addUniquePrefix($prefix)
    {
        preg_match('/__uq(\d+)/', $prefix, $match);
        $i = 1;
        if (!empty($match)) {
            $i = ++$match[1];
            $prefix = $this->removeUniquePrefix($prefix);
        }
        return $prefix."__uq{$i}";
    }

    /**
     * フィールド名のユニーク文字を除去する
     *
     * @return string $prefix
     * @return void
     */
    public function removeUniquePrefix($prefix)
    {
        return preg_replace('/__uq(\d+)/', '', $prefix);
    }

    /**
     * ファイルの有無をセット
     *
     * @return bool $isFile
     * @return void
     */
    public function isFile($isFile)
    {
        $this->is_file = $isFile;
    }
}
