<?php

namespace App\Base\Services\ViewRenderer;

/**
 * Interface RenderInterface
 *
 * @package App\Base\Services\ViewRenderer
 * @author yanahiro
 * @version 1.0.0
 */
interface RenderInterface
{
    /**
     * 必要な情報を作る
     *
     * @return this
     */
    public function build();

    /**
     * viewで使いやすいように配列に変換する
     *
     * @return array
     */
    public function toArray();

    /**
     * viewにレンダリングする
     *
     * @return string
     */
    public function render();
}
