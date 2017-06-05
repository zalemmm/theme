var gulp         = require( 'gulp' );
var sass         = require( 'gulp-sass' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var autoprefixer = require( 'gulp-autoprefixer' );
var browserSync  = require( 'browser-sync' ).create();

// Start browserSync & watch css & html changes

gulp.task( 'watch', ['sass'], function() {
  browserSync.init({
      server: {
          baseDir: "./"
      }
  });
  gulp.watch( './sass/**/*.scss', ['sass']);
  gulp.watch( '*.html' ).on( 'change', browserSync.reload );
});

gulp.task( 'sass', function() {
    return gulp.src( './sass/**/*.scss' )
        .pipe( sourcemaps.init() )
        .pipe( sass({
            sourceComments: false,
            outputStyle: 'expanded'
        }).on( 'error', sass.logError ) )
        .pipe( autoprefixer(  ) )
        .pipe( sourcemaps.write( './maps' ) )
        .pipe( gulp.dest( './css' ) )
        .pipe( browserSync.stream() );
});

gulp.task( 'default', ['watch']);
