<?php
namespace App\Http\Services;

use App\Models\Departemen;
use App\Models\Jadwal;
use App\Models\Tahun;
use Carbon\Carbon;

class Helper
{
    public static function idrToDouble($idrString)
    {
        $idrString = preg_replace("/[^0-9]/", "", $idrString);

        // Convert the string to a double
        $idrDecimal = (double) $idrString;
        return $idrDecimal;
    }
    public static function doubleToIdr($idrString)
    {
        return 'Rp ' . number_format($idrString, 0, ',', '.');

    }

    public static function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(Helper::penyebut($nilai));
        } else {
            $hasil = trim(Helper::penyebut($nilai));
        }
        return $hasil;
    }

    public static function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $temp  = "";

        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = Helper::penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = Helper::penyebut($nilai / 10) . " Puluh" . Helper::penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . Helper::penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = Helper::penyebut($nilai / 100) . " Ratus" . Helper::penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . Helper::penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = Helper::penyebut($nilai / 1000) . " Ribu" . Helper::penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = Helper::penyebut($nilai / 1000000) . " Juta" . Helper::penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = Helper::penyebut($nilai / 1000000000) . " Milyar" . Helper::penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = Helper::penyebut($nilai / 1000000000000) . " Triliun" . Helper::penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    public static function getUppercaseChars($inputString)
    {
        $uppercaseChars = '';

        // Loop through each character in the string
        for ($i = 0; $i < strlen($inputString); $i++) {
            $char = $inputString[$i];

            // Check if the character is uppercase
            if (ctype_upper($char)) {
                // Append the uppercase character to the result string
                $uppercaseChars .= $char;
            }
        }

        return $uppercaseChars;
    }

    public static function changeFormatSymbol($string)
    {
        $charactersToReplace = ['\\', '/', ':', '*', '?', '<', '>', '|'];
        $replacement         = '-';

        $newString = \Str::replace($charactersToReplace, $replacement, $string);
        return $newString;
    }

    public static function formatNumber($angka)
    {
        return number_format($angka, 0, ",", ".");
    }

    /**
     * Summary of getEnumValues
     * @param mixed $table
     * @param mixed $column
     * @param mixed $deleteColumn [array]
     * @return array
     */
    public static function getEnumValues($table, $column, $deleteColumn = false)
    {
        $type = \DB::select(\DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];

        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            array_push($enum, $v);
        }

        if ($deleteColumn != false) {
            foreach ($deleteColumn as $column) {
                $key = array_search($column, $enum);
                if ($key !== false) {
                    unset($enum[$key]);
                }

            }
            $enum = array_values($enum);
        }
        return $enum;
    }

    public static function getColorCode($color)
    {
        switch ($color) {
            case 'primary':
                $code = '#3B71CA';
                break;
            case 'success':
                $code = '#14A44D';
                break;
            case 'warning':
                $code = '#E4A11B';
                break;
            case 'danger':
                $code = '#DC4C64';
                break;
            case 'secondary':
                $code = '#9FA6B2';
                break;
            case 'dark':
                $code = '#332D2D';
                break;
            default:
                $code = '#54B4D3';
        }
        return $code;
    }

    public static function getColorStatus($status)
    {
        $color = [
            'daftar'         => 'info',
            'diterima'       => 'success',
            'tidak diterima' => 'danger',
            'aktif'          => 'success',
            'tidak aktif'    => 'danger',
            'cuti'           => 'secondary',
            'lulus'          => 'info',
        ];

        return $color[$status];
    }

    public static function changeName($string)
    {
        $charactersToReplace = ['\\', '/', ':', '*', '?', '<', '>', '|', '-', '_'];
        $replacement         = ' ';

        $newString = \Str::replace($charactersToReplace, $replacement, $string);
        return \Str::upper($newString);
    }

    public static function removeSpecialCharacters($string)
    {
        $cleanedString = preg_replace('/[^a-zA-Z0-9\s]/', ' ', $string);
        $cleanedString = preg_replace('/\s+/', ' ', $cleanedString); // Remove extra spaces
        return trim($cleanedString);
    }

    public function checkRegister()
    {
        $tahun = Tahun::aktif();

        $jadwal = Jadwal::where('tahun_id', $tahun->id)->first();

        $mulai    = \Carbon::parse($jadwal->mulai)->startOfDay();
        $berakhir = \Carbon::parse($jadwal->berakhir)->endOfDay();
        $sekarang = \Carbon::now();

        $dibuka = true;
        if ($sekarang->lt($mulai) || $sekarang->gt($berakhir)) {
            $dibuka = false;
        }

        return $dibuka;
    }

    public static function generateRandomString($length = 8)
    {
        return rand(12345, 54321);
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $charactersLength = strlen($characters);
        // $randomString = '';
        // for ($i = 0; $i < $length; $i++) {
        //     $randomString .= $characters[rand(0, $charactersLength - 1)];
        // }
        // return $randomString;
    }

    public static function getTheme()
    {
        $theme = \Cookie::get('theme');
        $theme = $theme ? $theme : 'light';
        return $theme;
    }

    public static function setTheme($theme)
    {
        \Cookie::queue(\Cookie::forever('theme', $theme));
        return 'success';
    }

    public static function getColorAbsensi($status)
    {
        switch ($status) {
            case 'Hadir':
                $color = 'success';
                break;
            case 'Izin':
                $color = 'warning';
                break;
            case 'Sakit':
                $color = 'info';
                break;
            case 'Tidak Hadir':
                $color = 'danger';
                break;
        }

        return $color;
    }

    public static function getBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
            case 2:
                return "Februari";
            case 3:
                return "Maret";
            case 4:
                return "April";
            case 5:
                return "Mei";
            case 6:
                return "Juni";
            case 7:
                return "Juli";
            case 8:
                return "Agustus";
            case 9:
                return "September";
            case 10:
                return "Oktober";
            case 11:
                return "November";
            case 12:
                return "Desember";
        }
    }

    public static function formatDate($date)
    {
        $date = explode('-', $date);
        return $date[2] . ' ' . self::getBulan($date[1]) . ' ' . $date[0];
    }

    public static function formattedArray($elements, $required = false)
    {
        $formattedArray = [];
        $requiredItems  = [];

        if ($required) {
            $requiredItems = $required;
        }
        foreach ($elements as $element) {
            $id = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $element));

            $formattedArray[] = [
                'id'       => $id,
                'name'     => $element,
                'required' => ! in_array($element, $requiredItems) ? "required" : "",
            ];
        }

        return $formattedArray;
    }

    public static function getExtension($mimeType)
    {
        $extension = '';
        switch ($mimeType) {
            // Format Dokumen Microsoft Office
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $extension = '.docx'; // Word Document (modern)
                break;
            case 'application/msword':
                $extension = '.doc'; // Word Document (legacy)
                break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $extension = '.xlsx'; // Excel Spreadsheet
                break;
            case 'application/vnd.ms-excel':
                $extension = '.xls'; // Excel Spreadsheet (legacy)
                break;
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                $extension = '.pptx'; // PowerPoint Presentation
                break;
            case 'application/vnd.ms-powerpoint':
                $extension = '.ppt'; // PowerPoint Presentation (legacy)
                break;

            // Format PDF
            case 'application/pdf':
                $extension = '.pdf'; // PDF Document
                break;

            // Format Dokumen Teks
            case 'text/plain':
                $extension = '.txt'; // Plain Text
                break;
            case 'application/rtf':
                $extension = '.rtf'; // Rich Text Format
                break;
            case 'application/vnd.oasis.opendocument.text':
                $extension = '.odt'; // OpenDocument Text (LibreOffice)
                break;
            case 'application/vnd.oasis.opendocument.spreadsheet':
                $extension = '.ods'; // OpenDocument Spreadsheet (LibreOffice)
                break;
            case 'application/vnd.oasis.opendocument.presentation':
                $extension = '.odp'; // OpenDocument Presentation (LibreOffice)
                break;

            // Format HTML dan Markup
            case 'text/html':
                $extension = '.html'; // HTML Document
                break;
            case 'application/xhtml+xml':
                $extension = '.xhtml'; // XHTML Document
                break;

            // Format XML
            case 'application/xml':
                $extension = '.xml'; // XML Document
                break;

            // Tambahan format dokumen lainnya
            case 'application/epub+zip':
                $extension = '.epub'; // ePub Document
                break;
            case 'application/x-mobipocket-ebook':
                $extension = '.mobi'; // Mobi Document (eBook)
                break;

            // Format default jika tidak ditemukan
            default:
                $extension = ''; // Jika tipe MIME tidak dikenali
                break;
        }
        return $extension;
    }

    public static function getArabicWordsWithMeaning($count = 100)
    {
        // Daftar kata Arab beserta artinya
        $arabicWords = [
            ['word' => 'سلام', 'indonesia' => 'Damai'],
            ['word' => 'مرحبا', 'indonesia' => 'Halo'],
            ['word' => 'كتاب', 'indonesia' => 'Buku'],
            ['word' => 'قلم', 'indonesia' => 'Pena'],
            ['word' => 'طاولة', 'indonesia' => 'Meja'],
            ['word' => 'كرسي', 'indonesia' => 'Kursi'],
            ['word' => 'مدرسة', 'indonesia' => 'Sekolah'],
            ['word' => 'مدينة', 'indonesia' => 'Kota'],
            ['word' => 'بيت', 'indonesia' => 'Rumah'],
            ['word' => 'شجرة', 'indonesia' => 'Pohon'],
            ['word' => 'سماء', 'indonesia' => 'Langit'],
            ['word' => 'أرض', 'indonesia' => 'Tanah'],
            ['word' => 'بحر', 'indonesia' => 'Laut'],
            ['word' => 'نهر', 'indonesia' => 'Sungai'],
            ['word' => 'طفل', 'indonesia' => 'Anak'],
            ['word' => 'أب', 'indonesia' => 'Ayah'],
            ['word' => 'أم', 'indonesia' => 'Ibu'],
            ['word' => 'أخ', 'indonesia' => 'Saudara laki-laki'],
            ['word' => 'أخت', 'indonesia' => 'Saudara perempuan'],
            ['word' => 'صديق', 'indonesia' => 'Teman'],
            ['word' => 'حب', 'indonesia' => 'Cinta'],
            ['word' => 'نور', 'indonesia' => 'Cahaya'],
            ['word' => 'ظلام', 'indonesia' => 'Kegelapan'],
            ['word' => 'مال', 'indonesia' => 'Uang'],
            ['word' => 'ساعة', 'indonesia' => 'Jam'],
            ['word' => 'وقت', 'indonesia' => 'Waktu'],
            ['word' => 'عمل', 'indonesia' => 'Pekerjaan'],
            ['word' => 'صلاة', 'indonesia' => 'Shalat'],
            ['word' => 'قرآن', 'indonesia' => 'Al-Quran'],
            ['word' => 'دين', 'indonesia' => 'Agama'],
            ['word' => 'خير', 'indonesia' => 'Kebaikan'],
            ['word' => 'شر', 'indonesia' => 'Keburukan'],
            ['word' => 'حياة', 'indonesia' => 'Hidup'],
            ['word' => 'موت', 'indonesia' => 'Kematian'],
            ['word' => 'سلامة', 'indonesia' => 'Keselamatan'],
            ['word' => 'علم', 'indonesia' => 'Ilmu'],
            ['word' => 'جهل', 'indonesia' => 'Kebodohan'],
            ['word' => 'قوة', 'indonesia' => 'Kekuatan'],
            ['word' => 'ضعف', 'indonesia' => 'Kelemahan'],
            ['word' => 'شمس', 'indonesia' => 'Matahari'],
            ['word' => 'قمر', 'indonesia' => 'Bulan'],
            ['word' => 'نجمة', 'indonesia' => 'Bintang'],
            ['word' => 'حديقة', 'indonesia' => 'Taman'],
            ['word' => 'زهرة', 'indonesia' => 'Bunga'],
            ['word' => 'طير', 'indonesia' => 'Burung'],
            ['word' => 'سمك', 'indonesia' => 'Ikan'],
        ];

        // Ambil kata secara acak
        $selectedWords = array_rand($arabicWords, min($count, count($arabicWords)));

        // Jika hanya satu kata, jadikan array
        if (! is_array($selectedWords)) {
            $selectedWords = [$selectedWords];
        }

        // Format hasil: kata => arti
        $result = [];
        foreach ($selectedWords as $word) {
            $result[$word] = $arabicWords[$word];
        }

        return $result;
    }

    public static function getDepartemen()
    {
        return Departemen::all();
    }

    public static function getSheet(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('temp'); // simpan sementara

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path("app/{$path}"));

        $sheetNames = $spreadsheet->getSheetNames();
        $sheetCount = $spreadsheet->getSheetCount();

        return [
            'jumlah_sheet' => $sheetCount,
            'nama_sheet'   => $sheetNames,
        ];
    }

    public static function uploadFile($file, $prefixName, $destination)
    {
        $extension = $file->getClientOriginalExtension();
        $filename  = $prefixName . '-' . time() . '.' . $extension;
        $path      = public_path($destination);

        if (! file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $file->move($path, $filename);

        return $filename;
    }

    public static function deleteFile($nameFile, $destination)
    {
        $path = public_path($destination);
        $file = $path . '/' . $nameFile;
        // use unlink
        if (file_exists($file)) {
            unlink($file);

            return true;
        }

        return false;
    }

    public static function hitungUmur($tanggalLahir)
    {
        return Carbon::parse($tanggalLahir)->age;
    }

}
