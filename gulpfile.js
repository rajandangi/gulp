var gulp = require('gulp');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
const { parallel } = require('gulp');

var styleSRC = './src/scss/style.scss';
var styleDIST = './dist/css/';
var stylewatch = './src/scss/**/*.scss';

var jsSRC = './src/js/script.js';
var jsDIST = './dist/js/';
var jswatch = './src/js/**/*.js';

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
	gulp.src(jsSRC).pipe(gulp.dest(jsDIST));
});

gulp.task('default', gulp.parallel('style', 'js'));

gulp.task('watch', parallel('default'), async function () {
	gulp.watch(stylewatch, ['style']);
	gulp.watch(jswatch, ['js']);
});
