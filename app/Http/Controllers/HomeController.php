<?php namespace App\Http\Controllers;

use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use App\Models\AdminMenu\AdminMenuRepository;
use App\Base\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct($router);

        $this->middleware('auth');
    }

//    /**
//     * Show the application dashboard.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        return view('home');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $menuRepo = new AdminMenuRepository();
//        list($menu, $menus, $parent_id) = $menuRepo->getMenu('');

//        dd($this->menus);
        $this->view = view('pages.home.home');
//        $this->view->with('menus', $menus);
        return $this->renderer();
    }

}
