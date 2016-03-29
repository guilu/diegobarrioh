module.exports = function (grunt) {

    var appResourceSassDir;

    var bowerCssFiles, bowerJsFiles, bowerFontFiles, bowerCssMinFiles, bowerJsMinFiles;

    appResourceSassDir = {
        'scss': 'app/Resources/assets/scss/**/*.scss'
    };

    bowerCssFiles = {
        'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
        'css/font-awesome.css': 'font-awesome/css/font-awesome.css'
    };
    bowerCssMinFiles = {
        'css/bootstrap.min.css': 'bootstrap/dist/css/bootstrap.min.css',
        'css/font-awesome.min.css': 'font-awesome/css/font-awesome.min.css'
    };
    bowerJsFiles = {
        'js/plugins/jquery.js': 'jquery/dist/jquery.js',
        'js/plugins/bootstrap.js': 'bootstrap/dist/js/bootstrap.js'
    };
    bowerJsMinFiles = {
        'js/plugins/jquery.min.js': 'jquery/dist/jquery.min.js',
        'js/plugins/bootstrap.min.js': 'bootstrap/dist/js/bootstrap.min.js'
    };

    bowerFontFiles = {
        'fonts': ['font-awesome/fonts','bootstrap/fonts']
    };

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        clean: {
            build: {
                src: [ 'web/css','web/js','web/fonts','web/images' ]
            }
        },
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web'
            },
            scripts: {
                files: bowerJsFiles
            },
            scripts_min: {
                files: bowerJsMinFiles
            },
            stylesheets: {
                files: bowerCssFiles
            },
            stylesheets_min: {
                files: bowerCssMinFiles
            },
            fonts: {
                files: bowerFontFiles
            }
        },
        copy: {
            images: {
                expand: true,
                cwd: 'app/Resources/assets/images',
                src: '*',
                dest: 'web/images/'
            },
            fonts: {
                expand: true,
                cwd: 'app/Resources/assets/fonts',
                src: '*',
                dest: 'web/fonts/'
            }
        },
        sass: {
            dist: {
                files: [{
                    expand: true,
                    cwd: 'app/Resources/assets/scss',
                    src: ['*.scss'],
                    dest: 'app/Resources/assets/css',
                    ext: '.css'
                }]
            }
        },
        concat: {
            options: {
                stripBanners: true
            },
            plugins_css: {
                src: ['web/css/*.css'],
                dest: 'web/css/plugins.css'
            },
            plugins_css_min: {
                src: ['web/css/*.min.css'],
                dest: 'web/css/plugins.min.css'
            },
            plugins_js: {
                src: ['web/js/plugins/jquery.js','web/js/plugins/bootstrap.js'],
                dest: 'web/js/plugins/plugins.js'
            },
            plugins_js_min: {
                src: ['web/js/plugins/jquery.min.js','web/js/plugins/bootstrap.min.js'],
                dest: 'web/js/plugins/plugins.min.js'
            },
            app_css: {
                src: ['app/Resources/assets/css/*.css'],
                dest: 'web/css/app.css'
            },
            app_js: {
                src: ['app/Resources/assets/js/app/*.js'],
                dest: 'web/js/app.js'
            }
        },
        cssmin : {
            target: {
                files: {
                    'web/css/app.min.css': ['web/css/plugins/plugins.css','web/css/app.css']
                }
            }
        },
        uglify : {
            js: {
                files: {
                    'web/js/app.min.js': 'web/js/app.js'
                }
            }
        },
        watch: {
            appResourceScss: {
                files: appResourceSassDir.scss,
                tasks: ['sass','concat:app_css']
            }
        }

    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('dev', ['clean','bowercopy:scripts','bowercopy:stylesheets','bowercopy:fonts','sass', 'concat:plugins_css', 'concat:plugins_js','concat:app_css','concat:app_js' ]);
    grunt.registerTask('dist', ['clean','bowercopy:scripts_min','bowercopy:stylesheets_min','bowercopy:fonts','sass', 'concat:plugins_css_min', 'concat:plugins_js_min','concat:app_css','concat:app_js' , 'cssmin', 'uglify']);
};