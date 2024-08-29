<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Http;

class RegisterStudentFaceApiService
{
    public function submitStudentIdentity($name, $images){
        $token = request()->session()->get('auth_session');
        $url = 'https://example.com/api/endpoint';
        $request = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->attach(
            'images', // Form field name for the images
            $this->__prepareImages($images) // Assuming $images is an array of UploadedFile instances
        );
        //dd($request);
        $response = $request->post($url, [
            'name' => $name,
            // Add any other text data as needed
        ]);
        return $response->json();
    }
    private function __prepareImages($images): array
    {
        $preparedImages = [];

        foreach ($images as $index => $image) {
            $extension = $image->getClientOriginalExtension();
            $preparedImages[] = [
                'name' => 'images[' . $index . ']',
                'contents' => file_get_contents($image->path()),
                'filename' => 'image_' . $index . '.'.$extension, // Replace with desired file names
            ];
        }

        return $preparedImages;
    }
}
