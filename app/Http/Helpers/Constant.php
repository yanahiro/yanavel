<?php

/**
 * constant\*.phpで定義した
 * 定数リスト(code => value)値を取得する
 *
 * @param  string $key
 * @param  array  $exclude
 * @param  string $left
 * @param  string $right
 * @return array
 */
function constant_base($key = null, $exclude = [], $left = 'name', $right = 'code')
{
    if (is_null($key)) {
        return app('constant');
    }

    $items =  app('constant')->get($key);

    // 配列内のKey部分のみの配列を取得する
    if(!is_null($items))
    {
        $list = array_column($items, $left, $right);

        if (isset($exclude)) {
            //除外項目が受け渡された場合
            foreach ($exclude as $delCode)
            {
                // 対象のコードの項目を除外する
                unset($list[constant_code($key.'.'.$delCode)]);
            }
        }
        return $list;
    }
    return null;
}

/**
 * constant\*.phpで定義した
 * 定数リスト(code => value)値を取得する
 *
 * @param  string $key
 * @param  array $exclude
 * @return array
 */
function constant_list($key = null, $exclude = [])
{
    return constant_base($key, $exclude);
}

/**
 * constant\*.phpで定義した
 * 定数リスト(code => path)値を取得する
 *
 * @param  string $key
 * @param  array $exclude
 * @return array
 */
function constant_path($key = null, $exclude = [])
{
    return constant_base($key, $exclude, 'img');
}

/**
 * constant\*.phpで定義した
 * 値を取得する
 *
 * @param  string $key
 * @return string
 */
function constant_code($key = null)
{
    if (is_null($key)) {
        return app('constant');
    }

    return app('constant')->get($key . '.code');
}

/**
 * constant\*.phpで定義した
 * 定数リスト(code => value)値を取得する
 * $valueがnullの場合はconstant_listと同値が返却される
 *
 * @param  string $key
 * @param  string $code
 * @return string
 */
function constant_name($key = null, $code = null)
{
    if (is_null($key))
    {
        return app('constant');
    }
    if(!is_null($code))
    {
        $key = $key.'.'.constant_key($key, $code);
    }

    return app('constant')->get($key . '.name');
}

/**
 * constant\*.phpで定義した
 * 定数リスト(code => value)値を取得する
 * $valueがnullの場合はconstant_listと同値が返却される
 *
 * @param  string $key
 * @param  string $code_value
 * @return string
 */
function constant_code_value($key = null, $code_value = null)
{
    if (is_null($key))
    {
        return app('constant');
    }
    if(!is_null($code_value))
    {
        $key = $key.'.'.constant_key($key, $code_value);
    }

    return app('constant')->get($key . '.code_value');
}

/**
 * constantフォルダに定義した定数を取得する
 * @param string $key
 * @return string
 */
function constant_mark($key = null)
{
    if (is_null($key)) {
        return app('constant');
    }

    return app('constant')->get($key . '.mark');
}

/**
 * constant\*.phpで定義した
 * 値を取得する
 *
 * @param  string $key
 * @return array
 */
function constant_array($key = null)
{
    if (is_null($key)) {
        return app('constant');
    }

    return app('constant')->get($key);
}

/**
 * constant\*.phpで定義した
 * 値を取得する
 *
 * @param  string $key
 * @param  array  $exclude
 * @return array
 */
function constant_codes($key = null, $exclude=[])
{
    if (is_null($key)) {
        return app('constant');
    }

    $keys = app('constant')->get($key);

    $e = [];
    if(count($exclude)>0)
    {
        foreach($exclude as $ex)
        {
            $e[] = constant_code($key.'.'.$ex);
        }
    }

    $codes = [];
    foreach($keys as $key)
    {
        if (!in_array($key['code'], $e))
        {
            $codes[] = $key['code'];
        }
    }
    return $codes;
}

/**
 * constant\*.phpで定義した
 * 値を取得する
 * なければ初期値を設定
 *
 * @param  string $key
 * @param  $default $key
 * @return string
 */
function constant_value($key = null, $default = null)
{
    if (is_null($key)) {
        return app('constant');
    }

    $data = app('constant')->get($key);
    if (is_null($data)) {
        $data = $default;
    }
    return $data;
}

/**
 * パスとコードからキーを返す
 *
 * @param string $path
 * @param string $code
 * @return string
 */
function constant_key($path, $code)
{
    $arr = constant_array($path);
    foreach($arr as $k => $v)
    {
        if($code == $v['code'])
        {
            return $k;
        }
    }
    return null;
}

/**
 * パスとコードからプロパティを返す
 *
 * @param string $path
 * @param string $code
 * @return string
 */
function constant_prop($path, $code, $prop)
{
    $arr = constant_array($path);
    foreach($arr as $k => $v)
    {
        if($code == $v['code'])
        {
            return $v[$prop];
        }
    }
    return null;
}

/**
 * エラーコードからエラーメッセージを返す
 *
 * @param string $code
 * @return string
 */
function error($code)
{
    return constant_value('error.'.$code);
}

/**
 * constant_listで取得するリストから
 * arrayで渡したキーと一致するリストのみを返却
 *
 * @param  [type] $key   [description]
 * @param  [type] $array [description]
 * @return [type]        [description]
 */
function constant_intersect_list($key, $array)
{
    return collect(constant_list($key))->intersectKey(collect($array)->flip())->toArray();
}