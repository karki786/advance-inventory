<?php namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests;
use App\User;
use Carbon;
use CodedCell\Repository\User\UserInterface;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Hash;
use Image;
use Input;
use Redirect;
use Illuminate\Http\Request;
use Schema;
use Auth;
use Response;
use Mail;

class UserController extends Controller
{
    use PaginateTrait;

    public function __construct(UserInterface $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('glance', User::class);
        $users = $this->user->all(array());
        $message = "List Of All Users";
        return view('users.view_users')->with(compact('users', 'message'));
    }

    public function table(Request $request)
    {

        $paginate = boolval($request->paginate);
        $model = $this->user->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        return view('users.createupdateuser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, Requests\UserFormRequest $form)
    {
        $this->authorize('create', User::class);
        $data = $request->all();
        $password = $request->get('password');
        if ($password != "") {
            $data['password'] = Hash::make($password);
        } else {
            unset($data['password']);
        }
        $this->user->createUser($data);
        return Redirect::action('UserController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect()->action('UserController@edit', array('id' => $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->user->getById($id);
        $this->authorize('view', $user);
        return view('users.createupdateuser')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $password = $request->get('password');
        if ($password != "") {
            $data['password'] = Hash::make($password);
        } else {
            unset($data['password']);
        }
        $this->user->updateUser($id, $data);
        return Redirect::action('UserController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->user->deleteUser($id);
        return Response::json(['ok' => 'ok']);
    }

    public function getDeleted()
    {
        $restore = 1;
        $users = $this->user->allDeleted();
        $message = "Deleted Users";
        return view('users.index')->with(compact('users', 'restore', 'message'));
    }

    public function restore($id)
    {
        $this->user->restoreUser($id);
        return Redirect::action('UserController@index');
    }


    public function uploadAvatar(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file->store('public/avatar');
            User::find(Auth::user()->id)->update(['avatar' => $path]);
            return array('save_path' => $path);
        }
    }

    /**
     * Downloads Data Transfer Workbench File
     */
    public function dataTransfer()
    {
        $file = Excel::create("Data Transfer WorkBench", function ($excel) {

            // Set the title
            $excel->setTitle('Data Transfer WorkBench');

            // Chain the setters
            $excel->setCreator('Stock Control System')
                ->setCompany(env('COMPANY_NAME'));

            // Call them separately
            $excel->setDescription('Data Transfer Workbench');
            $excel->sheet('Data Transfer Workbench', function ($sheet) {
                $sheet->freezeFirstRowAndColumn();
                $columns = Schema::getColumnListing('users');
                unset($columns[0]);
                unset($columns[11]);
                unset($columns[12]);
                unset($columns[13]);
                $sheet->fromArray($columns);
            });
        });
        $file->download();
    }

    public function uploadData($file)
    {
        Excel::load($file, function ($reader) {
            $results = $reader->toArray();
            foreach ($results as $result) {
                $result['role_id'] = 5;
                $this->user->createUser($result);
            }
        });
    }

    public function export()
    {
        $format = $request->query('type');
        $filename = Carbon::now()->format('Ymd_') . "UserList";
        $file = Excel::create($filename, function ($excel) {

            // Set the title
            $excel->setTitle('Users');

            // Chain the setters
            $excel->setCreator('Stock Control System')
                ->setCompany(env('COMPANY_NAME'));

            // Call them separately
            $excel->setDescription('Products List and their Levels');
            $excel->sheet('UserList', function ($sheet) {
                $sheet->freezeFirstRowAndColumn();
                $sheet->fromModel($this->user->allReport());
            });


        });

        if ($request->has('email')) {
            $email = $request->get('email');
            $save_details = $file->store('xlsx');
            $content = "Please find attached a list of users";
            Mail::send('emails.product', array('content' => $content), function ($message) use ($save_details, $email) {
                $message->to($email)->subject('User List');
                $message->attach($save_details['full']);
            });
            return Redirect::action('UserController@index');
        } else {
            $file->download($format);
        }
    }


}
