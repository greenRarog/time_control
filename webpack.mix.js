const mix = require('laravel-mix');

mix.styles('resources/css/app.css', 'public/css/app.css')
mix.styles('resources/css/adminPanel.css', 'public/css/adminPanel.css')
mix.js('resources/js/handmade_script.js', 'public/js/handmade_script.js')
mix.js('resources/js/week_wrapper.js', 'public/js/week_wrapper.js')
mix.js('frontend/src/app.js', 'public/js/app.js').react()
