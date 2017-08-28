var gulp = require('gulp'),
    environment = 'undefined' !== typeof process.env.NODE_ENV ? process.env.NODE_ENV : 'development';

var less = require('gulp-less'),
    path = require('path'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat');

var LessPluginCleanCSS = require('less-plugin-clean-css'),
    LessPluginAutoPrefix = require('less-plugin-autoprefix'),
    cleancss = new LessPluginCleanCSS({
        advanced: true
    }),
    autoprefix = new LessPluginAutoPrefix({
        browsers: ['last 2 versions']
    });

// Less
gulp.task('less', function () {
    var files = [
        'node_modules/bootstrap/less/bootstrap.less',
        '../less/style.less'
    ];

    return gulp.src(files)
        .pipe(concat('style.less'))
        .pipe(less({
            paths: ['node_modules/bootstrap/less'],
            plugins: 'production' === environment ? [autoprefix, cleancss] : [autoprefix]
        }))
        .pipe(gulp.dest('../public/css'));
});

// JavaScript
gulp.task('js', function() {
    var files = [
        'node_modules/jquery/dist/jquery.js',
        'node_modules/jquery.scrollto/jquery.scrollTo.js',
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'node_modules/angular/angular.js',
        'node_modules/angular-bootstrap/ui-bootstrap-tpls.js',
        'node_modules/angular-file-upload/dist/angular-file-upload.js',
        'node_modules/angular-route/angular-route.js',
        'app/**/*.js'
    ];

    var stream = gulp.src(files);

    if ('production' === environment) {
        stream = stream.pipe(uglify());
    }

    return stream
        .pipe(concat('app.js'))
        .pipe(gulp.dest('../public/js'));
});

// Fonts
gulp.task('fonts', function() {
    return gulp.src('node_modules/bootstrap/dist/fonts/**/*')
        .pipe(gulp.dest('../public/fonts'));
});

// Watch
gulp.task('watch', function() {
    gulp.watch('../less/**/*.less', ['less']);
    gulp.watch('app/**/*.js', ['js']);
});

var tasks = ['less', 'js', 'fonts'];

if ('development' === environment) {
    tasks.push('watch');
}

gulp.task('default', tasks);
