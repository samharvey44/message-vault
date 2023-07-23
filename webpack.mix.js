const mix = require("laravel-mix");

mix.sass("resources/css/app.scss", "mix/css/app.css");

if (mix.inProduction()) {
    mix.version();
}
