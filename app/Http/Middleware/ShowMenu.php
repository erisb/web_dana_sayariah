<?php

namespace App\Http\Middleware;

use Closure;
use App\AdminMenu;
use App\AdminMenuItem;
use Auth;

class ShowMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::id();
        $data_menu_utama = array();
        $data_menu_cabang = array();
        $menu = array();
        $menuUtama = AdminMenuItem::where('parent','=',0)->get();
        foreach($menuUtama as $allMenu)
        {
            $data_menu_utama[] = [
                                    'id' => $allMenu->id,
                                    'label' => $allMenu->label,
                                    'link' => $allMenu->link,
                                    'menu' => $allMenu->menu
                                 ];
        }
        $menuItem = AdminMenuItem::leftJoin('rbac','rbac.id_menu','=','admin_menu_items.id')
                                ->leftJoin('admins','admins.role','=','rbac.id_role')
                                ->where('admin_menu_items.parent','!=',0)
                                ->where('admins.id',$user)
                                ->get();
        foreach($menuItem as $allMenuItem)
        {
            $data_menu_cabang[] = [
                                    'label' => $allMenuItem->label,
                                    'link' => $allMenuItem->link,
                                    'parent' => $allMenuItem->parent,
                                  ];
        }
        $cekMenu = AdminMenu::leftJoin('admin_menu_items','admin_menu_items.menu','=','admin_menus.id')
                            ->leftJoin('rbac','rbac.id_menu','=','admin_menu_items.id')
                            ->leftJoin('admins','admins.role','=','rbac.id_role')
                            ->where('admin_menu_items.parent','=',0)
                            ->where('admins.id',$user)
                            ->get(['admin_menus.id']);
        foreach($cekMenu as $data)
        {
            $menu[] = $data->id;
        }
        session(['data_menu_utama' => $data_menu_utama, 'data_menu_cabang' => $data_menu_cabang, 'cekMenu' => $menu]);
        return $next($request);
    }
}
