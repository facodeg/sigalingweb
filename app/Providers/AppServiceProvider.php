<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Filesystem\FilesystemAdapter;

// Tambahan Google Drive
use Google_Client;
use Google\Service\Drive as GoogleDriveService;
use League\Flysystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon ke Bahasa Indonesia
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8');

        // Tambahkan disk "google" untuk Google Drive
        Storage::extend('google', function ($app, $config) {
            // Inisialisasi Google Client
            $client = new Google_Client();
            $credentialsPath = $config['service_account_credentials_json'] ?? storage_path('app/google/sigaling.json');
            $client->setAuthConfig($credentialsPath);
            $client->addScope(GoogleDriveService::DRIVE);

            // Buat service dan adapter Google Drive
            $service = new GoogleDriveService($client);
            $folderId = $config['folder_id'] ?? null;
            $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $folderId);

            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem, $adapter, $config);
        });
    }
}