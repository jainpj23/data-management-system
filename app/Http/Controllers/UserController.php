<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Mail;
    
class UserController extends Controller
{  
    

    public function __construct() {
        $this->middleware('permission:user-list')->only('index');
        $this->middleware('permission:user-create')->only('create');
        $this->middleware('permission:user-edit')->only('edit');
        $this->middleware('permission:user-delete')->only('destroy');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = User::where('id','!=',1)->orderBy('id','DESC')->paginate(5);

        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roles = Role::where('id','!=',1)->pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        $name= $input['first_name'].' '.$input['last_name'];
        $email = $input['email'];
        $password = $input['password'];

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        
        $htmldata = '<h3>Dear '.$name.',</h3><h>Welcome to DMS!</h1><p>Login detail : </p><p>Name : '.$name.'</p><p>Email : '.$email.'</p><p>Password: '.$password.'</p>';

        $sent_user = array(
           'name'=>$name,
           'email'=>$email,
        );
        $data = array('email_body'=>$htmldata);
        Mail::send('mail_template/email_template', $data, function($message) use ($sent_user){
           $message->to($sent_user['email'], $sent_user['name'])->subject
           ('Welcome DMS');
           $message->from('prafull.jain@neosoftmail.com','DMS');
        });
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return redirect('/home');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::where('id','!=',1)->pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        $name= $input['first_name'].' '.$input['last_name'];
        $email = $input['email'];
        $password = $input['password'];


        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $result =  $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));

        if($result){
            $htmldata = '<h3>Dear '.$name.',</h3><h>Update DMS!</h1><p>Login detail : </p><p>Name : '.$name.'</p><p>Email : '.$email.'</p>';
            if($password !=''){
            $htmldata .='<p>Password: '.$password.'</p>'; 
            }
            $sent_user = array(
               'name'=>$name,
               'email'=>$email,
            );
            $data = array('email_body'=>$htmldata);
            Mail::send('mail_template/email_template', $data, function($message) use ($sent_user){
               $message->to($sent_user['email'], $sent_user['name'])->subject
               ('Update DMS');
               $message->from('prafull.jain@neosoftmail.com','DMS');
            });
        }
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    
    /* export csv download file*/ 
    public function userexportCsv(Request $request)
    {
       $fileName = 'user_'.time().'.csv';
       $users = User::where('id','!=',1)->orderBy('id','DESC')->get();

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Name', 'Email', 'Roles','Start Date',);

            $callback = function() use($users, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($users as $user) {
                    $role_name = "";
                    if(!empty($user->getRoleNames())){
                      foreach($user->getRoleNames() as $v){
                       $role_name .= $v;
                      }
                    }


                    $row['Name']  = $user->first_name.' '.$user->last_name;
                    $row['Email']    = $user->email;
                    $row['Roles']    = $role_name;
                    $row['Start Date']  = $user->created_at;

                    fputcsv($file, array($row['Name'], $row['Email'], $row['Roles'], $row['Start Date']));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

}