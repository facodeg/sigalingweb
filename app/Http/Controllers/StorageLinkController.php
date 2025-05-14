<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StorageLinkController extends Controller
{
    public function createLink()
    {
        $target = storage_path('app/public');
        $link = public_path('storage');

        if (file_exists($link)) {
            return 'The storage link already exists.';
        }

        File::link($target, $link);

        return 'Storage link created successfully.';
    }
}