// Load Gulp...of course
const { src, dest, task, series, watch, parallel } = require("gulp");

// CSS related plugins
var sass = require("gulp-sass");
var autoprefixer = require("gulp-autoprefixer");

// JS related plugins
var uglify = require("gulp-uglify");
var babelify = require("babelify");
var browserify = require("browserify");
var source = require("vinyl-source-stream");
var buffer = require("vinyl-buffer");
var stripDebug = require("gulp-strip-debug");

// Utility plugins
var rename = require("gulp-rename");
var sourcemaps = require("gulp-sourcemaps");
var notify = require("gulp-notify");
var options = require("gulp-options");
var gulpif = require("gulp-if");

// Browers related plugins
var browserSync = require("browser-sync").create();

// Project related variables
var projectURL = "https://dev.local/";
// var projectURL = "https://localhost:10024/";

var styleSRC = "src/scss/style.scss";
var styleURL = "./assets/css/";
var mapURL = "./";

var jsSRC = "src/js/";
// var jsAdmin = "myscript.js";
// var jsField = "fields.js";
// var jsLayoutTab = "layout-tab.js";
// var jsLayoutCard = "layout-card.js";
// var jsStep = "step-api.js";
// var jsSetting = "settings-api.js";
// var jsFiles = [jsAdmin, jsField, jsLayoutTab, jsLayoutCard, jsStep, jsSetting];
var jsFiles = ["script.js"];
var jsURL = "./assets/js/";

var styleWatch = "src/scss/**/*.scss";
var jsWatch = "src/js/**/*.js";
var phpWatch = "./**/*.php";

function css(done) {
  src([styleSRC])
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        errLogToConsole: true,
        outputStyle: "compressed",
      })
    )
    .on("error", console.error.bind(console))
    .pipe(
      autoprefixer({
        // browsers: ["last 2 versions", "> 5%", "Firefox ESR"]
        overrideBrowserslist: ["last 2 versions", "> 1%", "not dead"],
      })
    )
    .pipe(sourcemaps.write(mapURL))
    .pipe(dest(styleURL))
    .pipe(browserSync.stream());
  done();
}

function js(done) {
  jsFiles.map(function (entry) {
    return (
      browserify({
        entries: [jsSRC + entry],
      })
        .transform(babelify, { presets: ["@babel/preset-env"] })
        .bundle()
        .pipe(source(entry))
        .pipe(buffer())
        .pipe(gulpif(options.has("production"), stripDebug()))
        .pipe(uglify())
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(rename({ suffix: ".min" }))
        // .pipe(sourcemaps.write("."))
        .pipe(dest(jsURL))
        .pipe(browserSync.stream())
    );
  });
  done();
}

function reload(done) {
  browserSync.reload();
  done();
}

function browser_sync() {
  browserSync.init({
    proxy: projectURL,
    // https: {
    //   key: "",
    //   cert: "",
    // },
    injectChanges: true,
    open: false,
    notify: false,
  });
}

function watch_files() {
  watch(phpWatch, reload);
  watch(styleWatch, css);
  watch(jsWatch, series(js, reload));
  src(jsSRC + "script.js").pipe(
    notify({ message: "Gulp is Watching, Happy Coding!" })
  );
}

task("css", css);
task("js", js);
task("default", series(css, js));
task("watch", parallel(browser_sync, watch_files));
