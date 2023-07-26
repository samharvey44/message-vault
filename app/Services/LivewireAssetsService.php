<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;

class LivewireAssetsService
{
    public function getStyles(): ?string
    {
        $routeName = Request::route()->getName();
        $styles = sprintf('%s/css/livewire/%s.scss', resource_path(), $routeName);

        if (!file_exists($styles)) {
            return null;
        }

        $mix = mix(sprintf('build/css/livewire/%s.css', $routeName));

        return <<<HTML
            <link href="{$mix}" rel="stylesheet" type="text/css" />
        HTML;
    }

    public function getScripts(): ?string
    {
        $routeName = Request::route()->getName();
        $scripts = sprintf('%s/js/livewire/%s.js', resource_path(), $routeName);

        if (!file_exists($scripts)) {
            return null;
        }

        $mix = mix(sprintf('build/js/livewire/%s.js', $routeName));

        return <<<HTML
            <script src="{$mix}" type="text/javascript"></script>
        HTML;
    }
}
