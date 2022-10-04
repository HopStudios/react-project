'use strict';

const path = require('path');
const fs = require('fs');

// Make sure any symlinks in the project folder are resolved:
// https://github.com/facebook/create-react-app/issues/637
const appDirectory = fs.realpathSync(process.cwd());
const resolveApp = relativePath => path.resolve(appDirectory, relativePath);

module.exports = {
  appJs: resolveApp('src/js/app.js'),
  appScss: resolveApp('src/scss/app.scss'),
  srcJsPath: resolveApp('src/js'),
  cacheLocation: path.resolve(
    'node_modules',
    '.cache/.eslintcache'
  ),
  buildPath: resolveApp('build'),
  addonPath: resolveApp('../../system/user/addons/react_project'),
  themesPath: resolveApp('../../themes/user/react_project'),
  distPath: resolveApp('dist/react_project'),
  distThemesPath: resolveApp('dist/themes/react_project')
};