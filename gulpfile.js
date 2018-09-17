var gulp         = require( 'gulp' );
var sass         = require( 'gulp-sass' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var autoprefixer = require( 'gulp-autoprefixer' );
var postcss      = require( 'gulp-postcss' );
var imagemin     = require( 'gulp-imagemin' );
var rename       = require( 'gulp-rename' );
var gulpPrettyDiff = require("gulp-prettydiff");
var browserSync  = require( 'browser-sync' ).create();

// Paths

var susy    = './node_modules/susy/sass';
var bourbon = './node_modules/bourbon/app/assets/stylesheets';

// Start browserSync & watch css & html changes

gulp.task( 'watch', ['sass'], function() {
    browserSync.init({
        proxy: "http://127.0.0.1/wordpress",
        port: 8000
    });
    gulp.watch( './sass/*.scss', ['sass']).on( 'change', browserSync.reload );
    gulp.watch( '*.html' ).on( 'change', browserSync.reload );
});

gulp.task( 'sass', function() {
    return gulp.src( './sass/**/*.scss' )
        .pipe( sourcemaps.init() )
        .pipe( sass({
            includePaths: [susy, bourbon],
            sourceComments: true,
            outputStyle: 'compressed'
        }).on( 'error', sass.logError ) )
        .pipe( autoprefixer(  ) )
        .pipe( sourcemaps.write( './maps' ) )
        .pipe( gulp.dest( './css' ) )
        .pipe( browserSync.stream() );
});

gulp.task('scss', function() {
    return gulp.src('./sass/*.scss')
        .pipe(gulpPrettyDiff({
            lang: 'scss',
            mode: 'beautify'
        }))
        .pipe( gulp.dest("./sass") );
});

// Minify

gulp.task('min', function () {
    var processors = [
      require('css-mqpacker'),
      require('cssnano'),
    ];
    return gulp.src('./css/style.css')
      .pipe(postcss(processors))
      .pipe(rename({suffix: '.min'}))
      .pipe(gulp.dest('./css'));
});

// Compress images

gulp.task( 'imagemin', function() {
    return gulp.src( './img/**/*.+(png|jpg|jpeg|gif)' )
        .pipe( imagemin() )
        .pipe( gulp.dest( './img/optimized' ) );
});

gulp.task( 'default', ['watch']);
