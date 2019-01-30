<?php

namespace App\Base\Controller;

use Illuminate\Routing\Router;
use Illuminate\Routing\Controller;
use App\Base\Repository\BaseRepositoryInterface;
use App\Models\AdminMenu\AdminMenuRepository;

/**
 * コントローラ基底クラス
 * システム共通的に必要な機能や処理を管理するコントローラクラス
 *
 * @package App\Base\Controller
 * @author yanahiro
 * @version 1.0.0
 *
 */
abstract class BaseController extends Controller
{
    /**
     * アクション名
     *
     * @var string
     */
    protected $action;

    /**
     * アクション名日本語
     *
     * @var string
     */
    protected $action_ja;

    /**
     * URLにあるID用
     */
    protected $id;

    /**
     * @var BaseRepositoryInterface
     */
    protected $repo;

    /**
     * ウェブページのプレフィックス
     */
    protected $prefix;

    /**
     * コントローラー名
     */
    protected $controller;

    /**
     * 確認画面モード
     *
     * @var boolean
     */
    protected $conf;

    /**
     * 検索
     */
    protected $search;

    /**
     * リスト
     */
    protected $list;

    /**
     * フォーム
     */
    protected $form;

    /**
     * リンク
     */
    protected $link;

    /**
     * ベースURL
     * システムメニューマスタのURLに一致する
     */
    protected $base_url;

    /**
     * ベースファンクション
     * システムメニューマスタのURLで起動するファンクション名
     */
    protected $base_function;

    /**
     * メニュー
     */
    protected $menu;

    /**
     * 管理者メニュー群
     */
    protected $menus;

    /**
     * Viewに必ず渡す項目
     * @var array
     */
    protected $items = [
        'conf' => false,
        'prefix' => '',
        'search' => [],
        'list' => [],
        'form' => [],
        'link' => '',
        'menu' => '',
        'menus' => '',
        'action' => '',
        'action_ja' => ''
    ];

    /**
     * インターセプト処理管理
     * @var string
     */
    protected $ex_intercept;


//    protected $menus;
    protected $values;

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct(Router $router, BaseRepositoryInterface $repo = null)
    {
        $this->repo = $repo;
        $this->initPrefix();      // ウェブページのプレフィックス
        $this->initController();
        $this->initBaseUrl();
        $this->initMenus();
        $this->initLink();
    }


    /**
     *
     */
    public function renderer()
    {
        foreach ($this->items as $key => $item) {
            $data[$key] = $this->$key;
        }

        return $this->view->with($data);
    }

    /**
     * プレフィックスの初期化
     * @return void
     */
    protected function initPrefix()
    {
        // 親クラスのファンクションをOverride
        // ※親クラスではprefixが小文字に変換されるため
        // プレフィックスがセットされてない場合はクラス名から自動生成
        if (is_null($this->prefix)) {
            $class = get_class($this);
            $spl = explode('\\', $class);
            $this->prefix = str_replace('Controller', '', $spl[count($spl) - 1]);
        }
    }

    /**
     * コントローラーの初期化
     */
    protected function initController()
    {
        if (is_null($this->controller)) {
            $this->controller = 'Admin\\' . studly_case($this->prefix) . 'Controller@';
        }
    }

    /**
     * ベースURLの初期化
     *
     */
    protected function initBaseUrl()
    {
        if (is_null($this->base_url)) {
            if (!is_null($this->controller) && !is_null($this->base_function)) {
                $this->base_url = parse_url(action($this->controller . $this->base_function), PHP_URL_PATH);
            }
        }
    }

    /**
     * 管理者メニューの初期化
     *
     */
    protected function initMenus()
    {
        $menuRepo = new AdminMenuRepository();
        list($this->menu, $this->menus, $parent_id) = $menuRepo->getMenu($this->base_url);
        \Breadcrumb::push('home', 'HOME', '/', 'home');

        if (!is_null($this->menu)) {
            if (is_null($parent_id)) {
                // 親がない場合
                // パンくずに設定するURLの整形
                $url = ltrim($this->menu->url, '/');
                \Breadcrumb::push($this->menu->id, $this->menu->menu_name, $url);
            } else {
                // 親の展開
                $fix = $this->menus;
                $parents = explode('.', $parent_id);
                foreach ($parents as $p) {
                    // パンくずに設定するURLの整形
                    $url = ltrim($fix[$p]['self']->url, '/');
                    \Breadcrumb::push($fix[$p]['self']->id, $fix[$p]['self']->menu_name, $url);
                    if (isset($fix[$p]['child'])) {
                        $fix = $fix[$p]['child'];
                    }
                }
            }
        }
    }

    /**
     * リンクの初期化
     *
     */
    protected function initLink()
    {
        if (is_null($this->link)) {
            $last = \Breadcrumb::last();
//            dd($last);
            $this->link = $last['a'];
        }
    }

    /**
     * インターセプト
     * テンプレート処理などを作成する場合のフック定義用メソッド
     *
     * @param string $hook_name
     */
    protected function intercept($hook_name)
    {
        if (is_null($this->ex_intercept)) {
            $hook_method = $hook_name;
        } else {
            $hook_method = $this->ex_intercept."_".$hook_name;
        }

        // メソッドが存在すれば実行
        if (method_exists($this, $hook_method)) {
            $this->$hook_method();
        }
    }
}
