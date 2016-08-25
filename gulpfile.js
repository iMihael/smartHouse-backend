var gulp = require('gulp'),
    concat = require('gulp-concat');

var dev = true;

var js = [
    './node_modules/jquery/dist/jquery.min.js',
    './node_modules/bootstrap/dist/js/bootstrap.min.js',
//    './node_modules/angular/angular.min.js',
//    './node_modules/angular-resource/angular-resource.min.js',
//    './node_modules/angular-ui-switch/angular-ui-switch.min.js',
//    './public/js/src/**/*.js'
];

var css = [
    //'./node_modules/angular-ui-switch/angular-ui-switch.min.css',
    //'./public/css/src/style.css'
    //'./node_modules/bootstrap/dist/css/bootstrap.min.css',
    './node_modules/bootswatch/simplex/bootstrap.min.css',
    './web/css/style.css'
];

var fonts = './node_modules/bootstrap/dist/fonts/**/*.{ttf,woff,eof,svg,woff2,eot}';

gulp.task('copyfonts', function(){
    gulp.src(fonts).pipe(gulp.dest('./web/fonts'));
});

gulp.task('js', function () {
    gulp.src(js)
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./web/js'))
});

gulp.task('css', function () {
    gulp.src(css)
        .pipe(concat('app.css'))
        .pipe(gulp.dest('./web/css'))
});

if(dev) {
    gulp.task('default', ['js', 'css', 'copyfonts'], function () {
        gulp.watch('./web/js/**/*.js', ['js']);
        gulp.watch('./web/css/**/*.css', ['css']);
    });
} else {
    gulp.task('default', ['js', 'css', 'copyfonts']);
}