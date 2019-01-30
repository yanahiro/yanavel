/**
 *
 * CSS プリコンパイル用 gulp定義
 * 
 * @author yanahiro
 * @version 1.0
 * 
 */

var gulp = require('gulp');

// style系のライブラリ
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var cssnext = require('postcss-cssnext');
var sourcemaps = require('gulp-sourcemaps');


/**
 * css コンパイル用関数
 */
gulp.task('scss', function() {
  var processors = [
      cssnext({browsers: 'last 10 versions' // last 2 versions,  '> 0%'
    })
  ];
  return gulp.src('./resources/assets/sass/style.scss')
      .pipe(sass({
        outputStyle : 'expanded'
      }))
      .pipe(postcss(processors))
      .pipe(sourcemaps.init())
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('./public/css'));
});

gulp.task("watch", function() {  
  var targets = [
    './resources/assets/sass/**'
  ];
  // gulp.watch(targets, ['scss']);
  gulp.watch(targets, gulp.series('scss'));
});

// js系ライブラリ



/**
 * リテラル設定情報
 * @type {String}
 */
var jspath = 'resources/js';

/**
 * 共通系JS処理を結合する
 * @type {Array}
 */
var files = [
  jspath + '/test.js',
];
gulp.task('js', function() {
gulp.src(files)
  .pipe(babel())
  .pipe(plumber())
  .pipe(sourcemaps.init())
  .pipe(concat('app.js'))
  .pipe(uglify())
  .pipe(rename({extname: '.min.js'}))
  .pipe(sourcemaps.write('./'))
  .pipe(gulp.dest('public/js'));
});

