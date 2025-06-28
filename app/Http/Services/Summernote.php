<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\File;

class Summernote
{
    /**
     * @param $isi : $request->isi
     * @param $lokasi : "upload/informasi/"
     * @return mixed dom->saveHTML();
     */
    public static function generate($isi, $lokasi)
    {
        $dom = new \DomDocument();
        @$dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        $paths = array();
        foreach ($images as $k => $img) {
            $dataImage = $img->getAttribute('src');
            if (explode(":", $dataImage)[0] == "data") {
                $fileName = $img->getAttribute('data-filename');
                list($type, $dataImage) = explode(';', $dataImage);
                list(, $dataImage) = explode(',', $dataImage);
                $dataImage = base64_decode($dataImage);
                // $extensi = explode('/', $type)[1];
                $image_name = 'Foto' . date('YmdHis') . uniqid() . $fileName;
                $path = public_path($lokasi . $image_name);

                // Save the decoded image using the move method
                file_put_contents($path, $dataImage);
                // Update the img element's src attribute
                $img->removeAttribute('src');
                $img->setAttribute('src', asset($lokasi . $image_name));

                $paths[] = $path;
            }
        }
        return [
            'data' => $dom->saveHTML(),
            'paths' => $paths
        ];
    }

    /**
     * @param $edit : data edit from eluquent, MUST HAVE column isi
     * @param $isi : $request->isi
     * @param $lokasi : "upload/informasi/"
     * @return mixed dom->saveHTML();
     */
    public static function generateForEdit($editIsi, $isiRequest, $lokasi)
    {
        // isiLama dan isiBaru untuk pencarian isiDelete -> isiDelete file yang dihapus
        $isiLama = [];
        $isiBaru = [];
        $isiDelete = [];
        if ($editIsi != '' && $editIsi != null) {
            $isi = $editIsi;
            $dom = new \DomDocument();
            @$dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');

            foreach ($images as $k => $img) {
                $isiLama[] = [
                    "src" => $img->getAttribute('src'),
                    "filename" => $img->getAttribute('data-filename'),
                ];
            }
        }

        $isi = $isiRequest;
        $dom = new \DomDocument();
        @$dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {
            $dataImage = $img->getAttribute('src');
            // if (explode(":", $dataImage)[0] == "data") {
            if (preg_match('/^data:image\/([a-zA-Z]*);base64,/', $dataImage, $matches)) {

                $fileName = $img->getAttribute('data-filename');
                list($type, $dataImage) = explode(';', $dataImage);
                list(, $dataImage) = explode(',', $dataImage);
                $dataImage = base64_decode($dataImage);
                // $extensi = explode('/', $type)[1];
                $image_name = 'Foto' . date('YmdHis') . uniqid() . $fileName;
                $path = public_path($lokasi . $image_name);
                // Save the decoded image using the move method
                file_put_contents($path, $dataImage);

                // Update the img element's src attribute
                $img->removeAttribute('src');
                $img->setAttribute('src', asset($lokasi . $image_name));
            } else {
                // isi isiBaru
                $isiBaru[] = [
                    "src" => $img->getAttribute('src'),
                    "filename" => $img->getAttribute('data-filename'),
                ];
            }
        }

        // Tidak ada di isiBaru, maka masukkan ke isiDelete
        foreach ($isiLama as $il) {
            $checkDelete = false;
            foreach ($isiBaru as $ib) {
                if ($il['src'] == $ib['src']) {
                    $checkDelete = true;
                }
            }
            if (!$checkDelete) {
                $isiDelete[] = $il;
            }
        }

        // delete isiDelete
        if (count($isiDelete) > 0) {
            foreach ($isiDelete as $k => $img) {
                $dataImage = rawurldecode($img['src']);
                $extensi = explode('.', $img['filename']);
                $extensi = end($extensi);
                $filename = pathinfo($dataImage, PATHINFO_FILENAME);
                if ($filename != null) {
                    File::delete(public_path($lokasi . $filename . '.' . $extensi));
                }
            }
        }

        $isi = $dom->saveHTML();
        return [
            'data' => $isi,
            'paths' => [],
        ];
    }

    /**
     * @param $edit : data edit from eluquent, MUST HAVE column isi
     * @param $isi : $request->isi
     * @param $lokasi : "upload/informasi/"
     */
    public static function deleteImage($isi, $lokasi)
    {
        // delete image summernote
        $dom = new \DomDocument();
        @$dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        $paths = [];
        foreach ($images as $k => $img) {
            $dataImage = rawurldecode($img->getAttribute('src'));
            $extensi = explode('.', $img->getAttribute('data-filename'));
            $extensi = end($extensi);
            $filename = pathinfo($dataImage, PATHINFO_FILENAME);
            $path = $lokasi . $filename . '.' . $extensi;
            if ($filename != null) {
                if(File::delete(public_path($path))){
                    $paths[] = $path;
                };
            }
            // $dataImage = $img->getAttribute('src');
            // $dataImage = str_replace(config('app.url'), '', $dataImage);
            // $dataImage = public_path($dataImage);
            // $dataImage = rawurldecode($dataImage);
            // if (File::exists($dataImage)) {
            //     File::delete($dataImage);
            // }
        }

        return [
            'status' => true,
            'paths' => $paths,
        ];
    }

    /**
     * @param $paths : data paths
     */
    public static function deleteImageFromPaths($paths)
    {
        if (!$paths) {
            return false;
        }

        foreach ($paths as $key => $value) {
            File::delete($value);
        }

        return true;
    }

    /**
     * clean formated from summernote
     * @param mixed $text
     * @return string
     */
    public static function clean($text)
    {
        $dom = new \DOMDocument;
        libxml_use_internal_errors(true); // Suppress errors due to malformed HTML
        $dom->loadHTML($text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Find all <img> tags and remove them
        $images = $dom->getElementsByTagName('img');
        while ($images->length > 0) {
            $images->item(0)->parentNode->removeChild($images->item(0));
        }

        // Output cleaned HTML
        $cleanedHtml = $dom->saveHTML();
        $cleanedHtml = trim(strip_tags($cleanedHtml));

        return $cleanedHtml;
    }
}