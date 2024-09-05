<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Category;
use App\Models\User;
use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class ArtistRegisterController extends Controller
{
    protected $jwt;

    protected $countryService;

    public function __construct(JWTAuth $jwt, CountryService $countryService)
    {
        $this->jwt = $jwt;
        $this->countryService = $countryService;
    }

    public function registerArtist(Request $request): JsonResponse
    {
        if (is_string($request->input('categories'))) {
            $request->merge(['categories' => json_decode($request->input('categories'), true)]);
        }
        $validated = $this->validator($request->all())->validate();
        $user = $this->createUser($validated);
        $profilePicturePath = $this->handleImageUpload($request->file('profilePicture'), $user);
        $user->profilePicture = $profilePicturePath;
        $user->save();
        $this->createArtist($validated, $user);
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
            'portfolio' => 'required|file',
            'age' => 'required|integer',
            'hourlyRate' => 'required|numeric',
            'jobTitle' => 'required|string',
            'summary' => 'required|string',
            'categories' => 'required',
//            'categories.*' => 'required|string|distinct',
        ]);
    }

    protected function createUser(array $data)
    {
        $countryId = $this->countryService->getCountryIdByName($data['country']);
        return User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'age' => $data['age'],
            'countryId' => $countryId->id,
            'role' => 'ARTIST',
        ]);
    }

    protected function createArtist(array $data, User $user)
    {
        $profilePicturePath = $data['profilePicture']->store('uploads', 'public');
        $portfolioPath = $data['portfolio']->store('uploads', 'public');

        $artist = Artist::create([
            'userId' => $user->id,
            'profilePicture' => $profilePicturePath,
            'portfolio' => $portfolioPath,
            'hourlyRate' => $data['hourlyRate'],
            'jobTitle' => $data['jobTitle'],
            'summary' => $data['summary'],
        ]);

        $categoryIds = [];
        foreach ($data['categories'] as $categoryName) {
            $category = Category::firstOrCreate(['category' => $categoryName]);
            $categoryIds[] = $category->id;
        }

        $artist->categories()->attach($categoryIds);
        return $artist;
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
