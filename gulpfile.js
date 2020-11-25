var gulp = require('gulp');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var browserify = require('browserify');
var babelify = require('babelify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');

const { parallel } = require('gulp');
var styleSRC = 'src/scss/style.scss';
var styleDIST = './dist/css/';
var styleWatch = 'src/scss/**/*.scss';

var jsSRC = 'src/js/script.js';
var jsDIST = './dist/js/';
var jsWatch = 'src/js/**/*.js';
var jsFILES = [jsSRC];

gulp.task('style', async function () {
	gulp
		.src(styleSRC)
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				errorLogToConsole: true,
				outputStyle: 'compressed',
			})
		)
		.on('error', console.error.bind(console))
		.pipe(
			autoprefixer({
				cascade: false,
			})
		)
		.pipe(rename({ suffix: '.min' }))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(styleDIST));
});

gulp.task('js', async function () {
	jsFILES.map(function (entry) {
		return browserify({
			entries: [entry],
		})
			.transform(babelify, { presets: ['env'] })
			.bundle()
			.pipe(source(entry))
			.pipe(rename({ extname: '.min.js' }))
			.pipe(buffer())
			.pipe(sourcemaps.init({ loadMaps: true }))
			.pipe(uglify())
			.pipe(sourcemaps.write('./'))
			.pipe(gulp.dest(jsDIST));
	});
	// gulp.src(jsSRC).pipe(gulp.dest(jsDIST));
	//browserify
	//transform babelify [env]
	//bundle
	//source
	//rename .min
	//buffer
	//init sourcemap
	//uglify
	//write sourcemap
	//dist
});

gulp.task('watch', async function () {
	gulp.watch(styleWatch, parallel('style'));
	gulp.watch(jsWatch, parallel('js'));
});

gulp.task('default', gulp.series('style', 'js', 'watch'), async function () {
	//This is body comming soon
});
