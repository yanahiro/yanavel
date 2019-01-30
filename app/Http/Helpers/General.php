<?php

/**
 * 現在のURLを返却する
 * @return mixed
 */
function current_url()
{
    $url = \URL::full();
    if (strstr(\URL::current(), 'https://')) {
        $url = str_replace('http://', 'https://', $url);
    }
    return $url;
}

/**
 * ページ遷移しないようなaタグ内の文字を返す（よく忘れるので）
 *
 * @return string
 */
function void()
{
    return 'javascript:void(0)';
}

/**
 * クエリストリングを返す
 *
 * @return string
 */
function qs()
{
    return \Request::getQueryString();
}

/**
 * クエリストリングを配列にして返す
 *
 * @param  string
 * @return string
 */
function qs_to_array($qs='')
{
    if($qs == '')
    {
        $qs = qs();
    }
    $strs = explode('&', $qs);
    $res = [];
    foreach($strs as $str)
    {
        $kv = explode('=', $str);
        if(count($kv)==2)
        {
            $res[$kv[0]] = $kv[1];
        }
    }
    return $res;
}

/**
 * 配列をクエリストリングにして返す
 *
 * @param  array
 * @return string
 */
function array_to_qs($array, $q = true)
{
    //dd($array);
    $str = '';
    if($q)
    {
        $str .= '?';
    }
    $count = 0;
    foreach($array as $k => $v)
    {
        $v = explode('__', $v)[0];
        $str .= $k.'='.$v;
        if(count($array) - 1 != $count){
            $str .= '&';
        }
        $count++;
    }
    return $str;
}

/**
 * 現在のURLパスを返す
 *
 * @return string
 */
function url_path()
{
    return \Request::path();
}

/**
 * ソート用のURLを返す
 *
 * @param  string $sort
 * @return string
 */
function sort_url($sort)
{
    $sort = explode('__', $sort)[0];
    $param = qs_to_array();
    if (isset($param['o'])) {
        if ($param['o'] == $sort) {
            $sort = '-'.$sort;
        }
    }
    $param['o'] = $sort;
    return url(url_path().array_to_qs($param));
}

/**
 * ソート用のクラスを返す
 *
 * @param  string $sort
 * @return string
 */
function sort_class($sort)
{
    $prefix = 'dec_order_';
    $type = 'def';
    $param = qs_to_array();
    if (isset($param['o'])) {
        $sort = explode('__', $sort)[0];
        if ($param['o'] == $sort) {
            $type = 'asc';
        } elseif($param['o'] == '-'.$sort) {
            $type = 'desc';
        }
    }
    $class = $prefix.$type;
    return $class;
}




/**
 * クエリストリングを追加して返す
 *
 * @param  string  $url
 * @param  array  $operation
 * @return string
 */
function url_add_qs($url, $operation)
{
    $url = url($url);
    if (!isset($operation['is_query']))
    {
        return $url;
    }

    $url = rtrim($url, '/');

    $add = '?';
    if (strpos($url, '?') !== false)
    {
        $add = '/';
    }
    return $url . $add . qs();
}




/**
 * easy.php
 */

/**
 * {}で囲まれた文字列の置換
 *
 * @param  string  $value
 * @param  Eloquent|array  $elq
 * @param  string  $default
 * @return string
 */
function replace_view_string($value, $elq, $default=null)
{
    preg_match_all("/{.*?}/", $value, $match);
    if (!isset($match[0]))
    {
        return $value;
    }
    foreach($match[0] as $m)
    {
        $key = str_replace(['{', '}'], '', $m);
        $tmp[$key] = @$elq->$key;
        if(!is_null($tmp[$key]))
        {
            $elq[$key] = $tmp[$key];
        }

        if(is_array($elq[$key]))
        {
            $elq[$key] = $elq[$key]['value'];
        }

        if (is_null($elq[$key]))
        {
            return $default;
        }
        $value = str_replace($m, $elq[$key], $value);
    }
    return $value;
}

/**
 * ドット区切り文字の頭の文字を取得
 * viewのバリデーションで使用
 *
 * @param  string  $str
 * @return string
 */
function dot_first($str)
{
    return explode('.', $str)[0];
}

/**
 * エラーが有ればエラークラスの文字列を返す
 *
 * @param  \Illuminate\Support\MessageBag  $errors
 * @param  string  $key
 * @param  bool    $dot
 * @return string
 */
function has_error($errors, $key, $dot = true)
{
    $keys = $errors->keys();
    foreach ($keys as $k) {
        if ($dot) {
            $k = dot_first($k);
        }
        if ($key == $k) {
            return 'has-error';
        }
    }
    return '';
}

/**
 * forms.php
 */

/**
 * 文字列を文字数分*に置換
 *
 * @param  string  $val
 * @return string
 */
function secret($val)
{
    $r = '';
    for ($i=0; $i<strlen($val); $i++) {
        $r .= '*';
    }
    return $r;
}

