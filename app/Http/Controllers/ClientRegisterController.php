<?php
namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Client;
use App\Models\User;
use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class ClientRegisterController extends Controller
{
    protected $jwt;
    protected $countryService;

    public function __construct(JWTAuth $jwt, CountryService $countryService)
    {
        $this->jwt = $jwt;
        $this->countryService = $countryService;
    }

    public function registerClient(Request $request): JsonResponse
    {
        $validated = $this->validator($request->all())->validate();
        $user = $this->createUser($validated);
        $profilePicturePath = $this->handleImageUpload($request->file('profilePicture'), $user);
        $user->profilePicture = $profilePicturePath;
        $user->save();
        $this->createClient($validated, $user);
        $token = $this->jwt->fromUser($user);
        return response()->json(['jwt' => $token, 'role' => $user->role, 'sub' => $user->username], 201);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
            'confirmPassword' => 'required|string|same:password',
            'name' => 'required|string',
            'country' => 'required|string',
            'profilePicture' => 'required|image',
        ]);
    }

    protected function createUser(array $data)
    {
        $countryId = $this->countryService->getCountryIdByName($data['country']);
        return User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'countryId' => $countryId->id,
            'role' => 'CLIENT',
        ]);
    }

    protected function createClient(array $data, User $user)
    {
        return Client::create([
            'userId' => $user->id,
        ]);
    }

    private function handleImageUpload($file, User $user)
    {
        if ($file) {
            $fileExtension = $file->extension();
            $filename = "{$user->id}-profile-picture.{$fileExtension}";
            $file->storeAs('user_images', $filename, 'public');
            return $filename;
        }
        return null;
    }
}
