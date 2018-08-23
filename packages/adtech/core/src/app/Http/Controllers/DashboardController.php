<?php

namespace Adtech\Core\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Adtech\Core\App\Http\Requests\UploadRequest;
use Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('ADTECH-CORE::modules.core.dashboard.backend');
    }

    public function home(Request $request)
    {
        return redirect()->route('backend.homepage');
//        return view('ADTECH-CORE::modules.core.dashboard.frontend');
    }

    public function filemanage()
    {
        return view('ADTECH-CORE::modules.core.file.manage');
    }

    public function fileuploadtest(UploadRequest $request)
    {
//        if ($request->isMethod('post')) {
//            if ($request->has('file_real_path')) {
//                $filePath = $request->input("file_real_path");
//
//            }
//        }
        return view('ADTECH-CORE::modules.core.file.upload');
    }
}
