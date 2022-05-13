<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        // 요청 검증
        // validator 메서드는 RegisterController 내부에 있고,
        // 이름, 메일, 비번, 비번 확인 필드가 필수 입력이 됐는지 확인 함
        $this->validator($request->all())->validate();

        // Registered 이벤트 생성
        // 확인 이메일, 유저 생성 후 실행해야 하는 코드 등 
        // 관련된 관찰을 트리거함 (????)
        event(new Registered($user = $this->create($request->all())));

        // 유저 생성 후 로그인
        $this->guard()->login($user);

        // 여기가 핵심 hook 인듯
        // registered() 메서드가 없거나 null을 반환하면 다른 페이지 url 로 redirect 등등..
        // 이 튜토리얼에서는 맞는 응답을 반환하기 위해서 메서드 구현하기만 하면 됨 (??)
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user){
        $user->generateToken();

        return response()->json(['data'=>$user->toArray()], 201);
    }
}
