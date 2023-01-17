const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js").postCss(
    "resources/css/app.css",
    "public/css",
    [
        //
    ]
);

mix.js("resources/js/admin/candidate.js", "public/js/admin");
mix.js("resources/js/admin/skills.js", "public/js/admin");
mix.js("resources/js/admin/blacklist.js", "public/js/admin");
mix.js("resources/js/remove-ajax.js", "public/js");
mix.css("resources/css/client_style.css", "public/css");
mix.js("resources/js/paginate.js", "public/js");
mix.js("resources/js/company/search.js", "public/js/company");
mix.js("resources/js/client/create_cv.js", "public/js/client");
mix.js("resources/js/client/shortlist.js", "public/js/client");

