const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const cleanCSS = require('gulp-clean-css');
const browserSync = require('browser-sync').create();

// Caminhos dos arquivos
const paths = {
	styles: {
		src: ['src/scss/**/*.scss'],
		dest: 'dist/css'
	},
	scripts: {
		src: ['src/js/*.js'],
		dest: 'dist/js'
	},
	libraries: {
		src: ['src/js/libraries/*.js'],
		dest: 'dist/js'
	},
	php: {
		src: './**/*.php'
	}
};

// Tarefa para compilar o SCSS para CSS, adicionar prefixos e minificar
function styles() {
	return gulp.src(paths.styles.src)
		.pipe(concat('theme.css'))
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss([autoprefixer(), cssnano()]))
		.pipe(cleanCSS())
		.pipe(gulp.dest(paths.styles.dest))
		.pipe(browserSync.stream());
}

// Tarefa para concatenar e minificar JavaScript
function scripts() {
	return gulp.src(paths.scripts.src)
		.pipe(concat('theme.js'))
		.pipe(uglify())
		.pipe(gulp.dest(paths.scripts.dest))
		.pipe(browserSync.stream());
}

// Tarefa para concatenar e minificar Libraries
function libraries() {
	return gulp.src(paths.libraries.src)
		.pipe(concat('libraries.js'))
		.pipe(uglify())
		.pipe(gulp.dest(paths.libraries.dest))
		.pipe(browserSync.stream());
}

// Tarefa para iniciar o BrowserSync
function serve() {
	browserSync.init({
    proxy: 'olivasdigital',
  });

	gulp.watch(paths.styles.src, styles);
	gulp.watch(paths.scripts.src, scripts);
	gulp.watch(paths.libraries.src, libraries);
	gulp.watch(paths.php.src).on('change', browserSync.reload);
}

// Definir as tarefas padrão
const build = gulp.series(gulp.parallel(styles, scripts, libraries), serve);
gulp.task('default', build);