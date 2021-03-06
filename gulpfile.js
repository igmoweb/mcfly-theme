var gulp = require('gulp');
var rename = require('gulp-rename');
var babel = require('gulp-babel');
var uglifyCSS = require( 'gulp-uglifycss' );
var uglify = require( 'gulp-uglify' );
var concat = require("gulp-concat");
var clean = require('gulp-clean');
var wpPot = require('gulp-wp-pot');
var sort = require('gulp-sort');
var zip = require('gulp-zip');
var $    = require('gulp-load-plugins')();

var sassPaths = [
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];

var js_files = [
    './bower_components/foundation-sites/js/foundation.core.js',
    './bower_components/foundation-sites/js/foundation.util.mediaQuery.js',
    './bower_components/foundation-sites/js/foundation.dropdownMenu.js',
    './bower_components/foundation-sites/js/foundation.responsiveToggle.js',
    './bower_components/foundation-sites/js/foundation.util.touch.js'
];

gulp.task( 'clear-build', function() {
    return gulp.src('./mcfly/', {read: false})
        .pipe(clean());
});

/**
 * Concat needed JS Files
 */
gulp.task( 'javascript', function() {
    // Tale only needed JS
    return gulp.src(js_files)
        .pipe(babel())
        .pipe(concat('foundation.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./js'));
});

gulp.task('sass', function() {
    return gulp.src('scss/app.scss')
        .pipe($.sass({
            includePaths: sassPaths,
            outputStyle: 'compressed' // if css compressed **file size**
        })
            .on('error', $.sass.logError))
        .pipe($.autoprefixer({
            browsers: ['last 2 versions', 'ie >= 9']
        }))
        .pipe(rename('mcfly.css'))
        .pipe(gulp.dest('css'));
});

gulp.task('default', ['sass'], function() {
  gulp.watch(['scss/**/*.scss'], ['sass']);
});

gulp.task('pot', function () {
    return gulp.src('*/**/*.php')
        .pipe(sort())
        .pipe(wpPot( {
            domain: 'mcfly',
            destFile:'mcfly.pot',
            package: 'McFly Theme',
            bugReport: 'http://mcfly.es',
            lastTranslator: 'John Doe <mail@example.com>',
            team: 'Team Team <mail@example.com>'
        } ))
        .pipe(gulp.dest('languages'));
});

gulp.task('zip', () => {
    return gulp.src('mcfly/*')
        .pipe(zip('mcfly.zip'))
        .pipe(gulp.dest('mcfly'));
});

gulp.task('build', ['sass','javascript','clear-build','pot', 'zip'], function() {

    // Copy JS
    gulp.src(
        [
            './**/*',
            '!node_modules/**',
            '!node_modules/',
            '!scss/**',
            '!scss/',
            '!*.md',
            '!*.json',
            '!gulpfile.js',
            '!pasos-migracion',
            '!bower_components/**',
            '!bower_components/',
        ]
    )
        .pipe(gulp.dest('./mcfly/'));

});
