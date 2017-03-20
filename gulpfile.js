//****Required****/
var browserSync     = require('browser-sync');
var gulp            = require('gulp-param')(require('gulp'), process.argv)
var sass            = require('gulp-sass');
var concat          = require('gulp-concat');
var rename          = require('gulp-rename');
var uglify          = require('gulp-uglify');
//****Required****/

//****Variables****/
var reload          =   browserSync.reload;
var baseUrl         = "/Users/JulienHalgand/Documents/dev/scss/blog-writer/";
//****Variables****/

//****Functions****/
    //url
    function url(url){
        return baseUrl+url;
    }
    //
//****Functions****/

//****Paths****/
    //Sass
    var sassPaths = [
    url('bower_components/normalize.scss/sass'),
    url('bower_components/foundation-sites/scss'),
    url('bower_components/motion-ui/src'),
    ];
    //Js
    var jsPaths = [
    //url('bower_components/jquery/src/jquery.js'),
    //url('bower_components/what-input/src/what-input.js'),   
    url('bower_components/foundation-sites/dist/js/foundation.js'),
    url('js/app.js'),
    ];
//****Paths****/

//****Gulp configuration****
    //Files watching
    gulp.task('browser-sync', function() {
        browserSync.init({
            proxy: "localhost"
        });
        gulp.watch(url("scss/*.scss"), ["sass"]);       
        gulp.watch("index.php").on('change', reload);
        gulp.watch("src/**/*.php").on('change', reload);
        gulp.watch("src/Views/**/*.twig").on('change', reload);
        gulp.watch("src/assets/css/**/*.css").on('change', reload);
        //gulp.watch("src/assets/js/**/*.js", ["concat-uglify-js"]);
        
    });
    /****JS****/
        //Concat and uglify
        gulp.task('concat-uglify-js', function(){
            return gulp.src(jsPaths)
            .pipe(concat("app.js"))
            .pipe(uglify())
            .pipe(gulp.dest("src/assets/js"));
        });
    /****JS****/    
    //Compilation foundation 6
    gulp.task('sass', function() {
        return gulp.src(url("scss/app.scss"))
            .pipe(sass({
                includePaths: sassPaths,
                outputStyle: 'compressed'
            }).on('error', sass.logError))
            .pipe(gulp.dest("src/assets/css"))
            .pipe(browserSync.reload({stream:true}));    
    });
//****Gulp configuration****/

//****Execute****/
    //Lauch default task
    gulp.task('default', [
        'browser-sync',
        //'concat-uglify-js',
        //'sass',
        ]);
//****Execute****/