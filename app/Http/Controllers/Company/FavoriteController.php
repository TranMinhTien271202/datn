<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    private $v;
    public function __construct(){
        $this->v = [];
        $this->v['activeRoute'] = 'favorite';
    }
    public function index()
    {
        $this->v['title'] = 'Quản lý ứng viên yêu thích';
        $this->v['listSeeker'] = [];
        return view('company.favorite.index',$this->v);
    }
}
