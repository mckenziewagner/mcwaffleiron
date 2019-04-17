module.exports = () => ({
  env        : 'development',
  siteUrl    : 'http://dev-cec-6412.pantheonsite.io',
  debug      : false,
  open       : true,
  staticDirs : ['./'],
  proxy      : 'http://localhost:32775',
  //proxy      : 'http://dev-cec-6412.pantheonsite.io',
  styles     : './src/styles/index.scss',
  styleVars  : require('./src/styles/variables.js'),
  files      : [
    './node_modules/hyperapp/src/index.js',
  ],
  purgeCSSWhitelist: [
    './node_modules/tiny-slider/src/**.*',
    './src/views/**.php',
    './src/views/**.blade.php',
    './src/styles/**/*.scss',
    './src/styles/**/*.css',
    './src/scripts/**/*.js',
    './src/scripts/**/*.ts',
    './src/scripts/**/*.*',
  ],
})
