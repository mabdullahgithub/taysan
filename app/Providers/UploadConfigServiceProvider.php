<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UploadConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set upload limits for banner uploads
        ini_set('upload_max_filesize', '10M');
        ini_set('post_max_size', '12M');
        ini_set('max_execution_time', 300);
        ini_set('max_input_time', 300);
    }
}
