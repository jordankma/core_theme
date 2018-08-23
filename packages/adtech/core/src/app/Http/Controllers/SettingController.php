<?php

namespace Adtech\Core\App\Http\Controllers;

use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Adtech\Core\App\Repositories\SettingRepository;
use Adtech\Core\App\Models\Setting;
use Auth;

class SettingController extends Controller
{
    public function __construct(SettingRepository $settingRepository)
    {
        parent::__construct();
        $this->setting = $settingRepository;
    }

    public function manage(Request $request)
    {
        $settings = Setting::where('domain_id', $this->domainDefault)->get();
        $title = $logo = $logo_mini = $logo_link = $favicon = $company_name = $address = $email = $phone = $hotline = $ga_code = $chat_code = '';

        if (count($settings) > 0) {
            foreach ($settings as $setting) {
                switch ($setting->name) {
                    case 'logo':
                        $logo = $setting->value;
                        break;
                    case 'logo_mini':
                        $logo_mini = $setting->value;
                        break;
                    case 'title':
                        $title = $setting->value;
                        break;
                    case 'favicon':
                        $favicon = $setting->value;
                        break;
                    case 'logo_link':
                        $logo_link = $setting->value;
                        break;
                    case 'company_name':
                        $company_name = $setting->value;
                        break;
                    case 'address':
                        $address = $setting->value;
                        break;
                    case 'email':
                        $email = $setting->value;
                        break;
                    case 'phone':
                        $phone = $setting->value;
                        break;
                    case 'hotline':
                        $hotline = $setting->value;
                        break;
                    case 'ga_code':
                        $ga_code = $setting->value;
                        break;
                    case 'chat_code':
                        $chat_code = $setting->value;
                        break;
                }
            }
        }

        $data = [
            'title' => $title,
            'logo' => $logo,
            'logo_mini' => $logo_mini,
            'logo_link' => $logo_link,
            'favicon' => $favicon,
            'company_name' => $company_name,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
            'hotline' => $hotline,
            'ga_code' => $ga_code,
            'chat_code' => $chat_code
        ];

        return view('ADTECH-CORE::modules.core.setting.manage', $data);
    }

    public function update(Request $request)
    {
        $inputs = $request->all();
        if (count($inputs) > 0) {
            foreach ($inputs as $k => $input) {
                if ($k != '_method' && $k != '_token') {

                    //kiem tra input la file hay text
                    if ($request->hasFile($k)) {
                        //
                    } else {
                        $setting = Setting::where('name', $k)->where('domain_id', $this->domainDefault)->first();
                        if (null == $setting) {
                            $setting = new Setting();
                            $setting->domain_id = $this->domainDefault;
                            $setting->name = $k;
                        }
                        $setting->value = (empty($input) && $input != 0) ? '' : $input;
                        $setting->domain_id = $this->domainDefault;
                        $setting->save();
                    }

                }
            }
            return redirect()->route('adtech.core.setting.manage')->with('success', trans('adtech-core::messages.success.create'));
        }
    }
}
