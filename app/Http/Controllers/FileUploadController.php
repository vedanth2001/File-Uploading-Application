<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request){
        $topFolder=$request->input('folder');
        $subFolder=$request->input('subfolder');
        
        $rules = [
            'file' => 'required|file|max:2048', // Example rule for file size, adjust as needed
        ];
        switch ($subFolder) {
            case 'menus':
                // Allow only PDF files for the 'menus' subfolder
                $rules['file'] .= '|mimes:pdf';
                break;
            case 'images':
                // Allow only image files (JPEG, PNG, GIF) for the 'images' subfolder
                $rules['file'] .= '|image|mimes:jpeg,png,gif';
                break;
            case 'videos':
                // Allow only video files (MP4, AVI, MOV) for the 'videos' subfolder
                $rules['file'] .= '|mimes:mp4,avi,mov';
                break;
            case 'profile pictures':
                // Allow only image files for the 'profile_pictures' subfolder
                $rules['file'] .= '|image';
                break;
            case 'uploaded images':
                // Allow only image files for the 'uploaded_images' subfolder
                $rules['file'] .= '|image';
                break;
            case 'reservation documents':
                // Allow only PDF files for the 'reservation_documents' subfolder
                $rules['file'] .= '|mimes:pdf';
                break;
            case 'invoices':
                // Allow only PDF files for the 'invoices' subfolder
                $rules['file'] .= '|mimes:pdf';
                break;
            case 'app home banner':
                // Allow only image files for the 'app_home_banner' subfolder
                $rules['file'] .= '|image';
                break;
            case 'web home banner':
                // Allow only image files for the 'web_home_banner' subfolder
                $rules['file'] .= '|image';
                break;
            case 'payeazy offer banner':
                // Allow only image files for the 'payeazy_offer_banner' subfolder
                $rules['file'] .= '|image';
                break;
            // Add cases for other subfolders as needed
        }

        $request->validate($rules);
        $file = $request->file('file');
        $directory = "{$topFolder}/{$subFolder}";
        // dd($file);
        try {
            // Store the file on S3
            $filePath = Storage::disk('s3')->put($directory.'/'.$file->getClientOriginalName(), file_get_contents($file));
        
            // Optionally, you can generate a URL to access the uploaded file
            $url = Storage::disk('s3')->url($filePath);
        
            // Return a success response with the file URL
            return response()->json(['url' => $url], 200);
        } catch (\Exception $e) {
            // Handle any errors that occur during file upload
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }
}
