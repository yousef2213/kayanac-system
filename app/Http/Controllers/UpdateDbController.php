<?php

namespace App\Http\Controllers;

use App\VersionsDb;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class UpdateDbController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('active_permision');
    }


    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);
        $last_version = VersionsDb::orderBy('id', 'desc')->first();
        $countVersion = 0.1;
        if ($last_version) {
            $current_version = $last_version->version + $countVersion;
        } else {
            $current_version = $countVersion;
        }

        $name = 'newDb-' . $current_version . '.txt';
        $version = VersionsDb::create([
            "version" => $current_version,
            "file" => $name,
            "active" => 1,
        ]);
        if ($version) {
            $request
                ->file('file')
                ->move(storage_path('versionsDb'), $name);


            return redirect()
                ->route('home')
                ->with('msg', 'Successfully Update Db');
        }

        return redirect()
            ->back()
            ->with('error', 'لم يتم التحميل بنجاح');
    }


    public function update()
    {
        $versions = VersionsDb::where('active', 1)->orderBy('id', 'asc')->get();
        if (count($versions) > 0) {
            foreach ($versions as $ver) {
                $path = storage_path('versionsDb/' . $ver->file);
                $sql_dump = File::get($path);
                DB::connection()->getPdo()->exec($sql_dump);
                $ver->active = 0;
                $ver->save();
            }
            return response()->json([
                'status' => 200,
                'msg' => 'تم تنشيط اخر نسخة للداتا بيز'
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'msg' => 'انت علي اخر تحديث للداتا بيز'
            ]);
        }
    }

    public function downloadDb(Request $request)
    {
        // return $request;
        $url = 'https://yousef-ayman.com/db_erp_administration/' . $request->fileName;
        // return$url;
        $version = VersionsDb::all()->last();
        $dir = getenv('HOMEDRIVE') . getenv('HOMEPATH') . '\Downloads';
        if (file_exists($dir . '/' . $request->fileName)) {
            File::move($dir . '/' . $request->fileName, storage_path('/versionsDb' . "/" . $request->fileName));
        } else if (file_exists(storage_path() . '/versionsDb' . '/' . $request->fileName)) {
            $filename = storage_path('versionsDb/' . $version->file);
            $za = new ZipArchive();
            $folder = $filename;
            $za->open($folder);
            $za->extractTo(storage_path('versionsDb'));
            $za->close();
            // return $filename;
            $sqlFile = storage_path('versionsDb/' . $version->name . '.sql');
            $sql_dump = File::get($sqlFile);
            DB::connection()->getPdo()->exec($sql_dump);
            $version->active = 0;
            $version->version = $request->version;
            $version->save();
            File::delete($filename);
            File::delete($sqlFile);

            return redirect()->route('home')->with('msg', 'تم تحديث الداتا بنجاح , enjoy ❤️');
        } else {
            if (!$version) {
                VersionsDb::create([
                    "active" => 1,
                    "name" => $request->name,
                    "file" => $request->fileName,
                    "version" => $request->version,
                ]);
            } else {
                if ($version->active != 1) {
                    VersionsDb::create([
                        "active" => 1,
                        "name" => $request->name,
                        "file" => $request->fileName,
                        "version" => $request->version,
                    ]);
                }
                if ($version->active == 1) {
                    $version->active = 1;
                    $version->name = $request->name;
                    $version->file = $request->fileName;
                    $version->version = $request->version;
                    $version->save();
                }
            }
            return new RedirectResponse($url);
        }
    }


    public function checkVersion($version)
    {
        $versionMe = VersionsDb::all()->last();
        if (isset($versionMe)) {
            if ($versionMe->version == $version && $versionMe->active == 1) {
                return response()->json([
                    'msg' => "يوجد لديك تحديث لم تقم بتسطيبة تاكد من تسطيب اخر نسخة ",
                    'status' => 205,
                    'download' => 0
                ]);
            }

            if ($versionMe->version == $version && $versionMe->active == 0) {
                return response()->json([
                    'msg' => "انت علي اخر تحديث",
                    'status' => 201,
                    'download' => 0
                ]);
            }

            if ($versionMe->version != $version) {
                return response()->json([
                    'msg' => "يوجد تحديث جديد من فضلك قم بتحميل اخر تحديث للسيستم",
                    'status' => 200,
                    'download' => 0
                ]);
            }
            return $versionMe->active;
        } else {
            return response()->json([
                'msg' => "يوجد تحديث جديد اضغط للتحميل ",
                'status' => 200,
                'download' => 1
            ]);
        }
    }
}
