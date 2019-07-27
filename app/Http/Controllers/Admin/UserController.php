<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Support\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserController extends ApiController
{

    use ControllerHelper;

    protected $exportHeaders;

    public function __construct()
    {
        parent::__construct();
        $this->exportHeaders = [
            'ID' => 'id',
            'NAME' => 'name',
            'EMAIL' => 'email',
            'AVATAR' => 'avatar',
            'PHONE' => 'phone',
            'AGE' => 'age',
            'ADDRESS' => 'address',
            'CREATED DATE' => function ($row) {
                return Carbon::parse($row['created_at'])->format('Y-m-d');
            },
        ];
    }

    public function index(Request $request)
    {
        return $this->response->json(
            $this->getQuery($request)->orderBy($this->order_by_column, $this->order_by_direction)->paginate($this->page_size)->toArray()
        );
    }

    public function getQuery(Request $request)
    {
        return User::where(function ($query) use ($request) {
            if ($name = $request->get('name')) {
                $query->where(['name' => $name]);
            }
            if ($email = $request->get('email')) {
                $query->where(['email' => $email]);
            }
            if ($age = $request->get('age')) {
                $query->where(['age' => $age]);
            }
            if ($app_date = $request->get('app_date')) {
                $query->where(['app_date' => $app_date]);
            }
            if ($created_at = $request->get('created_at')) {
                $query->whereBetween('created_at', is_array($created_at) ? $created_at : explode(',', $created_at));
            }
        });
    }

    public function info(User $user)
    {
        return $this->response->json($user->toArray());
    }
}