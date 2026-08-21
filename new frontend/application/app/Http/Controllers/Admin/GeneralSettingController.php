<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Image;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $pageTitle = 'Global Settings';
        $timezones = json_decode(file_get_contents(resource_path('views/admin/partials/timezone.json')));
        return view('admin.setting.general', compact('pageTitle','timezones'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:40',
            'base_color' => ['nullable', 'regex:/^[a-f0-9]{6}$/i'],
            'secondary_color' => ['nullable', 'regex:/^[a-f0-9]{6}$/i'],
            'timezone' => 'required',
        ]);

        // Update Pawlly settings for app_name
        \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_name')->update(['val' => $request->site_name]);

        // Update Pawlly settings for root_colors
        $colors = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'root_colors')->value('val');
        $colorsArr = json_decode($colors, true) ?: [];
        if ($request->base_color) {
            $colorsArr['--bs-primary'] = '#' . $request->base_color;
            $colorsArr['--bs-primary-rgb'] = implode(', ', sscanf($request->base_color, "%02x%02x%02x"));
        }
        if ($request->secondary_color) {
            $colorsArr['--bs-secondary'] = '#' . $request->secondary_color;
            $colorsArr['--bs-secondary-rgb'] = implode(', ', sscanf($request->secondary_color, "%02x%02x%02x"));
        }
        \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(['name' => 'root_colors'], ['val' => json_encode($colorsArr), 'type' => 'general']);

        // Update Timezone
        \Illuminate\Support\Facades\DB::table('settings')->where('name', 'default_time_zone')->update(['val' => $request->timezone]);

        // ViserLab specific toggles
        $general = GeneralSetting::first();
        if ($general) {
            $general->registration = $request->registration ? 1 : 0;
            $general->agree = $request->agree ? 1 : 0;
            $general->save();
        }

        $timezoneFile = config_path('timezone.php');
        $content = '<?php $timezone = '.$request->timezone.' ?>';
        file_put_contents($timezoneFile, $content);
        
        $notify[] = ['success', 'General Settings has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function logoIcon()
    {
        $pageTitle = 'Logo & Favicon';
        return view('admin.setting.logo_icon', compact('pageTitle'));
    }

    public function logoIconUpdate(Request $request)
    {
        $request->validate([
            'logo' => ['image',new FileTypeValidate(['jpg','jpeg','png'])],
            'logo_dark' => ['image',new FileTypeValidate(['jpg','jpeg','png'])],
            'logo_wide' => ['image',new FileTypeValidate(['jpg','jpeg','png'])],
            'favicon' => ['image',new FileTypeValidate(['png'])],
        ]);
        if ($request->hasFile('logo')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo)->save($path . '/logo.png');
                \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(['name' => 'logo'], ['val' => asset('assets/images/logoIcon/logo.png'), 'type' => 'string', 'updated_at' => now()]);
                \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(['name' => 'mini_logo'], ['val' => asset('assets/images/logoIcon/logo.png'), 'type' => 'string', 'updated_at' => now()]);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('logo_dark')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo_dark)->save($path . '/logo_dark.png');
                \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(['name' => 'dark_logo'], ['val' => asset('assets/images/logoIcon/logo_dark.png'), 'type' => 'string', 'updated_at' => now()]);
                \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(['name' => 'dark_mini_logo'], ['val' => asset('assets/images/logoIcon/logo_dark.png'), 'type' => 'string', 'updated_at' => now()]);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('favicon')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $size = explode('x', getFileSize('favicon'));
                Image::make($request->favicon)->resize($size[0], $size[1])->save($path . '/favicon.png');
                \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(['name' => 'favicon'], ['val' => asset('assets/images/logoIcon/favicon.png'), 'type' => 'string', 'updated_at' => now()]);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the favicon'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'Logo & favicon has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function cookie(){
        $pageTitle = 'GDPR Cookie';
        $cookie = Frontend::where('data_keys','cookie.data')->firstOrFail();
        return view('admin.setting.cookie',compact('pageTitle','cookie'));
    }

    public function cookieSubmit(Request $request){
        $request->validate([
            'short_desc'=>'required|string|max:255',
            'description'=>'required',
        ]);
        $cookie = Frontend::where('data_keys','cookie.data')->firstOrFail();
        $cookie->data_values = [
            'short_desc' => $request->short_desc,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
        ];
        $cookie->save();
        $notify[] = ['success','Cookie policy has been updated successfully'];
        return back()->withNotify($notify);
    }
}
