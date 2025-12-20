<?php

use App\Models\Kantor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

if (! function_exists('formInput')) {
    function formInput($type, $name, $attributes = [])
    {
        $value = old($name);
        $attrString = '';
        foreach ($attributes as $key => $val) {
            $attrString .= "$key=\"$val\" ";
        }

        return "<input type=\"$type\" name=\"$name\" value=\"$value\" class=\"form-control\" $attrString>";
    }
}

if (! function_exists('formSubmit')) {
    function formSubmit($text = 'Submit', $attributes = [])
    {
        $attrString = '';
        foreach ($attributes as $key => $val) {
            $attrString .= "$key=\"$val\" ";
        }

        return "<button type=\"submit\" class=\"btn btn-primary\" $attrString>$text</button>";
    }
}

if (! function_exists('alert_success')) {
    function alert_success($msg = null)
    {
        $html = "<div class='alert alert-success alert-dismissible'>$msg</div>";

        return $html;
    }
}

if (! function_exists('formatRupiah')) {
    function formatRupiah($angka, $prefix = 'Rp')
    {
        return $prefix.' '.number_format($angka, 0, ',', '.');
    }
}

if (! function_exists('successAlert')) {
    function successAlert($msg = null, $load = null, $elem = '#masterData', $redirect = '')
    {
        $loadData = json_encode($load);
        $elem = json_encode($elem);
        $html = "<div class='alert alert-success mx-2 my-2'>$msg</div>";
        $url = json_encode($redirect);
        $script = "<script>
                setTimeout(function () {
                    hideModal();
                    loadData({$loadData}, {$elem})
                    window.location.href = {$url};
                }, 1500)
                </script>";

        return $html.$script;

    }
}

if (! function_exists('errorAlert')) {
    function errorAlert($msg = null)
    {
        return "<div class='alert alert-danger alt mx-2 my-2'>$msg</div>
                <script>
                setTimeout(function () {
                    $('.alt').fadeOut(500, function () {
                        $(this).remove();
                    });
                }, 1500);
                </script>";
    }
}

if (! function_exists('dateDisplay')) {
    function dateDisplay($time)
    {
        \Carbon\Carbon::setLocale('id');
        $time = Carbon\Carbon::parse($time)->translatedFormat('l, d F Y');

        return $time;
    }
}

if (! function_exists('dateTimeDisplay')) {
    function dateTimeDisplay($time)
    {
        \Carbon\Carbon::setLocale('id');
        $time = Carbon\Carbon::parse($time)->translatedFormat('l, d F Y H:i');

        return $time;
    }
}

if (! function_exists('profilePicture')) {
    function profilePicture()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->photo) {
            return Storage::disk('r2')->url($user->photo);
        }

        $nama = $user ? $user->nama : 'Guest';

        return 'https://ui-avatars.com/api/?name='.urlencode($nama).'&background=random';
    }
}

if (! function_exists('img_url')) {
    function img_url($param = null)
    {
        if (empty($param)) {
            return 'https://ui-avatars.com/api/?name=Tidak+Ada&background=random';
        }

        if (Storage::disk('r2')->exists($param)) {
            return Storage::disk('r2')->url($param);
        }

        return 'https://ui-avatars.com/api/?name=tidak-ada&background=random';
    }
}

if (! function_exists('favicon_url')) {
    function favicon_url()
    {
        $kantor = Kantor::query()->first();
        if ($kantor && ! empty($kantor->favicon)) {
            if (Storage::disk('r2')->exists($kantor->favicon)) {
                return Storage::disk('r2')->url($kantor->favicon);
            }
        }

        return 'https://ui-avatars.com/api/?name=FaheemaAcademy&background=random';
    }
}

if (! function_exists('logo_utama_url')) {
    function logo_utama_url()
    {
        $kantor = Kantor::query()->first();
        if ($kantor && ! empty($kantor->logo)) {
            if (Storage::disk('r2')->exists($kantor->logo)) {
                return Storage::disk('r2')->url($kantor->logo);
            }
        }

        return 'https://ui-avatars.com/api/?name=FaheemaAcademy&background=random';
    }
}

if (! function_exists('nama_perusahaan')) {
    function nama_perusahaan()
    {
        $kantor = Kantor::query()->first();
        //        if (!is_null($kantor->nama_perusahaan)) {
        //            return $kantor->nama_perusahaan;
        //        }

        return 'Company';
    }
}
