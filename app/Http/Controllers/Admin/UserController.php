<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Support\ExportHelper;
use App\Support\ExportHelperInterface;
use Illuminate\Http\Request;

class UserController extends ApiController implements ExportHelperInterface
{


    use ExportHelper;

    public function getExportHeaders(): array
    {
        return [
            'ID',
            'NAME',
            'EMAIL',
            'AVATAR',
            'PHONE',
            'AGE',
            'ADDRESS',
            'CREATED DATE',
        ];
    }

    public function getExportData(Request $request): \Generator
    {
        $users = $this->getQuery($request)->get();
        foreach ($users as $user) {
            yield [
                $user->id,
                $user->name,
                $user->email,
                $user->avatar,
                $user->phone,
                $user->age,
                $user->address,
                $user->created_at->format('Y-m-d H:i:s'),
            ];
        }
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