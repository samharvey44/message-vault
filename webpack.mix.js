const mix = require("laravel-mix");

mix.sass("resources/css/app.scss", "build/css/app.css");
mix.sass("resources/css/livewire/home.scss", "build/css/livewire/home.css");

mix.js("resources/js/app.js", "build/js/app.js");
mix.js("resources/js/livewire/home.js", "build/js/livewire/home.js");
mix.js(
    "resources/js/livewire/preview-secret.js",
    "build/js/livewire/preview-secret.js"
);

if (mix.inProduction()) {
    mix.version();
}
