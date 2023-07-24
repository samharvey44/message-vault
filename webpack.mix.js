const mix = require("laravel-mix");

mix.sass("resources/css/app.scss", "build/css/app.css");
mix.js("resources/js/app.js", "build/js/app.js");

mix.js("resources/js/new-message.js", "build/js/new-message.js");

if (mix.inProduction()) {
    mix.version();
}
