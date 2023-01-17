<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blacklist;
use App\Models\Candidates;
use App\Models\Company;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    private $v;
    public function __construct(){
        $this->v = [];
    }

    public function index_can()
    {
        $data = new Blacklist();
        $dataCat = new Candidates();
        $this->v['list'] = $data->loadList();
        $this->v['list_cat']=$dataCat->loadList();
        $this->v['title'] = "Danh sách ứng viên có trong Danh sách đen";
        return view('admin.blacklist.candidate.index', $this->v);
    }
    public function index_Cpn()
    {
        $data = new Blacklist();
        $dataCpn = new Company();
        $this->v['list'] = $data->loadList();
        $this->v['list_comp']=$dataCpn->loadList();
        $this->v['title'] = "Danh sách Công ty có trong Danh sách đen";
        return view('admin.blacklist.companies.index', $this->v);
    }
    // action
    // function action(Request $request){
    //     $data = $request->all();
    //     $query = $data['query'];

    //     $filler_data = Blacklist::select('id')
    //                 ->where('id','LIKE','%'.$query.'%')
    //                 ->get();
    //     return response()->json($filler_data);
    // }
}














