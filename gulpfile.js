/**
 * https://gulpjs.com/docs/en/getting-started/quick-start
 * npm rm --global gulp
 *
* npm install --global gulp-cli
* npm install --save-dev gulp
* */
var gulp = require('gulp');
/**
 * npm install --save-dev gulp-concat
 */
var concat = require('gulp-concat');
/**
 * npm install --save-dev gulp-uglify
 */
var uglify = require('gulp-uglify');
/**
 * npm install gulp-clean-css --save-dev
 */
let cleanCSS = require('gulp-clean-css');


/**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
 | Tasks
 *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/

gulp.task('welcome-message', function () {
    return console.log('Welcome Glup');
});

gulp.task('minify-js', function () {
    return gulp.src('./assets/star/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./assets/star/'));
});

/*
* https://varvy.com/tools/js/
* */
gulp.task('footer-js', function () {
    return gulp.src(['./assets/star/js/popper.min.js',
        './assets/star/js/bootstrap.min.js',
        './assets/star/js/jquery-ui.js',
        './assets/star/js/jquery.fancybox.js',
        './assets/star/js/owl.js',
        './assets/star/js/wow.js',
        './assets/star/js/isotope.js',
        './assets/star/js/appear.js',
        './assets/star/js/jquery.raty.min.js',
        './assets/star/js/jquery-sortable-min.js',
        './assets/star/js/jquery.inputmask.min.js',
        './assets/star/js/jquery.ticker.js',
        './assets/star/js/custom.js',
        './assets/star/js/my_app.js',
        './assets/star/js/site_srcipt.js',
        './assets/star/js/advanced_search.min.js',
        './assets/star/js/archive_property.min.js',
        ]
    )
        .pipe(concat('footer.js'))
        .pipe(gulp.dest('./assets/star/'));
});


gulp.task('head-js', function () {
    return gulp.src(['./assets/star/js/jquery.js',
        './assets/star/js/simpleUpload.min.js',
        './assets/star/js/select2.full.min.js',
        './assets/star/app/js/bootbox.min.js',
        './assets/star/js/validate.js',
        './assets/star/plugins/bootstrap-switch/bootstrap-switch.min.js',
        './assets/star/js/jquery.cookie.js',
        './assets/star/js/numeral.min.js',
        ]
    )
    .pipe(concat('head.js'))
    .pipe(gulp.dest('./assets/star/'));
});

gulp.task('head-css', function () {
    return gulp.src(['./assets/star/css/style0.css',
        './assets/star/css/style01.css',
        './assets/star/css/style02.css',
        './assets/star/css/style03.css',
        './assets/star/css/main.min.css',
        './assets/star/css/owl.carousel.min.css',
        './assets/star/css/lightgallery.min.css',
        './assets/star/css/single-property.min.css',
        './assets/star/css/listing-property-taxonomy.min7d4c.css',
        './assets/star/css/perfect-scrollbar.min.css',
        './assets/star/css/style7.css',
        './assets/star/css/property-advanced-search.min7d4c.css',
        './assets/star/css/style3.css',
        './assets/star/css/style4.css',
        './assets/star/css/style8e83.css',
        './assets/star/css/style8e83-3.css',
        './assets/star/css/mortgage-calculator.min7d4c.css',
        './assets/star/css/top-agents.min7d4c.css',
        './assets/star/css/advanced_search.min.css',
        './assets/star/css/custom2.css',
        './assets/star/css/animate.css',
        './assets/star/css/custom.css',
        './assets/star/css/slide.css',
        './assets/star/css/line-awesome.css',
        './assets/star/css/jquery.fancybox.min.css',
        './assets/star/css/dev.css',
        './assets/star/css/select2.min.css',
        ]
    )
        .pipe(concat('head.min.css'))
        //.pipe(cleanCSS())
        .pipe(gulp.dest('./assets/star/'));
});


gulp.task('compress-css', function () {
    return gulp.src(['./assets/star/head.min.css',])
        .pipe(cleanCSS())
        .pipe(gulp.dest('./assets/star/'));
});