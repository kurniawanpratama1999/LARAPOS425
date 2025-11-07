<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class UserController extends Controller
{
    public function getEdit(Request $request)
    {
        $id = $request->query('id');
        if (!$id) {
            return response()->json(['success' => false, 'message' => "Wrong Parameter"], 400);
        };

        $userEdit = User::where('id', $id)->first();

        if (!$userEdit) {
            return response()->json(['success' => false, 'message' => 'Cannot found data with id'], 400);
        }

        $html = view('components.apis.user-modal-update', compact('userEdit'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }
    public function getDelete(Request $request)
    {
        $ids = $request->query('id');
        Logger()->info($ids);
        if (!$ids) {
            return response()->json(['success' => false, 'message' => "Wrong Parameter"], 400);
        };

        $userDelete = User::find($ids);

        if (!$userDelete) {
            return response()->json(['success' => false, 'message' => 'Cannot found data with id'], 400);
        }

        $html = view('components.apis.user-modal-delete', compact('userDelete'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function search(Request $request)
    {
        $q = $request->query('q');
        $query = User::select('id', 'name', 'role_id', 'email', 'status', 'created_at');

        if (!empty($q)) {
            $query
                ->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('role_id', 'like', "%{$q}%");
                });
        }

        $users = $query->get();

        $html = view('components.apis.user-table-data', compact('users'))->render();

        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function add()
    {
        $html = view('components.apis.user-modal-add')->render();
        return response()->json(['success' => true, 'html' => $html], 200);
    }

    public function index()
    {
        $users = User::select('id', 'name', 'role_id', 'email', 'status', 'created_at')->get();
        return view('pages.dashboard.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|integer',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'role_id' => $validated['role_id'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $message_html = view('components.apis.message', [
                'message' => 'User baru berhasil ditambah!',
                'success' => true
            ])->render();

            return response()->json(["success" => true, 'html' => $message_html], 200);
        } catch (\Throwable $th) {
            $message_html = view('components.apis.message', [
                'message' => 'User baru gagal ditambah!',
                'success' => false
            ])->render();

            return response()->json(["success" => false, 'html' => $message_html], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroys(Request $request) {}
}
