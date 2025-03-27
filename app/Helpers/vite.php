<?php

if (!function_exists('vite_assets')) {
    function vite_assets() {
        $manifestPath = public_path('build/manifest.json');
        
        if (!file_exists($manifestPath)) {
            return [
                'css' => asset('css/app.css'),
                'js' => asset('js/app.js')
            ];
        }
        
        $manifest = json_decode(file_get_contents($manifestPath), true);
        
        return [
            'css' => asset('build/' . $manifest['resources/css/app.css']['file']),
            'js' => asset('build/' . $manifest['resources/js/app.js']['file'])
        ];
    }
} 