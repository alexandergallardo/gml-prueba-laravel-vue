<?php

namespace App\Http\Controllers;

use App\Events\UserHasContacted;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Category;
use Illuminate\Contracts\Support\Renderable;
use App\Models\User;

class HomeController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
    }

    /**
    * Show the application dashboard.
    *
    * @return Renderable
    */
    public function index()
    {
        return view('home');
    }

    public function all()
    {
        return User::with(['categories'])->get();
    }

    public function store(UserCreateRequest $request)
    {
        $data = $request->all();

        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->dni = $request->dni;
        $user->direction = $request->direction;
        $user->email = $request->email;
        $user->cellphone = $request->cellphone;
        $user->country = $request->country;
        $user->category_id = $request->category_id;
        $user->save();
    }

    public function update(UserUpdateRequest $request, int $id)
    {
        $data = $request->all();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->dni = $request->dni;
        $user->direction = $request->direction;
        $user->email = $request->email;
        $user->cellphone = $request->cellphone;
        $user->country = $request->country;
        $user->category_id = $request->category_id;
        $user->save();

        $this->sendEmail($user);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
    }

    public function listCategories()
    {
        return Category::pluck('name', 'id');
    }

    public function sendEmail($user)
    {
        $dataUser = [
            "email" => $user->email,
            "name"  => $user->name,
            "country" => $user->country,
            "message" => "Usted fue registrado satisfactoriamente como usuario en GML Test"
        ];

        UserHasContacted::dispatch($dataUser);

        $users = User::select('country, count(id) as Total')
                ->groupBy('country')
                ->get();

        $dataAdmin = [
            "email" => env('MAIL_ADMIN_TEST'),
            "name"  => 'Admin',
            "country" => '',
            "message" => $users
        ];
        UserHasContacted::dispatch($dataAdmin);
    }
}
