<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;

class LivewireAssetsService
{
    private function getExpectedFilename(): string
    {
        return str_replace('.', '-', Request::route()->getName());
    }

    public function getStyles(): ?string
    {
        $fileName = $this->getExpectedFilename();
        $styles = sprintf('%s/css/livewire/%s.scss', resource_path(), $fileName);

        if (!file_exists($styles)) {
            return null;
        }

        $mix = mix(sprintf('build/css/livewire/%s.css', $fileName));

        return <<<HTML
            <link href="{$mix}" rel="stylesheet" type="text/css" />
        HTML;
    }

    public function getScripts(): ?string
    {
        $fileName = $this->getExpectedFilename();
        $scripts = sprintf('%s/js/livewire/%s.js', resource_path(), $fileName);

        if (!file_exists($scripts)) {
            return null;
        }

        $mix = mix(sprintf('build/js/livewire/%s.js', $fileName));

        return <<<HTML
            <script src="{$mix}" type="text/javascript"></script>
        HTML;
    }
}
