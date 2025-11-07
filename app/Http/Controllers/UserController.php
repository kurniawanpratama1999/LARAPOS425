<?php
namespace App\Http\Controllers;

use App\Models\User;
use phpDocumentor\Reflection\Types\Integer;
use Request;

class UserController extends Controller {
    public function index() {
        $datas = User::all()->makeHidden('password');

        return view('pages.users.index', compact('datas'));
    }
    public function create() {
        
        return view('pages.users.create');
    }
    public function edit($id) {
        
        return view('pages.users.edit', compact('id'));
    }
    public function search (Request $request) {}
    public function store (Request $request) {}
    public function update (Request $request) {}
    public function destroys (Request $request) {}
}