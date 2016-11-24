var gulp        = require('gulp'),
    environment = 'undefined' !== typeof process.env.NODE_ENV ? process.env.NODE_ENV : 'development';

var less = require('gulp-less'),
    path = require('path');

var LessPluginCleanCSS = require('less-plugin-clean-css'),
    LessPluginAutoPrefix = require('less-plugin-autoprefix'),
    cleancss = new LessPluginCleanCSS({
        advanced: true
    }),
    autoprefix = new LessPluginAutoPrefix({
        browsers: ["last 2 versions"]
    });

var mainBowerFiles = require('main-bower-files'),
    uglify         = require('gulp-uglify'),
    concat         = require('gulp-concat'),
    chmod          = require('gulp-chmod');

// Less
gulp.task('less', function () {
    var lessFiles   = mainBowerFiles('**/*.less'),
        includePath = [];

    for (var i = 0; i < lessFiles.length; i++) {
        includePath.push(path.dirname(lessFiles[i]));
    }

    console.log('Bower less files: ', lessFiles);
    lessFiles.push('../less/style.less');

    return gulp.src(lessFiles)
        .pipe(concat('style.less'))
        .pipe(less({
            paths: includePath,
            plugins: 'production' === environment ? [autoprefix, cleancss] : [autoprefix]
        }))
        .pipe(gulp.dest('../public/css'));
});

// JavaScript
gulp.task('js', function() {
    var jsFiles = mainBowerFiles('**/*.js');

    console.log('Bower js files: ', jsFiles);
    jsFiles.push('app/**/*.js');

    var stream = gulp.src(jsFiles);

    if ('production' === environment) {
        stream = stream.pipe(uglify());
    }

    return stream
        .pipe(concat('app.js'))
        //.pipe(chmod(666))
        .pipe(gulp.dest('../public/js'));
});

// Fonts
gulp.task('fonts', function() {
    return gulp.src('bower_components/bootstrap/fonts/**/*')
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
